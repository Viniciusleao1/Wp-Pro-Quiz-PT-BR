<?php

class WpProQuiz_Controller_Preview extends WpProQuiz_Controller_Controller
{

    public function route()
    {

        wp_enqueue_script(
            'wpProQuiz_front_javascript',
            plugins_url('js/wpProQuiz_front' . (WPPROQUIZ_DEV ? '' : '.min') . '.js', WPPROQUIZ_FILE),
            array('jquery', 'jquery-ui-sortable'),
            WPPROQUIZ_VERSION
        );

        wp_localize_script('wpProQuiz_front_javascript', 'WpProQuizGlobal', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'loadData' => __('Loading', 'wp-pro-quiz'),
            'questionNotSolved' => __('Você deve responder a esta pergunta.', 'wp-pro-quiz'),
            'questionsNotSolved' => __('Você deve responder a todas as perguntas antes de concluir o questionário.',
                'wp-pro-quiz'),
            'fieldsNotFilled' => __('Todos os campos devem ser preenchidos.', 'wp-pro-quiz')
        ));

        wp_enqueue_style(
            'wpProQuiz_front_style',
            plugins_url('css/wpProQuiz_front' . (WPPROQUIZ_DEV ? '' : '.min') . '.css', WPPROQUIZ_FILE),
            array(),
            WPPROQUIZ_VERSION
        );

        $this->showAction($_GET['id']);
    }

    public function showAction($id)
    {
        $view = new WpProQuiz_View_FrontQuiz();

        $quizMapper = new WpProQuiz_Model_QuizMapper();
        $questionMapper = new WpProQuiz_Model_QuestionMapper();
        $categoryMapper = new WpProQuiz_Model_CategoryMapper();
        $formMapper = new WpProQuiz_Model_FormMapper();

        $quiz = $quizMapper->fetch($id);

        if ($quiz->isShowMaxQuestion() && $quiz->getShowMaxQuestionValue() > 0) {

            $value = $quiz->getShowMaxQuestionValue();

            if ($quiz->isShowMaxQuestionPercent()) {
                $count = $questionMapper->count($id);

                $value = ceil($count * $value / 100);
            }

            $question = $questionMapper->fetchAll($id, true, $value);

        } else {
            $question = $questionMapper->fetchAll($id);
        }

        $view->quiz = $quiz;
        $view->question = $question;
        $view->category = $categoryMapper->fetchByQuiz($quiz->getId());
        $view->forms = $formMapper->fetch($quiz->getId());

        $view->show(true);
    }
}