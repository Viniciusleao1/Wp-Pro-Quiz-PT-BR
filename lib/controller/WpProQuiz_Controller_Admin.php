<?php

class WpProQuiz_Controller_Admin
{

    protected $_ajax;

    public function __construct()
    {

        $this->_ajax = new WpProQuiz_Controller_Ajax();
        $this->_ajax->init();

        add_action('admin_menu', array($this, 'register_page'));

        add_filter('set-screen-option', array($this, 'setScreenOption'), 10, 3);

        WpProQuiz_Helper_TinyMcePlugin::init();
    }

    public function setScreenOption($status, $option, $value)
    {
        if (in_array($option, array('wp_pro_quiz_quiz_overview_per_page', 'wp_pro_quiz_question_overview_per_page'))) {
            return $value;
        }

        return $status;
    }

    private function localizeScript()
    {
        global $wp_locale;

        $isRtl = isset($wp_locale->is_rtl) ? $wp_locale->is_rtl : false;

        $translation_array = array(
            'delete_msg' => __('Você realmente deseja excluir o questionário/pergunta?', 'wp-pro-quiz'),
            'no_title_msg' => __('O título não está preenchido!', 'wp-pro-quiz'),
            'no_question_msg' => __('Nenhuma pergunta depositada!', 'wp-pro-quiz'),
            'no_correct_msg' => __('A resposta correta não foi selecionada!', 'wp-pro-quiz'),
            'no_answer_msg' => __('Nenhuma resposta depositada!', 'wp-pro-quiz'),
            'no_quiz_start_msg' => __('Nenhuma descrição do questionário preenchida!', 'wp-pro-quiz'),
            'fail_grade_result' => __('Os valores percentuais no texto do resultado estão incorretos.', 'wp-pro-quiz'),
            'no_nummber_points' => __('Nenhum número no campo “Pontos” ou menor que 1', 'wp-pro-quiz'),
            'no_nummber_points_new' => __('Nenhum número no campo “Pontos” ou menor que 0', 'wp-pro-quiz'),
            'no_selected_quiz' => __('Nenhum questionário selecionado', 'wp-pro-quiz'),
            'reset_statistics_msg' => __('Você realmente deseja redefinir a estatística?', 'wp-pro-quiz'),
            'no_data_available' => __('Não há dados disponíveis', 'wp-pro-quiz'),
            'no_sort_element_criterion' => __('Nenhum elemento de classificação no critério', 'wp-pro-quiz'),
            'dif_points' => __('"Pontos diferentes para cada resposta" não é possível na escolha "Livre"', 'wp-pro-quiz'),
            'category_no_name' => __('Você deve especificar um nome.', 'wp-pro-quiz'),
            'confirm_delete_entry' => __('Esta entrada realmente deveria ser excluída?', 'wp-pro-quiz'),
            'not_all_fields_completed' => __('Nem todos os campos preenchidos.', 'wp-pro-quiz'),
            'temploate_no_name' => __('Você deve especificar um nome de modelo.', 'wp-pro-quiz'),
            'closeText' => __('Fechar', 'wp-pro-quiz'),
            'currentText' => __('Hoje', 'wp-pro-quiz'),
            'monthNames' => array_values($wp_locale->month),
            'monthNamesShort' => array_values($wp_locale->month_abbrev),
            'dayNames' => array_values($wp_locale->weekday),
            'dayNamesShort' => array_values($wp_locale->weekday_abbrev),
            'dayNamesMin' => array_values($wp_locale->weekday_initial),
//			'dateFormat'        => WpProQuiz_Helper_Until::convertPHPDateFormatToJS(get_option('date_format', 'm/d/Y')),
            //e.g. "9 de setembro de 2014" -> change to "hard" dateformat
            'dateFormat' => 'mm/dd/yy',
            'firstDay' => get_option('start_of_week'),
            'isRTL' => $isRtl
        );

        wp_localize_script('wpProQuiz_admin_javascript', 'wpProQuizLocalize', $translation_array);
    }

    public function enqueueScript()
    {
        wp_enqueue_script(
            'wpProQuiz_admin_javascript',
            plugins_url('js/wpProQuiz_admin' . (WPPROQUIZ_DEV ? '' : '.min') . '.js', WPPROQUIZ_FILE),
            array('jquery', 'jquery-ui-sortable', 'jquery-ui-datepicker'),
            WPPROQUIZ_VERSION
        );


        wp_enqueue_style(
            'jquery-ui',
            plugins_url('css/jquery-ui.min.css', WPPROQUIZ_FILE),
            array(),
            '1.11.4'
        );

        $this->localizeScript();
    }

    public function register_page()
    {
        $pages = array();

        $pages[] = add_menu_page(
            'WP-Pro-Quiz',
            'WP-Pro-Quiz',
            'wpProQuiz_show',
            'wpProQuiz',
            array($this, 'route'));

        $pages[] = add_submenu_page(
            'wpProQuiz',
            __('Configurações globais', 'wp-pro-quiz'),
            __('Configurações globais', 'wp-pro-quiz'),
            'wpProQuiz_change_settings',
            'wpProQuiz_glSettings',
            array($this, 'route'));

        $pages[] = add_submenu_page(
            'wpProQuiz',
            __('Suporte & mais', 'wp-pro-quiz'),
            __('Suporte & mais', 'wp-pro-quiz'),
            'wpProQuiz_show',
            'wpProQuiz_wpq_support',
            array($this, 'route'));

        foreach ($pages as $p) {
            add_action('admin_print_scripts-' . $p, array($this, 'enqueueScript'));
            add_action('load-' . $p, array($this, 'routeLoadAction'));
        }
    }

    public function routeLoadAction()
    {
        $screen = get_current_screen();

        if (!empty($screen)) {
            // Workaround for wp_ajax_hidden_columns() with sanitize_key()
            $name = strtolower($screen->id);

            if (!empty($_GET['module'])) {
                $name .= '_' . strtolower($_GET['module']);
            }

            set_current_screen($name);

            $screen = get_current_screen();
        }

        $helperView = new WpProQuiz_View_GlobalHelperTabs();

        $screen->add_help_tab($helperView->getHelperTab());
        $screen->set_help_sidebar($helperView->getHelperSidebar());

        $this->_route(true);
    }

    public function route()
    {
        $this->_route();
    }

    private function _route($routeAction = false)
    {
        $module = isset($_GET['module']) ? $_GET['module'] : 'overallView';

        if (isset($_GET['page'])) {
            if (preg_match('#wpProQuiz_(.+)#', trim($_GET['page']), $matches)) {
                $module = $matches[1];
            }
        }

        $c = null;

        switch ($module) {
            case 'overallView':
                $c = new WpProQuiz_Controller_Quiz();
                break;
            case 'question':
                $c = new WpProQuiz_Controller_Question();
                break;
            case 'preview':
                $c = new WpProQuiz_Controller_Preview();
                break;
            case 'statistics':
                $c = new WpProQuiz_Controller_Statistics();
                break;
            case 'importExport':
                $c = new WpProQuiz_Controller_ImportExport();
                break;
            case 'glSettings':
                $c = new WpProQuiz_Controller_GlobalSettings();
                break;
            case 'styleManager':
                $c = new WpProQuiz_Controller_StyleManager();
                break;
            case 'toplist':
                $c = new WpProQuiz_Controller_Toplist();
                break;
            case 'wpq_support':
                $c = new WpProQuiz_Controller_WpqSupport();
                break;
            case 'info_adaptation':
                $c = new WpProQuiz_Controller_InfoAdaptation();
                break;
            case 'questionExport':
                $c = new WpProQuiz_Controller_QuestionExport();
                break;
            case 'questionImport':
                $c = new WpProQuiz_Controller_QuestionImport();
                break;
            case 'statistic_export':
                $c = new WpProQuiz_Controller_StatisticExport();
                break;
        }

        if ($c !== null) {
            if ($routeAction) {
                if (method_exists($c, 'routeAction')) {
                    $c->routeAction();
                }
            } else {
                $c->route();
            }
        }
    }
}
