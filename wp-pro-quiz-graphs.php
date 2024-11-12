<?php

class WpProQuiz_Graphs {

    public function __construct() {
        add_shortcode('wp_pro_quiz_pie_chart', [$this, 'renderPieChart']);
        add_shortcode('wp_pro_quiz_line_chart', [$this, 'renderLineChart']);
        add_shortcode('wp_pro_quiz_bar_chart', [$this, 'renderBarChart']);
        add_shortcode('wp_pro_quiz_extra_line_chart', [$this, 'renderExtraLineChart']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueECharts']);
    }

    public function enqueueECharts() {
        wp_enqueue_script('echarts', 'https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js', [], null, true);
    }

    private function getQuizData($quiz_id, $user_id) {
        global $wpdb;

        // Coletando dados do banco
        $attemptScores = $wpdb->get_col($wpdb->prepare(
            "SELECT points FROM wp_wp_pro_quiz_toplist WHERE quiz_id = %d AND user_id = %d ORDER BY date ASC",
            $quiz_id,
            $user_id
        )) ?: [0];

        $attemptLabels = $wpdb->get_col($wpdb->prepare(
            "SELECT DATE_FORMAT(date, '%%d/%%m/%%Y') FROM wp_wp_pro_quiz_toplist WHERE quiz_id = %d AND user_id = %d ORDER BY date ASC",
            $quiz_id,
            $user_id
        )) ?: ["N/A"];

        $correctIncorrectCounts = $wpdb->get_row($wpdb->prepare(
            "SELECT COALESCE(SUM(correct_count), 0) as correct_count, COALESCE(SUM(incorrect_count), 0) as incorrect_count
            FROM wp_wp_pro_quiz_statistic
            WHERE question_id IN (SELECT id FROM wp_wp_pro_quiz_question WHERE quiz_id = %d)",
            $quiz_id
        ));

        $questionTitles = $wpdb->get_col($wpdb->prepare(
            "SELECT title FROM wp_wp_pro_quiz_question WHERE quiz_id = %d ORDER BY sort ASC",
            $quiz_id
        )) ?: ["N/A"];

        $userScores = $wpdb->get_col($wpdb->prepare(
            "SELECT correct_count FROM wp_wp_pro_quiz_statistic WHERE question_id IN (SELECT id FROM wp_wp_pro_quiz_question WHERE quiz_id = %d) AND statistic_ref_id IN (SELECT statistic_ref_id FROM wp_wp_pro_quiz_statistic_ref WHERE user_id = %d)",
            $quiz_id,
            $user_id
        )) ?: [0];

        return [
            'attemptScores' => $attemptScores,
            'attemptLabels' => $attemptLabels,
            'correctCount' => $correctIncorrectCounts->correct_count,
            'incorrectCount' => $correctIncorrectCounts->incorrect_count,
            'questionTitles' => $questionTitles,
            'userScores' => $userScores
        ];
    }

    public function renderPieChart($atts) {
        // Recebendo o ID do Quiz a partir do atributo
        $atts = shortcode_atts(['quiz_id' => 0], $atts);
        $quiz_id = intval($atts['quiz_id']);
        $user_id = get_current_user_id();
        
        if ($quiz_id === 0) {
            return 'Quiz ID inválido.';
        }
        
        $data = $this->getQuizData($quiz_id, $user_id);
        ob_start(); ?>
        <div id="pieChart" style="width: 100%; height: 400px;"></div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var pieChart = echarts.init(document.getElementById('pieChart'));
                pieChart.setOption({
                    title: { text: 'Acertos e Erros', left: 'center' },
                    tooltip: { trigger: 'item' },
                    series: [{
                        name: 'Respostas',
                        type: 'pie',
                        radius: '50%',
                        data: [
                            { value: <?php echo esc_js($data['correctCount']); ?>, name: 'Acertos' },
                            { value: <?php echo esc_js($data['incorrectCount']); ?>, name: 'Erros' }
                        ],
                        emphasis: { itemStyle: { shadowBlur: 10, shadowOffsetX: 0, shadowColor: 'rgba(0, 0, 0, 0.5)' }}
                    }]
                });
            });
        </script>
        <?php
        return ob_get_clean();
    }

    public function renderLineChart($atts) {
        // Recebendo o ID do Quiz a partir do atributo
        $atts = shortcode_atts(['quiz_id' => 0], $atts);
        $quiz_id = intval($atts['quiz_id']);
        $user_id = get_current_user_id();
        
        if ($quiz_id === 0) {
            return 'Quiz ID inválido.';
        }
        
        $data = $this->getQuizData($quiz_id, $user_id);
        ob_start(); ?>
        <div id="lineChart" style="width: 100%; height: 400px;"></div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var lineChart = echarts.init(document.getElementById('lineChart'));
                lineChart.setOption({
                    title: { text: 'Histórico de Acertos', left: 'center' },
                    tooltip: { trigger: 'axis' },
                    xAxis: { type: 'category', data: <?php echo json_encode($data['questionTitles']); ?> },
                    yAxis: { type: 'value' },
                    series: [{
                        data: <?php echo json_encode($data['userScores']); ?>,
                        type: 'line',
                        smooth: true,
                        areaStyle: {}
                    }]
                });
            });
        </script>
        <?php
        return ob_get_clean();
    }

    public function renderBarChart($atts) {
        // Recebendo o ID do Quiz a partir do atributo
        $atts = shortcode_atts(['quiz_id' => 0], $atts);
        $quiz_id = intval($atts['quiz_id']);
        $user_id = get_current_user_id();
        
        if ($quiz_id === 0) {
            return 'Quiz ID inválido.';
        }
        
        $data = $this->getQuizData($quiz_id, $user_id);
        ob_start(); ?>
        <div id="barChart" style="width: 100%; height: 400px;"></div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var barChart = echarts.init(document.getElementById('barChart'));
                barChart.setOption({
                    title: { text: 'Pontuação por Tentativa', left: 'center' },
                    tooltip: { trigger: 'axis' },
                    xAxis: { type: 'category', data: <?php echo json_encode($data['attemptLabels']); ?> },
                    yAxis: { type: 'value' },
                    series: [{
                        data: <?php echo json_encode($data['attemptScores']); ?>,
                        type: 'bar',
                        barWidth: '50%',
                        itemStyle: { color: 'rgba(255, 99, 132, 0.7)' }
                    }]
                });
            });
        </script>
        <?php
        return ob_get_clean();
    }

    public function renderExtraLineChart($atts) {
        // Recebendo o ID do Quiz a partir do atributo
        $atts = shortcode_atts(['quiz_id' => 0], $atts);
        $quiz_id = intval($atts['quiz_id']);
        $user_id = get_current_user_id();
        
        if ($quiz_id === 0) {
            return 'Quiz ID inválido.';
        }
        
        $data = $this->getQuizData($quiz_id, $user_id);
        ob_start(); ?>
        <div id="extraLineChart" style="width: 100%; height: 400px;"></div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var extraLineChart = echarts.init(document.getElementById('extraLineChart'));
                extraLineChart.setOption({
                    title: { text: 'Desempenho Geral', left: 'center' },
                    tooltip: { trigger: 'axis' },
                    xAxis: { type: 'category', data: <?php echo json_encode($data['attemptLabels']); ?> },
                    yAxis: { type: 'value' },
                    series: [{
                        data: <?php echo json_encode($data['attemptScores']); ?>,
                        type: 'line',
                        smooth: true,
                        lineStyle: { color: 'rgba(153, 102, 255, 1)' },
                        areaStyle: { color: 'rgba(153, 102, 255, 0.2)' }
                    }]
                });
            });
        </script>
        <?php
        return ob_get_clean();
    }
}

// Inicialização da classe para os gráficos
new WpProQuiz_Graphs();
?>
