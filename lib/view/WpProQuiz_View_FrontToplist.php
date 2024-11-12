<?php

/**
 * @property WpProQuiz_Model_Quiz quiz
 * @property bool inQuiz
 * @property int points
 */

class WpProQuiz_View_Fronttoplist extends WpProQuiz_View_View
{
    public function show()
    {
        global $wpdb;

        $quiz_id = $this->quiz->getId();
        $user_id = get_current_user_id();
        
        // Pontuação por Tentativa
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

        // Correções e Erros
        $correctIncorrectCounts = $wpdb->get_row($wpdb->prepare(
            "SELECT COALESCE(SUM(correct_count), 0) as correct_count, COALESCE(SUM(incorrect_count), 0) as incorrect_count
             FROM wp_wp_pro_quiz_statistic
             WHERE question_id IN (SELECT id FROM wp_wp_pro_quiz_question WHERE quiz_id = %d)",
            $quiz_id
        ));

        // Títulos das perguntas e número de acertos
        $questionTitles = $wpdb->get_col($wpdb->prepare(
            "SELECT title FROM wp_wp_pro_quiz_question WHERE quiz_id = %d ORDER BY sort ASC",
            $quiz_id
        )) ?: ["N/A"];

        $userScores = $wpdb->get_col($wpdb->prepare(
            "SELECT correct_count FROM wp_wp_pro_quiz_statistic WHERE question_id IN (SELECT id FROM wp_wp_pro_quiz_question WHERE quiz_id = %d) AND statistic_ref_id IN (SELECT statistic_ref_id FROM wp_wp_pro_quiz_statistic_ref WHERE user_id = %d)",
            $quiz_id,
            $user_id
        )) ?: [0];

        ?>
        <div style="margin-bottom: 30px; margin-top: 10px;" class="wpProQuiz_toplist" data-quiz_id="<?php echo $quiz_id; ?>">
            <h2><?php _e('Leaderboard', 'wp-pro-quiz'); ?>: <?php echo $this->quiz->getName(); ?></h2>
            <table class="wpProQuiz_toplistTable">
                <caption><?php printf(__('máximo de %s pontos', 'wp-pro-quiz'), $this->points); ?></caption>
                <thead>
                    <tr>
                        <th style="width: 40px;"><?php _e('Pos.', 'wp-pro-quiz'); ?></th>
                        <th style="text-align: left !important;"><?php _e('Nome', 'wp-pro-quiz'); ?></th>
                        <th style="width: 140px;"><?php _e('Entrou em', 'wp-pro-quiz'); ?></th>
                        <th style="width: 60px;"><?php _e('Pontos', 'wp-pro-quiz'); ?></th>
                        <th style="width: 75px;"><?php _e('Resultado', 'wp-pro-quiz'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5"><?php _e('A tabela está carregando', 'wp-pro-quiz'); ?></td>
                    </tr>
                    <tr style="display: none;">
                        <td colspan="5"><?php _e('Não há dados disponíveis', 'wp-pro-quiz'); ?></td>
                    </tr>
                    <tr style="display: none;">
                        <td></td>
                        <td style="text-align: left !important;"></td>
                        <td style=" color: rgb(124, 124, 124); font-size: x-small;"></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ECharts via CDN -->
        <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>

        <!-- Gráficos empilhados -->
        <div id="pieChart" style="width: 100%; height: 400px; margin-bottom: 20px;"></div>
        <div id="lineChart" style="width: 100%; height: 400px; margin-bottom: 20px;"></div>
        <div id="barChart" style="width: 100%; height: 400px; margin-bottom: 20px;"></div>
        <div id="extraLineChart" style="width: 100%; height: 400px; margin-bottom: 20px;"></div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Inicializa os gráficos ECharts
                var pieChart = echarts.init(document.getElementById('pieChart'));
                var lineChart = echarts.init(document.getElementById('lineChart'));
                var barChart = echarts.init(document.getElementById('barChart'));
                var extraLineChart = echarts.init(document.getElementById('extraLineChart'));

                // Configuração do Gráfico de Pizza
                pieChart.setOption({
                    title: { text: 'Acertos e Erros', left: 'center' },
                    tooltip: { trigger: 'item' },
                    series: [{
                        name: 'Respostas',
                        type: 'pie',
                        radius: '50%',
                        data: [
                            { value: <?php echo esc_js($correctIncorrectCounts->correct_count); ?>, name: 'Acertos' },
                            { value: <?php echo esc_js($correctIncorrectCounts->incorrect_count); ?>, name: 'Erros' }
                        ],
                        emphasis: { itemStyle: { shadowBlur: 10, shadowOffsetX: 0, shadowColor: 'rgba(0, 0, 0, 0.5)' }}
                    }]
                });

                // Configuração do Gráfico de Linha
                lineChart.setOption({
                    title: { text: 'Histórico de Acertos', left: 'center' },
                    tooltip: { trigger: 'axis' },
                    xAxis: { type: 'category', data: <?php echo json_encode($questionTitles); ?> },
                    yAxis: { type: 'value' },
                    series: [{
                        data: <?php echo json_encode($userScores); ?>,
                        type: 'line',
                        smooth: true,
                        areaStyle: {}
                    }]
                });

                // Configuração do Gráfico de Barras
                barChart.setOption({
                    title: { text: 'Pontuação por Tentativa', left: 'center' },
                    tooltip: { trigger: 'axis' },
                    xAxis: { type: 'category', data: <?php echo json_encode($attemptLabels); ?> },
                    yAxis: { type: 'value' },
                    series: [{
                        data: <?php echo json_encode($attemptScores); ?>,
                        type: 'bar',
                        barWidth: '50%',
                        itemStyle: { color: 'rgba(255, 99, 132, 0.7)' }
                    }]
                });

                // Configuração do Gráfico de Linha Adicional
                extraLineChart.setOption({
                    title: { text: 'Desempenho Geral', left: 'center' },
                    tooltip: { trigger: 'axis' },
                    xAxis: { type: 'category', data: <?php echo json_encode($attemptLabels); ?> },
                    yAxis: { type: 'value' },
                    series: [{
                        data: <?php echo json_encode($attemptScores); ?>,
                        type: 'line',
                        smooth: true,
                        lineStyle: { color: 'rgba(153, 102, 255, 1)' },
                        areaStyle: { color: 'rgba(153, 102, 255, 0.2)' }
                    }]
                });
            });
        </script>
        <?php
    }
}
