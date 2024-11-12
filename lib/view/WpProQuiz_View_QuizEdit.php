<?php

/**
 * @property WpProQuiz_Model_Form[] forms
 * @property WpProQuiz_Model_Quiz quiz
 * @property array prerequisiteQuizList
 * @property WpProQuiz_Model_Template[] templates
 * @property array quizList
 * @property bool captchaIsInstalled
 * @property WpProQuiz_Model_Category[] categories
 * @property string header
 */
class WpProQuiz_View_QuizEdit extends WpProQuiz_View_View
{
    public function show()
    {
        $this->inlineStyle();
        ?>
        <div class="wrap wpProQuiz_quizEdit">
            <h2 style="margin-bottom: 10px;"><?php echo $this->header; ?></h2>

            <form method="post"
                  action="<?php echo admin_url('admin.php?page=wpProQuiz&action=addEdit&quizId=' . $this->quiz->getId()); ?>">

                <input type="hidden" name="ajax_quiz_id" value="<?php echo $this->quiz->getId(); ?>">

                <a style="float: left;" class="button-secondary" href="<?php echo admin_url('admin.php?page=wpProQuiz'); ?>">
                    <?php _e('voltar para a visão geral', 'wp-pro-quiz'); ?>
                </a>

                <div style="float: right;">
                    <select name="templateLoadId">
                        <?php
                        foreach ($this->templates as $template) {
                            echo '<option value="', $template->getTemplateId(), '">', esc_html($template->getName()), '</option>';
                        }
                        ?>
                    </select>
                    <input type="submit" name="templateLoad" value="<?php _e('carregar template', 'wp-pro-quiz'); ?>"
                           class="button-primary">
                </div>
                <div style="clear: both;"></div>

                <?php $this->tabBar(); ?>
                <?php $this->tabContents() ?>

                <div id="poststuff">

                    <div style="float: left;">
                        <input type="submit" name="submit" class="button-primary" id="wpProQuiz_save"
                               value="<?php _e('Salvar', 'wp-pro-quiz'); ?>">
                    </div>
                    <div style="float: right;">
                        <input type="text" placeholder="<?php _e('nome do template', 'wp-pro-quiz'); ?>"
                               class="regular-text" name="templateName" style="border: 1px solid rgb(255, 134, 134);">
                        <select name="templateSaveList">
                            <option value="0">=== <?php _e('criar novo template', 'wp-pro-quiz'); ?> ===</option>
                            <?php
                            foreach ($this->templates as $template) {
                                echo '<option value="', $template->getTemplateId(), '">', esc_html($template->getName()), '</option>';
                            }
                            ?>
                        </select>

                        <input type="submit" name="template" class="button-primary" id="wpProQuiz_saveTemplate"
                               value="<?php _e('Salvar como template', 'wp-pro-quiz'); ?>">
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </form>
        </div>
        <?php
    }

    private function inlineStyle()
    {
        ?>
        <style>
            .wpProQuiz_quizModus th, .wpProQuiz_quizModus td {
                border-right: 1px solid #A0A0A0;
                padding: 5px;
            }

            .wpProQuiz_demoBox {
                position: relative;
            }
            .wpProQuiz-tab-content:not(.wpProQuiz-tab-content-active) {
                display: none;
            }
            .wpProQuiz_demoBox > div, .wpProQuiz_demoBox > span {
                z-index: 9999999;
                position: absolute;
                background-color: #E9E9E9;
                padding: 10px;
                box-shadow: 0 0 10px 4px rgb(44, 44, 44);
                display: none;
            }
        </style>
        <?php
    }

    private function tabBar()
    {
        ?>
        <div class="nav-tab-wrapper wpProQuiz-top-tab-wrapper">
            <a href="#tabGeneral" data-tab="tabGeneral" class="nav-tab nav-tab-active"><?php _e('Em geral', 'wp-pro-quiz'); ?></a>
            <a href="#tabResult" data-tab="tabResult" class="nav-tab "><?php _e('Resultado', 'wp-pro-quiz'); ?></a>
            <a href="#tabOptions" data-tab="tabOptions" class="nav-tab "><?php _e('Opções', 'wp-pro-quiz'); ?></a>
            <a href="#tabCustomFields" data-tab="tabCustomFields" class="nav-tab "><?php _e('Campos personalizados', 'wp-pro-quiz'); ?></a>
            <a href="#tabLeaderboard" data-tab="tabLeaderboard" class="nav-tab "><?php _e('Leaderboard', 'wp-pro-quiz'); ?></a>
            <a href="#tabEmailSettings" data-tab="tabEmailSettings" class="nav-tab "><?php _e('Configurações de e-mail', 'wp-pro-quiz'); ?></a>
            <a href="#tabPlugins" data-tab="tabPlugins" class="nav-tab "><?php _e('Plugins', 'wp-pro-quiz'); ?></a>
            <?php do_action('wpProQuiz_quizEdit_tab_wrapper', $this); ?>
        </div>
        <?php
    }

    private function tabContents()
    {
        ?>
        <div id="poststuff">
            <div id="tabGeneral" class="wpProQuiz-tab-content wpProQuiz-tab-content-active">
                <?php $this->tabGerneral(); ?>
            </div>
            <div id="tabEmailSettings" class="wpProQuiz-tab-content">
                <?php $this->tabEmailSettings(); ?>
            </div>
            <div id="tabCustomFields" class="wpProQuiz-tab-content">
                <?php $this->tabCustomFields(); ?>
            </div>
            <div id="tabLeaderboard" class="wpProQuiz-tab-content">
                <?php $this->tabLeaderboard(); ?>
            </div>
            <div id="tabResult" class="wpProQuiz-tab-content">
                <?php $this->tabResult(); ?>
            </div>
            <div id="tabOptions" class="wpProQuiz-tab-content">
                <?php $this->tabOptions(); ?>
            </div>
            <div id="tabPlugins" class="wpProQuiz-tab-content">
                <?php $this->tabPlugins(); ?>
            </div>
            <?php do_action('wpProQuiz_quizEdit_tab_content', $this); ?>
        </div>
        <?php
    }

    private function tabGerneral()
    {
        $this->postBoxTitle();
        $this->postBoxCategory();
        $this->postBoxQuizMode();
        $this->postBoxQuizDescription();

        do_action('wpProQuiz_quizEdit_tab_content_gerneral', $this);
    }

    private function tabEmailSettings()
    {
        $this->postBoxAdminEmailOption();
        $this->postBoxUserEmailOption();

        do_action('wpProQuiz_quizEdit_tab_content_email_settings', $this);
    }

    private function tabCustomFields()
    {
        $this->postBoxForms();

        do_action('wpProQuiz_quizEdit_tab_content_form', $this);
    }

    private function tabLeaderboard()
    {
        $this->postBoxLeaderboardOptions();

        do_action('wpProQuiz_quizEdit_tab_content_leaderboard', $this);
    }

    private function tabResult()
    {
        $this->postBoxResult();
        $this->postBoxResultOptions();

        do_action('wpProQuiz_quizEdit_tab_content_result', $this);
    }

    private function tabOptions()
    {
        $this->postBoxOptions();
        $this->postBoxQuestionOptions();

        do_action('wpProQuiz_quizEdit_tab_content_options', $this);
    }

    private function tabPlugins()
    {
        /** @deprecated use wpProQuiz_quizEdit_tab_plugins hook */
        do_action('wpProQuiz_action_plugin_quizEdit', $this);


        do_action('wpProQuiz_quizEdit_tab_content_plugins', $this);
    }

    private function postBoxOptions()
    {
        ?>
        <div class="postbox">
            <h3 class="hndle"><?php _e('Opções', 'wp-pro-quiz'); ?></h3>

            <div class="inside">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <?php _e('Ocultar título do teste', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Ocultar título', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label for="title_hidden">
                                    <input type="checkbox" id="title_hidden" value="1"
                                           name="titleHidden" <?php echo $this->quiz->isTitleHidden() ? 'checked="checked"' : '' ?> >
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('O título serve como cabeçalho do questionário.', 'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Ocultar botão "Reiniciar questionário"', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Ocultar botão "Reiniciar questionário"', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label for="btn_restart_quiz_hidden">
                                    <input type="checkbox" id="btn_restart_quiz_hidden" value="1"
                                           name="btnRestartQuizHidden" <?php echo $this->quiz->isBtnRestartQuizHidden() ? 'checked="checked"' : '' ?> >
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Oculte o botão "Reiniciar questionário" no Frontend.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Ocultar botão "Ver questão"', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Ocultar botão "Ver questão"', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label for="btn_view_question_hidden">
                                    <input type="checkbox" id="btn_view_question_hidden" value="1"
                                           name="btnViewQuestionHidden" <?php echo $this->quiz->isBtnViewQuestionHidden() ? 'checked="checked"' : '' ?> >
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Oculte o botão "Exibir questão" no Frontend.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Exibir questão aleatoriamente', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Exibir questão aleatoriamente', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label for="question_random">
                                    <input type="checkbox" id="question_random" value="1"
                                           name="questionRandom" <?php echo $this->quiz->isQuestionRandom() ? 'checked="checked"' : '' ?> >
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Exibir respostas aleatoriamente', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Exibir respostas aleatoriamente', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label for="answer_random">
                                    <input type="checkbox" id="answer_random" value="1"
                                           name="answerRandom" <?php echo $this->quiz->isAnswerRandom() ? 'checked="checked"' : '' ?> >
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Classificar questões por categoria', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Classificar questões por categoria', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="sortCategories" <?php $this->checked($this->quiz->isSortCategories()); ?> >
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Também funciona em conjunto com a opção "exibir perguntas aleatoriamente".',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Limite de tempo', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Limite de tempo', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label for="time_limit">
                                    <input type="number" min="0" class="small-text" id="time_limit"
                                           value="<?php echo $this->quiz->getTimeLimit(); ?>"
                                           name="timeLimit"> <?php _e('Segundos', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('0 = sem limite', 'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Estatísticas', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Estatísticas', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label for="statistics_on">
                                    <input type="checkbox" id="statistics_on" value="1"
                                           name="statisticsOn" <?php echo $this->quiz->isStatisticsOn() ? 'checked="checked"' : ''; ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Estatísticas sobre respostas certas ou erradas. As estatísticas serão salvas por questionário concluído, não após cada questão. As estatísticas são visíveis apenas no menu de administração. (estatísticas internas)',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr id="statistics_ip_lock_tr" style="display: none;">
                        <th scope="row">
                            <?php _e('Estatísticas de bloqueio de IP', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Estatísticas de bloqueio de IP', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label for="statistics_ip_lock">
                                    <input type="number" min="0" class="small-text" id="statistics_ip_lock"
                                           value="<?php echo ($this->quiz->getStatisticsIpLock() === null) ? 1440 : $this->quiz->getStatisticsIpLock(); ?>"
                                           name="statisticsIpLock">
                                    <?php _e('em minutos (recomendado 1440 minutos = 1 dia)',
                                        'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Proteja as estatísticas de spam. O resultado será salvo apenas a cada X minutos do mesmo IP. (0 = desativado)',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Execute o questionário apenas uma vez', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>

                                <legend class="screen-reader-text">
                                    <span><?php _e('Execute o questionário apenas uma vez', 'wp-pro-quiz'); ?></span>
                                </legend>

                                <label>
                                    <input type="checkbox" value="1"
                                           name="quizRunOnce" <?php echo $this->quiz->isQuizRunOnce() ? 'checked="checked"' : '' ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você ativar esta opção, o usuário poderá completar o quiz apenas uma vez. Depois disso, o quiz será bloqueado para este usuário.',
                                        'wp-pro-quiz'); ?>
                                </p>

                                <div id="wpProQuiz_quiz_run_once_type"
                                     style="margin-bottom: 5px; display: none;">
                                    <?php _e('Esta opção se aplica a:', 'wp-pro-quiz');

                                    $quizRunOnceType = $this->quiz->getQuizRunOnceType();
                                    $quizRunOnceType = ($quizRunOnceType == 0) ? 1 : $quizRunOnceType;

                                    ?>
                                    <label>
                                        <input name="quizRunOnceType" type="radio"
                                               value="1" <?php echo ($quizRunOnceType == 1) ? 'checked="checked"' : ''; ?>>
                                        <?php _e('todos os usuários', 'wp-pro-quiz'); ?>
                                    </label>
                                    <label>
                                        <input name="quizRunOnceType" type="radio"
                                               value="2" <?php echo ($quizRunOnceType == 2) ? 'checked="checked"' : ''; ?>>
                                        <?php _e('somente usuários registrados', 'wp-pro-quiz'); ?>
                                    </label>
                                    <label>
                                        <input name="quizRunOnceType" type="radio"
                                               value="3" <?php echo ($quizRunOnceType == 3) ? 'checked="checked"' : ''; ?>>
                                        <?php _e('somente usuários anônimos', 'wp-pro-quiz'); ?>
                                    </label>

                                    <div id="wpProQuiz_quiz_run_once_cookie" style="margin-top: 10px;">
                                        <label>
                                            <input type="checkbox" value="1"
                                                   name="quizRunOnceCookie" <?php echo $this->quiz->isQuizRunOnceCookie() ? 'checked="checked"' : '' ?>>
                                            <?php _e('identificação do usuário por cookie', 'wp-pro-quiz'); ?>
                                        </label>

                                        <p class="description">
                                            <?php _e('Se você ativar esta opção, um cookie será definido adicionalmente para usuários não registrados (anônimos). Isso garante uma atribuição mais longa do usuário do que a atribuição simples pelo endereço IP.',
                                                'wp-pro-quiz'); ?>
                                        </p>
                                    </div>

                                    <div style="margin-top: 15px;">
                                        <input class="button-secondary" type="button" name="resetQuizLock"
                                               value="<?php _e('Redefinir a identificação do usuário',
                                                   'wp-pro-quiz'); ?>">
                                        <span id="resetLockMsg"
                                              style="display:none; background-color: rgb(255, 255, 173); border: 1px solid rgb(143, 143, 143); padding: 4px; margin-left: 5px; "><?php _e('User identification has been reset.'); ?></span>

                                        <p class="description">
                                            <?php _e('Redefine a identificação do usuário para todos os usuários.',
                                                'wp-pro-quiz'); ?>
                                        </p>
                                    </div>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Mostrar apenas um número específico de perguntas', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                                <span><?php _e('Mostrar apenas um número específico de perguntas',
                                                        'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="showMaxQuestion" <?php echo $this->quiz->isShowMaxQuestion() ? 'checked="checked"' : '' ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, o número máximo de perguntas exibidas será X de X perguntas. (A saída das perguntas é aleatória)',
                                        'wp-pro-quiz'); ?>
                                </p>

                                <div id="wpProQuiz_showMaxBox" style="display: none;">
                                    <label>
                                        <?php _e('Quantas perguntas devem ser exibidas simultaneamente:',
                                            'wp-pro-quiz'); ?>
                                        <input class="small-text" type="text" name="showMaxQuestionValue"
                                               value="<?php echo $this->quiz->getShowMaxQuestionValue(); ?>">
                                    </label>
                                    <label>
                                        <input type="checkbox" value="1"
                                               name="showMaxQuestionPercent" <?php echo $this->quiz->isShowMaxQuestionPercent() ? 'checked="checked"' : '' ?>>
                                        <?php _e('em porcentagem', 'wp-pro-quiz'); ?>
                                    </label>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Pré-requisitos', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Pré-requisitos', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="prerequisite" <?php $this->checked($this->quiz->isPrerequisite()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, poderá escolher um teste que o usuário deverá terminar antes de poder começar.
                                    ',
                                        'wp-pro-quiz'); ?>
                                </p>

                                <p class="description">
                                    <?php _e('Em todos os questionários selecionados a função estatística tem que estar ativa. Se não estiver, ela será ativada automaticamente.',
                                        'wp-pro-quiz'); ?>
                                </p>

                                <div id="prerequisiteBox" style="display: none;">
                                    <table>
                                        <tr>
                                            <th style="width: 120px; padding: 0;"><?php _e('Questionário',
                                                    'wp-pro-quiz'); ?></th>
                                            <th style="padding: 0; width: 50px;"></th>
                                            <th style="padding: 0; width: 400px;"><?php _e('Pré-requisitos (Este questionário deve ser concluído)',
                                                    'wp-pro-quiz'); ?></th>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0;">
                                                <select multiple="multiple" size="8" style="width: 200px;"
                                                        name="quizList">
                                                    <?php foreach ($this->quizList as $list) {
                                                        if (in_array($list['id'],
                                                            $this->prerequisiteQuizList)) {
                                                            continue;
                                                        }

                                                        echo '<option value="' . $list['id'] . '">' . $list['name'] . '</option>';
                                                    } ?>
                                                </select>
                                            </td>
                                            <td style="padding: 0; text-align: center;">
                                                <div>
                                                    <input type="button" id="btnPrerequisiteAdd"
                                                           value="&gt;&gt;">
                                                </div>
                                                <div>
                                                    <input type="button" id="btnPrerequisiteDelete"
                                                           value="&lt;&lt;">
                                                </div>
                                            </td>
                                            <td style="padding: 0;">
                                                <select multiple="multiple" size="8" style="width: 200px"
                                                        name="prerequisiteList[]">
                                                    <?php foreach ($this->quizList as $list) {
                                                        if (!in_array($list['id'],
                                                            $this->prerequisiteQuizList)
                                                        ) {
                                                            continue;
                                                        }

                                                        echo '<option value="' . $list['id'] . '">' . $list['name'] . '</option>';
                                                    } ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Visão geral da questão', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Visão geral da questão', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="showReviewQuestion" <?php $this->checked($this->quiz->isShowReviewQuestion()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Adicione no topo do questionário uma visão geral da questão, que permite navegação fácil. Questões adicionais podem ser marcadas como "para revisar".',
                                        'wp-pro-quiz'); ?>
                                </p>

                                <p class="description">
                                    <?php _e('Uma visão geral adicional do questionário será exibida antes do término do questionário.',
                                        'wp-pro-quiz'); ?>
                                </p>

                                <div class="wpProQuiz_demoBox">
                                    <?php _e('Visão geral da questão', 'wp-pro-quiz'); ?>: <a
                                            href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                    <div>
                                        <img alt=""
                                             src="<?php echo WPPROQUIZ_URL . '/img/questionOverview.png'; ?> ">
                                    </div>
                                </div>
                                <div class="wpProQuiz_demoBox">
                                    <?php _e('Resumo do questionário', 'wp-pro-quiz'); ?>: <a
                                            href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                    <div>
                                        <img alt=""
                                             src="<?php echo WPPROQUIZ_URL . '/img/quizSummary.png'; ?> ">
                                    </div>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr class="wpProQuiz_reviewQuestionOptions" style="display: none;">
                        <th scope="row">
                            <?php _e('Resumo do questionário', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Resumo do questionário', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="quizSummaryHide" <?php $this->checked($this->quiz->isQuizSummaryHide()); ?>>
                                    <?php _e('Desativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, nenhuma visão geral do questionário será exibida antes de terminar o questionário.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr class="wpProQuiz_reviewQuestionOptions" style="display: none;">
                        <th scope="row">
                            <?php _e('Pular questão', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Pular questão', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="skipQuestionDisabled" <?php $this->checked($this->quiz->isSkipQuestionDisabled()); ?>>
                                    <?php _e('Desativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, o usuário não poderá pular a questão. (somente no modo "Visão geral -> próximo"). O usuário ainda poderá navegar em "Visão geral da questão"',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <!--
							<tr>
								<th scope="row">
									<?php _e('Notificação de e-mail do administrador', 'wp-pro-quiz'); ?>
								</th>
								<td>
									<fieldset>
										<legend class="screen-reader-text">
											<span><?php _e('Notificação de e-mail do administrador', 'wp-pro-quiz'); ?></span>
										</legend>
										<label>
											<input type="radio" name="emailNotification" value="<?php echo WpProQuiz_Model_Quiz::QUIZ_EMAIL_NOTE_NONE; ?>" <?php $this->checked($this->quiz->getEmailNotification(),
                        WpProQuiz_Model_Quiz::QUIZ_EMAIL_NOTE_NONE); ?>>
											<?php _e('Desativar', 'wp-pro-quiz'); ?>
										</label>
										<label>
											<input type="radio" name="emailNotification" value="<?php echo WpProQuiz_Model_Quiz::QUIZ_EMAIL_NOTE_REG_USER; ?>" <?php $this->checked($this->quiz->getEmailNotification(),
                        WpProQuiz_Model_Quiz::QUIZ_EMAIL_NOTE_REG_USER); ?>>
											<?php _e('somente para usuários registrados', 'wp-pro-quiz'); ?>
										</label>
										<label>
											<input type="radio" name="emailNotification" value="<?php echo WpProQuiz_Model_Quiz::QUIZ_EMAIL_NOTE_ALL; ?>" <?php $this->checked($this->quiz->getEmailNotification(),
                        WpProQuiz_Model_Quiz::QUIZ_EMAIL_NOTE_ALL); ?>>
											<?php _e('para todos os usuários', 'wp-pro-quiz'); ?>
										</label>
										<p class="description">
											<?php _e('Se você habilitar esta opção, você será informado se um usuário concluir este questionário.',
                        'wp-pro-quiz'); ?>
										</p>
										<p class="description">
											<?php _e('As configurações de e-mail podem ser editadas nas configurações globais.',
                        'wp-pro-quiz'); ?>
										</p>
									</fieldset>
								</td>
							</tr>

							<tr>
								<th scope="row">
									<?php _e('Notificação de e-mail do usuário', 'wp-pro-quiz'); ?>
								</th>
								<td>
									<fieldset>
										<legend class="screen-reader-text">
											<span><?php _e('Notificação de e-mail do usuário', 'wp-pro-quiz'); ?></span>
										</legend>
										<label>
											<input type="checkbox" name="userEmailNotification" value="1" <?php $this->checked($this->quiz->isUserEmailNotification()); ?>>
											<?php _e('Ativar', 'wp-pro-quiz'); ?>
										</label>
										<p class="description">
											<?php _e('Se você habilitar esta opção, um e-mail será enviado com o resultado do questionário para o usuário. (somente usuários registrados)',
                        'wp-pro-quiz'); ?>
										</p>
										<p class="description">
											<?php _e('As configurações de e-mail podem ser editadas nas configurações globais.',
                        'wp-pro-quiz'); ?>
										</p>
									</fieldset>
								</td>
							</tr>
							 -->
                    <tr>
                        <th scope="row">
                            <?php _e('Início automático', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Início automático', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" name="autostart"
                                           value="1" <?php $this->checked($this->quiz->isAutostart()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, o questionário iniciará automaticamente após a página ser carregada.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Somente usuários registrados podem iniciar o questionário',
                                'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                                <span><?php _e('Somente usuários registrados podem iniciar o questionário',
                                                        'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" name="startOnlyRegisteredUser"
                                           value="1" <?php $this->checked($this->quiz->isStartOnlyRegisteredUser()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, somente usuários registrados poderão iniciar o questionário.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

    private function postBoxResult()
    {
        ?>
        <div class="postbox">
            <h3 class="hndle"><?php _e('Texto de resultados ', 'wp-pro-quiz'); ?><?php _e('(opcional)',
                    'wp-pro-quiz'); ?></h3>

            <div class="inside">
                <p class="description">
                    <?php _e('Este texto será exibido no final do questionário (nossos resultados). (este texto é opcional)',
                        'wp-pro-quiz'); ?>
                </p>

                <div style="padding-top: 10px; padding-bottom: 10px;">
                    <label for="wpProQuiz_resultGradeEnabled">
                        <?php _e('Ativar graduação', 'wp-pro-quiz'); ?>
                        <input type="checkbox" name="resultGradeEnabled" id="wpProQuiz_resultGradeEnabled"
                               value="1" <?php echo $this->quiz->isResultGradeEnabled() ? 'checked="checked"' : ''; ?>>
                    </label>
                </div>
                <div style="display: none;" id="resultGrade">
                    <div>
                        <strong><?php _e('Dica:', 'wp-pro-quiz'); ?></strong>
                        <ul style="list-style-type: square; padding: 5px; margin-left: 20px; margin-top: 0;">
                            <li><?php _e('Máximo de 15 níveis', 'wp-pro-quiz'); ?></li>
                            <li>
                                <?php printf(__('Porcentagens referem-se à pontuação total do questionário. (Total atual de %d pontos em %d questões.',
                                    'wp-pro-quiz'),
                                    $this->quiz->fetchSumQuestionPoints(),
                                    $this->quiz->fetchCountQuestions()); ?>
                            </li>
                            <li><?php _e('Os valores também podem ser confundidos', 'wp-pro-quiz'); ?></li>
                            <li><?php _e('10,15% ou 10,15% permitido (máx. dois dígitos após a vírgula decimal)',
                                    'wp-pro-quiz'); ?></li>
                        </ul>

                    </div>
                    <div>
                        <ul id="resultList">
                            <?php
                            $resultText = $this->quiz->getResultText();

                            for ($i = 0; $i < 15; $i++) {

                                if ($this->quiz->isResultGradeEnabled() && isset($resultText['text'][$i])) {
                                    ?>
                                    <li style="padding: 5px; border: 1px dotted;">
                                        <div
                                                style="margin-bottom: 5px;"><?php wp_editor($resultText['text'][$i],
                                                'resultText_' . $i, array(
                                                    'textarea_rows' => 3,
                                                    'textarea_name' => 'resultTextGrade[text][]'
                                                )); ?></div>
                                        <div
                                                style="margin-bottom: 5px;background-color: rgb(207, 207, 207);padding: 10px;">
                                            <?php _e('de:', 'wp-pro-quiz'); ?> <input type="text"
                                                                                        name="resultTextGrade[prozent][]"
                                                                                        class="small-text"
                                                                                        value="<?php echo $resultText['prozent'][$i] ?>"> <?php _e('por cento',
                                                'wp-pro-quiz'); ?> <?php printf(__('(Será exibido quando o resultado-porcentagem for >= <span class="resultProzent">%s</span>%%)',
                                                'wp-pro-quiz'), $resultText['prozent'][$i]); ?>
                                            <input type="button" style="float: right;"
                                                   class="button-primary deleteResult"
                                                   value="<?php _e('Excluir graduação', 'wp-pro-quiz'); ?>">

                                            <div style="clear: right;"></div>
                                            <input type="hidden" value="1" name="resultTextGrade[activ][]">
                                        </div>
                                    </li>

                                <?php } else { ?>
                                    <li style="padding: 5px; border: 1px dotted; <?php echo $i ? 'display:none;' : '' ?>">
                                        <div style="margin-bottom: 5px;"><?php wp_editor('',
                                                'resultText_' . $i, array(
                                                    'textarea_rows' => 3,
                                                    'textarea_name' => 'resultTextGrade[text][]'
                                                )); ?></div>
                                        <div
                                                style="margin-bottom: 5px;background-color: rgb(207, 207, 207);padding: 10px;">
                                            <?php _e('de:', 'wp-pro-quiz'); ?> <input type="text"
                                                                                        name="resultTextGrade[prozent][]"
                                                                                        class="small-text"
                                                                                        value="0"> <?php _e('por cento',
                                                'wp-pro-quiz'); ?> <?php printf(__('(Será exibido quando o resultado-porcentagem for >= <span class="resultProzent">%s</span>%%)',
                                                'wp-pro-quiz'), '0'); ?>
                                            <input type="button" style="float: right;"
                                                   class="button-primary deleteResult"
                                                   value="<?php _e('Excluir graduação', 'wp-pro-quiz'); ?>">

                                            <div style="clear: right;"></div>
                                            <input type="hidden" value="<?php echo $i ? '0' : '1' ?>"
                                                   name="resultTextGrade[activ][]">
                                        </div>
                                    </li>
                                <?php }
                            } ?>
                        </ul>
                        <input type="button" class="button-primary addResult"
                               value="<?php _e('Adicionar graduação', 'wp-pro-quiz'); ?>">
                    </div>
                </div>
                <div id="resultNormal">
                    <?php

                    $resultText = is_array($resultText) ? '' : $resultText;
                    wp_editor($resultText, 'resultText', array('textarea_rows' => 10));
                    ?>
                </div>

                <h4><?php _e('Campos personalizados - Variáveis', 'wp-pro-quiz'); ?></h4>
                <ul class="formVariables"></ul>

            </div>
        </div>
        <?php
    }

    private function postBoxTitle()
    {
        ?>
        <div class="postbox">
            <h3 class="hndle"><?php _e('Título do questionário ', 'wp-pro-quiz'); ?><?php _e('(obrigatório)',
                    'wp-pro-quiz'); ?></h3>

            <div class="inside">
                <input name="name" id="wpProQuiz_title" type="text" class="regular-text"
                       value="<?php echo htmlspecialchars($this->quiz->getName(), ENT_QUOTES); ?>">
            </div>
        </div>
        <?php
    }

    private function postBoxCategory()
    {
        ?>
        <div class="postbox">
            <h3 class="hndle"><?php _e('Categoria ', 'wp-pro-quiz'); ?><?php _e('(opcional)',
                    'wp-pro-quiz'); ?></h3>

            <div class="inside">
                <p class="description">
                    <?php _e('Você pode atribuir uma categoria de classificação para um questionário.', 'wp-pro-quiz'); ?>
                </p>

                <p class="description">
                    <?php _e('Você pode gerenciar categorias nas configurações globais.', 'wp-pro-quiz'); ?>
                </p>

                <div>
                    <select name="category">
                        <option value="-1">--- <?php _e('Criar nova categoria', 'wp-pro-quiz'); ?>----
                        </option>
                        <option
                                value="0" <?php echo $this->quiz->getCategoryId() == 0 ? 'selected="selected"' : ''; ?>>
                            --- <?php _e('Nenhuma categoria', 'wp-pro-quiz'); ?> ---
                        </option>
                        <?php
                        foreach ($this->categories as $cat) {
                            echo '<option ' . ($this->quiz->getCategoryId() == $cat->getCategoryId() ? 'selected="selected"' : '') . ' value="' . $cat->getCategoryId() . '">' . $cat->getCategoryName() . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div style="display: none;" id="categoryAddBox">
                    <h4><?php _e('Criar nova categoria', 'wp-pro-quiz'); ?></h4>
                    <input type="text" name="categoryAdd" value="">
                    <input type="button" class="button-secondary" name="" id="categoryAddBtn"
                           value="<?php _e('Criar', 'wp-pro-quiz'); ?>">
                </div>
                <div id="categoryMsgBox"
                     style="display:none; padding: 5px; border: 1px solid rgb(160, 160, 160); background-color: rgb(255, 255, 168); font-weight: bold; margin: 5px; ">
                    Kategorie gespeichert
                </div>
            </div>
        </div>
        <?php
    }

    private function postBoxQuizDescription()
    {
        ?>
        <div class="postbox">
            <h3 class="hndle"><?php _e('Descrição do questionário ', 'wp-pro-quiz'); ?><?php _e('(obrigatório)',
                    'wp-pro-quiz'); ?></h3>

            <div class="inside">
                <p class="description">
                    <?php _e('Este texto será exibido antes do início do questionário.', 'wp-pro-quiz'); ?>
                </p>
                <?php
                wp_editor($this->quiz->getText(), "text");
                ?>
            </div>
        </div>
        <?php
    }

    private function postBoxResultOptions()
    {
        ?>
        <div class="postbox">
            <h3 class="hndle"><?php _e('Opções-de-resultado', 'wp-pro-quiz'); ?></h3>

            <div class="inside">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <?php _e('Mostrar pontos médios', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Mostrar pontos médios', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="showAverageResult" <?php $this->checked($this->quiz->isShowAverageResult()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('A função de estatísticas deve estar habilitada.', 'wp-pro-quiz'); ?>
                                </p>

                                <div class="wpProQuiz_demoBox">
                                    <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                    <div>
                                        <img alt="" src="<?php echo WPPROQUIZ_URL . '/img/averagePoints.png'; ?> ">
                                    </div>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Mostrar pontuação da categoria', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Mostrar pontuação da categoria', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" name="showCategoryScore"
                                           value="1" <?php $this->checked($this->quiz->isShowCategoryScore()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, os resultados de cada categoria serão exibidos na página de resultados.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>

                            <div class="wpProQuiz_demoBox">
                                <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                <div>
                                    <img alt="" src="<?php echo WPPROQUIZ_URL . '/img/catOverview.png'; ?> ">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Ocultar perguntas corretas - exibir', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Ocultar perguntas corretas - exibir', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" name="hideResultCorrectQuestion"
                                           value="1" <?php $this->checked($this->quiz->isHideResultCorrectQuestion()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você selecionar esta opção, o número de questões respondidas corretamente não será mais exibido na página de resultados.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>

                            <div class="wpProQuiz_demoBox">
                                <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                <div>
                                    <img alt="" src="<?php echo WPPROQUIZ_URL . '/img/hideCorrectQuestion.png'; ?> ">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Ocultar tempo do questionário - exibir', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Ocultar tempo do questionário - exibir', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" name="hideResultQuizTime"
                                           value="1" <?php $this->checked($this->quiz->isHideResultQuizTime()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, o tempo para terminar o questionário não será mais exibido na página de resultados.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>

                            <div class="wpProQuiz_demoBox">
                                <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                <div>
                                    <img alt="" src="<?php echo WPPROQUIZ_URL . '/img/hideQuizTime.png'; ?> ">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Ocultar pontuação - exibir', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Ocultar pontuação - exibir', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" name="hideResultPoints"
                                           value="1" <?php $this->checked($this->quiz->isHideResultPoints()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, a pontuação final não será mais exibida na página de resultados.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>

                            <div class="wpProQuiz_demoBox">
                                <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                <div>
                                    <img alt="" src="<?php echo WPPROQUIZ_URL . '/img/hideQuizPoints.png'; ?> ">
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
    }

    private function postBoxQuestionOptions()
    {
        ?>

        <div class="postbox">
            <h3 class="hndle"><?php _e('Opções-de-perguntas', 'wp-pro-quiz'); ?></h3>

            <div class="inside">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <?php _e('Mostrar pontos', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Mostrar pontos', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label for="show_points">
                                    <input type="checkbox" id="show_points" value="1"
                                           name="showPoints" <?php echo $this->quiz->isShowPoints() ? 'checked="checked"' : '' ?> >
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Mostra no questionário quantos pontos são possíveis para cada questão.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Respostas numéricas', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Respostas numéricas', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="numberedAnswer" <?php echo $this->quiz->isNumberedAnswer() ? 'checked="checked"' : '' ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se esta opção estiver ativada, todas as respostas serão numeradas (apenas escolha única e múltipla)',
                                        'wp-pro-quiz'); ?>
                                </p>

                                <div class="wpProQuiz_demoBox">
                                    <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                    <div>
                                        <img alt="" src="<?php echo WPPROQUIZ_URL . '/img/numbering.png'; ?> ">
                                    </div>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Ocultar mensagem correta e incorreta', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Ocultar mensagem correta e incorreta', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="hideAnswerMessageBox" <?php echo $this->quiz->isHideAnswerMessageBox() ? 'checked="checked"' : '' ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, nenhuma mensagem correta ou incorreta será exibida.',
                                        'wp-pro-quiz'); ?>
                                </p>

                                <div class="wpProQuiz_demoBox">
                                    <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                    <div>
                                        <img alt=""
                                             src="<?php echo WPPROQUIZ_URL . '/img/hideAnswerMessageBox.png'; ?> ">
                                    </div>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Marca de resposta correta e incorreta', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Marca de resposta correta e incorreta', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="disabledAnswerMark" <?php echo $this->quiz->isDisabledAnswerMark() ? 'checked="checked"' : '' ?>>
                                    <?php _e('Desativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, as respostas não serão destacadas como corretas ou incorretas. ',
                                        'wp-pro-quiz'); ?>
                                </p>

                                <div class="wpProQuiz_demoBox">
                                    <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                    <div>
                                        <img alt="" src="<?php echo WPPROQUIZ_URL . '/img/mark.png'; ?> ">
                                    </div>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Forçar o usuário a responder a cada questão', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Forçar o usuário a responder a cada questão', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="forcingQuestionSolve" <?php $this->checked($this->quiz->isForcingQuestionSolve()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, o usuário será forçado a responder a cada questão.',
                                        'wp-pro-quiz'); ?> <br>
                                    <?php _e('Se a opção "Visão geral da questão" estiver ativada, esta notificação aparecerá após o término do questionário, caso contrário, após cada questão.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Ocultar visão geral da posição da questão', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Ocultar visão geral da posição da questão', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="hideQuestionPositionOverview" <?php $this->checked($this->quiz->isHideQuestionPositionOverview()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, a visão geral da posição da questão ficará oculta.',
                                        'wp-pro-quiz'); ?>
                                </p>

                                <div class="wpProQuiz_demoBox">
                                    <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                    <div>
                                        <img alt=""
                                             src="<?php echo WPPROQUIZ_URL . '/img/hideQuestionPositionOverview.png'; ?> ">
                                    </div>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Ocultar numeração de questões', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Ocultar numeração de questões', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="hideQuestionNumbering" <?php $this->checked($this->quiz->isHideQuestionNumbering()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, a numeração das questões ficará oculta.',
                                        'wp-pro-quiz'); ?>
                                </p>

                                <div class="wpProQuiz_demoBox">
                                    <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                    <div>
                                        <img alt=""
                                             src="<?php echo WPPROQUIZ_URL . '/img/hideQuestionNumbering.png'; ?> ">
                                    </div>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Exibir categoria', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Exibir categoria', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" value="1"
                                           name="showCategory" <?php $this->checked($this->quiz->isShowCategory()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, a categoria será exibida na questão.',
                                        'wp-pro-quiz'); ?>
                                </p>

                                <div class="wpProQuiz_demoBox">
                                    <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                    <div>
                                        <img alt="" src="<?php echo WPPROQUIZ_URL . '/img/showCategory.png'; ?> ">
                                    </div>
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
    }

    private function postBoxLeaderboardOptions()
    {
        ?>
        <div class="postbox">
            <h3 class="hndle"><?php _e('Leaderboard ', 'wp-pro-quiz'); ?><?php _e('(opcional)', 'wp-pro-quiz'); ?></h3>

            <div class="inside">
                <p>
                    <?php _e('A tabela de classificação permite que os usuários insiram resultados em uma lista pública e compartilhem os resultados dessa maneira.',
                        'wp-pro-quiz'); ?>
                </p>

                <p>
                    <?php _e('A tabela de classificação funciona independentemente da função de estatísticas internas.', 'wp-pro-quiz'); ?>
                </p>
                <table class="form-table">
                    <tbody id="toplistBox">
                    <tr>
                        <th scope="row">
                            <?php _e('Leaderboard', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" name="toplistActivated"
                                       value="1" <?php echo $this->quiz->isToplistActivated() ? 'checked="checked"' : ''; ?>>
                                <?php _e('Ativar', 'wp-pro-quiz'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Quem pode se inscrever na lista', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input name="toplistDataAddPermissions" type="radio"
                                       value="1" <?php echo $this->quiz->getToplistDataAddPermissions() == 1 ? 'checked="checked"' : ''; ?>>
                                <?php _e('todos os usuários', 'wp-pro-quiz'); ?>
                            </label>
                            <label>
                                <input name="toplistDataAddPermissions" type="radio"
                                       value="2" <?php echo $this->quiz->getToplistDataAddPermissions() == 2 ? 'checked="checked"' : ''; ?>>
                                <?php _e('somente usuários registrados', 'wp-pro-quiz'); ?>
                            </label>
                            <label>
                                <input name="toplistDataAddPermissions" type="radio"
                                       value="3" <?php echo $this->quiz->getToplistDataAddPermissions() == 3 ? 'checked="checked"' : ''; ?>>
                                <?php _e('somente usuários anônimos', 'wp-pro-quiz'); ?>
                            </label>

                            <p class="description">
                                <?php _e('Usuários não registrados devem informar nome e e-mail (o e-mail não será exibido)',
                                    'wp-pro-quiz'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('inserir automaticamente', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input name="toplistDataAddAutomatic" type="checkbox"
                                       value="1" <?php $this->checked($this->quiz->isToplistDataAddAutomatic()); ?>>
                                <?php _e('Ativar', 'wp-pro-quiz'); ?>
                            </label>

                            <p class="description">
                                <?php _e('Se você habilitar esta opção, os usuários logados serão automaticamente inseridos na tabela de classificação',
                                    'wp-pro-quiz'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('exibir captcha', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" name="toplistDataCaptcha"
                                       value="1" <?php echo $this->quiz->isToplistDataCaptcha() ? 'checked="checked"' : ''; ?> <?php echo $this->captchaIsInstalled ? '' : 'disabled="disabled"'; ?>>
                                <?php _e('Ativar', 'wp-pro-quiz'); ?>
                            </label>

                            <p class="description">
                                <?php _e('Se você habilitar esta opção, um captcha adicional será exibido para usuários que não estão registrados.',
                                    'wp-pro-quiz'); ?>
                            </p>

                            <p class="description" style="color: red;">
                                <?php _e('Esta opção requer um plugin adicional:', 'wp-pro-quiz'); ?>
                                <a href="http://wordpress.org/extend/plugins/really-simple-captcha/" target="_blank">Really
                                    Simple CAPTCHA</a>
                            </p>
                            <?php if ($this->captchaIsInstalled) { ?>
                                <p class="description" style="color: green;">
                                    <?php _e('O plugin foi detectado.', 'wp-pro-quiz'); ?>
                                </p>
                            <?php } else { ?>
                                <p class="description" style="color: red;">
                                    <?php _e('O plugin não está instalado.', 'wp-pro-quiz'); ?>
                                </p>
                            <?php } ?>

                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Classificar lista por', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input name="toplistDataSort" type="radio"
                                       value="1" <?php echo ($this->quiz->getToplistDataSort() == 1) ? 'checked="checked"' : ''; ?>>
                                <?php _e('melhor usuário', 'wp-pro-quiz'); ?>
                            </label>
                            <label>
                                <input name="toplistDataSort" type="radio"
                                       value="2" <?php echo ($this->quiz->getToplistDataSort() == 2) ? 'checked="checked"' : ''; ?>>
                                <?php _e('entrada mais recente', 'wp-pro-quiz'); ?>
                            </label>
                            <label>
                                <input name="toplistDataSort" type="radio"
                                       value="3" <?php echo ($this->quiz->getToplistDataSort() == 3) ? 'checked="checked"' : ''; ?>>
                                <?php _e('entrada mais antiga', 'wp-pro-quiz'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Os usuários podem se inscrever várias vezes', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <div>
                                <label>
                                    <input type="checkbox" name="toplistDataAddMultiple"
                                           value="1" <?php echo $this->quiz->isToplistDataAddMultiple() ? 'checked="checked"' : ''; ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>
                            </div>
                            <div id="toplistDataAddBlockBox" style="display: none;">
                                <label>
                                    <?php _e('O usuário pode aplicar depois:', 'wp-pro-quiz'); ?>
                                    <input type="number" min="0" class="small-text" name="toplistDataAddBlock"
                                           value="<?php echo $this->quiz->getToplistDataAddBlock(); ?>">
                                    <?php _e('minuto', 'wp-pro-quiz'); ?>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Quantas entradas devem ser exibidas', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <div>
                                <label>
                                    <input type="number" min="0" class="small-text" name="toplistDataShowLimit"
                                           value="<?php echo $this->quiz->getToplistDataShowLimit(); ?>">
                                    <?php _e('Entradas', 'wp-pro-quiz'); ?>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Exibir automaticamente a tabela de classificação no resultado do questionário', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <div style="margin-top: 6px;">
                                <?php _e('Onde a tabela de classificação deve ser exibida:', 'wp-pro-quiz'); ?>
                                <label style="margin-right: 5px; margin-left: 5px;">
                                    <input type="radio" name="toplistDataShowIn"
                                           value="0" <?php echo ($this->quiz->getToplistDataShowIn() == 0) ? 'checked="checked"' : ''; ?>>
                                    <?php _e('não exibir', 'wp-pro-quiz'); ?>
                                </label>
                                <label>
                                    <input type="radio" name="toplistDataShowIn"
                                           value="1" <?php echo ($this->quiz->getToplistDataShowIn() == 1) ? 'checked="checked"' : ''; ?>>
                                    <?php _e('abaixo do "texto de resultado"', 'wp-pro-quiz'); ?>
                                </label>
									<span class="wpProQuiz_demoBox" style="margin-right: 5px;">
										<a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>
										<span>
											<img alt=""
                                                 src="<?php echo WPPROQUIZ_URL . '/img/leaderboardInResultText.png'; ?> ">
										</span>
									</span>
                                <label>
                                    <input type="radio" name="toplistDataShowIn"
                                           value="2" <?php echo ($this->quiz->getToplistDataShowIn() == 2) ? 'checked="checked"' : ''; ?>>
                                    <?php _e('em um botão', 'wp-pro-quiz'); ?>
                                </label>
									<span class="wpProQuiz_demoBox">
										<a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>
										<span>
											<img alt=""
                                                 src="<?php echo WPPROQUIZ_URL . '/img/leaderboardInButton.png'; ?> ">
										</span>
									</span>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

    private function postBoxQuizMode()
    {
        ?>
        <div class="postbox">
            <h3 class="hndle"><?php _e('Modo Questionário ', 'wp-pro-quiz'); ?><?php _e('(obrigatório)', 'wp-pro-quiz'); ?></h3>

            <div class="inside">
                <table style="width: 100%; border-collapse: collapse; border: 1px solid #A0A0A0;"
                       class="wpProQuiz_quizModus">
                    <thead>
                    <tr>
                        <th style="width: 25%;"><?php _e('Normal', 'wp-pro-quiz'); ?></th>
                        <th style="width: 25%;"><?php _e('Normal + Botão-Voltar', 'wp-pro-quiz'); ?></th>
                        <th style="width: 25%;"><?php _e('Verificar -> continuar', 'wp-pro-quiz'); ?></th>
                        <th style="width: 25%;"><?php _e('Questões abaixo uma da outra', 'wp-pro-quiz'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><label><input type="radio" name="quizModus"
                                          value="0" <?php $this->checked($this->quiz->getQuizModus(),
                                    WpProQuiz_Model_Quiz::QUIZ_MODUS_NORMAL); ?>> <?php _e('Ativar',
                                    'wp-pro-quiz'); ?></label></td>
                        <td><label><input type="radio" name="quizModus"
                                          value="1" <?php $this->checked($this->quiz->getQuizModus(),
                                    WpProQuiz_Model_Quiz::QUIZ_MODUS_BACK_BUTTON); ?>> <?php _e('Ativar',
                                    'wp-pro-quiz'); ?></label></td>
                        <td><label><input type="radio" name="quizModus"
                                          value="2" <?php $this->checked($this->quiz->getQuizModus(),
                                    WpProQuiz_Model_Quiz::QUIZ_MODUS_CHECK); ?>> <?php _e('Ativar', 'wp-pro-quiz'); ?>
                            </label></td>
                        <td><label><input type="radio" name="quizModus"
                                          value="3" <?php $this->checked($this->quiz->getQuizModus(),
                                    WpProQuiz_Model_Quiz::QUIZ_MODUS_SINGLE); ?>> <?php _e('Ativar',
                                    'wp-pro-quiz'); ?></label></td>
                    </tr>
                    <tr>
                        <td>
                            <?php _e('Exibe todas as questões sequencialmente; "certo" ou "falso" serão exibidos no final do questionáro.',
                                'wp-pro-quiz'); ?>
                        </td>
                        <td>
                            <?php _e('Permite usar o botão Voltar em uma questão.', 'wp-pro-quiz'); ?>
                        </td>
                        <td>
                            <?php _e('Mostra "certo ou errado" após cada questão.', 'wp-pro-quiz'); ?>
                        </td>
                        <td>
                            <?php _e('Se esta opção estiver ativada, todas as respostas serão exibidas uma abaixo da outra, ou seja, todas as questões ficarão em uma única página.',
                                'wp-pro-quiz'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="wpProQuiz_demoBox">
                                <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                <div>
                                    <img alt="" src="<?php echo WPPROQUIZ_URL . '/img/normal.png'; ?> ">
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="wpProQuiz_demoBox">
                                <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                <div>
                                    <img alt="" src="<?php echo WPPROQUIZ_URL . '/img/backButton.png'; ?> ">
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="wpProQuiz_demoBox" style="position: relative;">
                                <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                <div>
                                    <img alt="" src="<?php echo WPPROQUIZ_URL . '/img/checkCcontinue.png'; ?> ">
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="wpProQuiz_demoBox" style="position: relative;">
                                <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                <div>
                                    <img alt="" src="<?php echo WPPROQUIZ_URL . '/img/singlePage.png'; ?> ">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <?php _e('Quantas perguntas devem ser exibidas em uma página:', 'wp-pro-quiz'); ?><br>
                            <input type="number" name="questionsPerPage"
                                   value="<?php echo $this->quiz->getQuestionsPerPage(); ?>" min="0">
									<span class="description">
										<?php _e('(0 = Tudo em uma página)', 'wp-pro-quiz'); ?>
									</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

    private function postBoxForms()
    {
        $forms = $this->forms;
        $index = 0;

        if (!is_array($forms) || !count($forms)) {
            $forms = array(new WpProQuiz_Model_Form(), new WpProQuiz_Model_Form());
        } else {
            array_unshift($forms, new WpProQuiz_Model_Form());
        }

        ?>
        <div class="postbox">
            <h3 class="hndle"><?php _e('Campos personalizados', 'wp-pro-quiz'); ?></h3>

            <div class="inside">

                <p class="description">
                    <?php _e('Você pode criar campos personalizados, por exemplo, para solicitar o nome ou o endereço de e-mail dos usuários.',
                        'wp-pro-quiz'); ?>
                </p>

                <p class="description">
                    <?php _e('A função estatística deve ser habilitada.', 'wp-pro-quiz'); ?>
                </p>

                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <?php _e('Campos personalizados habilitados', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Campos personalizados habilitados', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" id="formActivated" value="1"
                                           name="formActivated" <?php $this->checked($this->quiz->isFormActivated()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você ativar esta opção, os campos personalizados serão ativados.', 'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Posição de exibição', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Posição de exibição', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <?php _e('Onde os campos devem ser exibidos:', 'wp-pro-quiz'); ?>
                                <label>
                                    <input type="radio"
                                           value="<?php echo WpProQuiz_Model_Quiz::QUIZ_FORM_POSITION_START; ?>"
                                           name="formShowPosition" <?php $this->checked($this->quiz->getFormShowPosition(),
                                        WpProQuiz_Model_Quiz::QUIZ_FORM_POSITION_START); ?>>
                                    <?php _e('Na página inicial do questionário', 'wp-pro-quiz'); ?>

                                    <div style="display: inline-block;" class="wpProQuiz_demoBox">
                                        <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                        <div>
                                            <img alt=""
                                                 src="<?php echo WPPROQUIZ_URL . '/img/customFieldsFront.png'; ?> ">
                                        </div>
                                    </div>

                                </label>
                                <label>
                                    <input type="radio"
                                           value="<?php echo WpProQuiz_Model_Quiz::QUIZ_FORM_POSITION_END; ?>"
                                           name="formShowPosition" <?php $this->checked($this->quiz->getFormShowPosition(),
                                        WpProQuiz_Model_Quiz::QUIZ_FORM_POSITION_END); ?> >
                                    <?php _e('No final do questionário (antes do resultado do questionário)', 'wp-pro-quiz'); ?>

                                    <div style="display: inline-block;" class="wpProQuiz_demoBox">
                                        <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                        <div>
                                            <img alt=""
                                                 src="<?php echo WPPROQUIZ_URL . '/img/customFieldsEnd1.png'; ?> ">
                                        </div>
                                    </div>

                                    <div style="display: inline-block;" class="wpProQuiz_demoBox">
                                        <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                        <div>
                                            <img alt=""
                                                 src="<?php echo WPPROQUIZ_URL . '/img/customFieldsEnd2.png'; ?> ">
                                        </div>
                                    </div>

                                </label>
                            </fieldset>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div style="margin-top: 10px; padding: 10px; border: 1px solid #C2C2C2;">
                    <table style=" width: 100%; text-align: left; " id="form_table">
                        <thead>
                        <tr>
                            <th>#ID</th>
                            <th><?php _e('Nome do campo', 'wp-pro-quiz'); ?></th>
                            <th><?php _e('Tipo', 'wp-pro-quiz'); ?></th>
                            <th><?php _e('Obrigatório?', 'wp-pro-quiz'); ?></th>
                            <th>
                                <?php _e('Mostrar na tabela estatística?', 'wp-pro-quiz'); ?>
                                <div style="display: inline-block;" class="wpProQuiz_demoBox">
                                    <a href="#"><?php _e('Demo', 'wp-pro-quiz'); ?></a>

                                    <div>
                                        <img alt=""
                                             src="<?php echo WPPROQUIZ_URL . '/img/formStatisticOverview.png'; ?> ">
                                    </div>
                                </div>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($forms as $form) {
                            $checkType = $this->selectedArray($form->getType(), array(
                                WpProQuiz_Model_Form::FORM_TYPE_TEXT,
                                WpProQuiz_Model_Form::FORM_TYPE_TEXTAREA,
                                WpProQuiz_Model_Form::FORM_TYPE_CHECKBOX,
                                WpProQuiz_Model_Form::FORM_TYPE_SELECT,
                                WpProQuiz_Model_Form::FORM_TYPE_RADIO,
                                WpProQuiz_Model_Form::FORM_TYPE_NUMBER,
                                WpProQuiz_Model_Form::FORM_TYPE_EMAIL,
                                WpProQuiz_Model_Form::FORM_TYPE_YES_NO,
                                WpProQuiz_Model_Form::FORM_TYPE_DATE
                            ));
                            ?>
                            <tr <?php echo $index++ == 0 ? 'style="display: none;"' : '' ?>>
                                <td>
                                    <?php echo $index - 2; ?>
                                </td>
                                <td>
                                    <input type="text" name="form[][fieldname]"
                                           value="<?php echo esc_attr($form->getFieldname()); ?>"
                                           class="regular-text formFieldName"/>
                                </td>
                                <td style="position: relative;">
                                    <select name="form[][type]">
                                        <option
                                            value="<?php echo WpProQuiz_Model_Form::FORM_TYPE_TEXT; ?>" <?php echo $checkType[0]; ?>><?php _e('Texto',
                                                'wp-pro-quiz'); ?></option>
                                        <option
                                            value="<?php echo WpProQuiz_Model_Form::FORM_TYPE_TEXTAREA; ?>" <?php echo $checkType[1]; ?>><?php _e('Área de texto',
                                                'wp-pro-quiz'); ?></option>
                                        <option
                                            value="<?php echo WpProQuiz_Model_Form::FORM_TYPE_CHECKBOX; ?>" <?php echo $checkType[2]; ?>><?php _e('Caixa de seleção',
                                                'wp-pro-quiz'); ?></option>
                                        <option
                                            value="<?php echo WpProQuiz_Model_Form::FORM_TYPE_SELECT; ?>" <?php echo $checkType[3]; ?>><?php _e('Menu suspenso',
                                                'wp-pro-quiz'); ?></option>
                                        <option
                                            value="<?php echo WpProQuiz_Model_Form::FORM_TYPE_RADIO; ?>" <?php echo $checkType[4]; ?>><?php _e('Rádio',
                                                'wp-pro-quiz'); ?></option>
                                        <option
                                            value="<?php echo WpProQuiz_Model_Form::FORM_TYPE_NUMBER; ?>" <?php echo $checkType[5]; ?>><?php _e('Número',
                                                'wp-pro-quiz'); ?></option>
                                        <option
                                            value="<?php echo WpProQuiz_Model_Form::FORM_TYPE_EMAIL; ?>" <?php echo $checkType[6]; ?>><?php _e('E-mail',
                                                'wp-pro-quiz'); ?></option>
                                        <option
                                            value="<?php echo WpProQuiz_Model_Form::FORM_TYPE_YES_NO; ?>" <?php echo $checkType[7]; ?>><?php _e('Sim/Não',
                                                'wp-pro-quiz'); ?></option>
                                        <option
                                            value="<?php echo WpProQuiz_Model_Form::FORM_TYPE_DATE; ?>" <?php echo $checkType[8]; ?>><?php _e('Data',
                                                'wp-pro-quiz'); ?></option>
                                    </select>

                                    <a href="#" class="editDropDown"><?php _e('Editar lista', 'wp-pro-quiz'); ?></a>

                                    <div class="dropDownEditBox"
                                         style="position: absolute; border: 1px solid #AFAFAF; background: #EBEBEB; padding: 5px; bottom: 0;right: 0;box-shadow: 1px 1px 1px 1px #AFAFAF; display: none;">
                                        <h4><?php _e('Uma entrada por linha', 'wp-pro-quiz'); ?></h4>

                                        <div>
                                            <textarea rows="5" cols="50"
                                                      name="form[][data]"><?php echo $form->getData() === null ? '' : esc_textarea(implode("\n",
                                                    $form->getData())); ?></textarea>
                                        </div>

                                        <input type="button" value="<?php _e('OK', 'wp-pro-quiz'); ?>"
                                               class="button-primary">
                                    </div>
                                </td>
                                <td>
                                    <input type="checkbox" name="form[][required]"
                                           value="1" <?php $this->checked($form->isRequired()); ?>>
                                </td>
                                <td>
                                    <input type="checkbox" name="form[][show_in_statistic]"
                                           value="1" <?php $this->checked($form->isShowInStatistic()); ?>>
                                </td>
                                <td>
                                    <input type="button" name="form_delete"
                                           value="<?php _e('Excluir', 'wp-pro-quiz'); ?>" class="button-secondary">
                                    <a class="form_move button-secondary" href="#" style="cursor:move;"><?php _e('Mover',
                                            'wp-pro-quiz'); ?></a>

                                    <input type="hidden" name="form[][form_id]"
                                           value="<?php echo $form->getFormId(); ?>">
                                    <input type="hidden" name="form[][form_delete]" value="0">
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                    <div style="margin-top: 10px;">
                        <input type="button" name="form_add" id="form_add"
                               value="<?php _e('Adicionar campo', 'wp-pro-quiz'); ?>" class="button-secondary">
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function postBoxAdminEmailOption()
    {
        /** @var WpProQuiz_Model_Email * */
        $email = $this->quiz->getAdminEmail();
        $email = $email === null ? WpProQuiz_Model_Email::getDefault(true) : $email;
        ?>
        <div class="postbox" id="adminEmailSettings">
            <h3 class="hndle"><?php _e('Configurações de e-mail do administrador', 'wp-pro-quiz'); ?></h3>

            <div class="inside">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <?php _e('Notificação de e-mail do administrador', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Notificação de e-mail do administrador', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="radio" name="emailNotification"
                                           value="<?php echo WpProQuiz_Model_Quiz::QUIZ_EMAIL_NOTE_NONE; ?>" <?php $this->checked($this->quiz->getEmailNotification(),
                                        WpProQuiz_Model_Quiz::QUIZ_EMAIL_NOTE_NONE); ?>>
                                    <?php _e('Desativar', 'wp-pro-quiz'); ?>
                                </label>
                                <label>
                                    <input type="radio" name="emailNotification"
                                           value="<?php echo WpProQuiz_Model_Quiz::QUIZ_EMAIL_NOTE_REG_USER; ?>" <?php $this->checked($this->quiz->getEmailNotification(),
                                        WpProQuiz_Model_Quiz::QUIZ_EMAIL_NOTE_REG_USER); ?>>
                                    <?php _e('somente para usuários registrados', 'wp-pro-quiz'); ?>
                                </label>
                                <label>
                                    <input type="radio" name="emailNotification"
                                           value="<?php echo WpProQuiz_Model_Quiz::QUIZ_EMAIL_NOTE_ALL; ?>" <?php $this->checked($this->quiz->getEmailNotification(),
                                        WpProQuiz_Model_Quiz::QUIZ_EMAIL_NOTE_ALL); ?>>
                                    <?php _e('para todos os usuários', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, você será informado se um usuário concluir este questionário.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Para:', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input type="text" name="adminEmail[to]" value="<?php echo $email->getTo(); ?>"
                                       class="regular-text">
                            </label>

                            <p class="description">
                                <?php _e('Separe vários endereços de e-mail com uma vírgula, por exemplo, wp@test.com, test@test.com',
                                    'wp-pro-quiz'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('De:', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input type="text" name="adminEmail[from]" value="<?php echo $email->getFrom(); ?>"
                                       class="regular-text">
                            </label>
                            <!-- 								<p class="description"> -->
                            <?php //_e('Server-Adresse empfohlen, z.B. info@YOUR-PAGE.com', 'wp-pro-quiz');
                            ?>
                            <!-- 								</p> -->
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Assunto:', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input type="text" name="adminEmail[subject]"
                                       value="<?php echo $email->getSubject(); ?>" class="regular-text">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('HTML', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" name="adminEmail[html]"
                                       value="1" <?php $this->checked($email->isHtml()); ?>> <?php _e('Ativar',
                                    'wp-pro-quiz'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Corpo da mensagem:', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <?php
                            wp_editor($email->getMessage(), 'adminEmailEditor',
                                array('textarea_rows' => 20, 'textarea_name' => 'adminEmail[message]'));
                            ?>

                            <div style="padding-top: 10px;">
                                <table style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th style="padding: 0;">
                                            <?php _e('Variáveis ​​permitidas', 'wp-pro-quiz'); ?>
                                        </th>
                                        <th style="padding: 0;">
                                            <?php _e('Campos personalizados - Variáveis', 'wp-pro-quiz'); ?>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <ul>
                                                <li><span>$userId</span> - <?php _e('ID do usuário', 'wp-pro-quiz'); ?></li>
                                                <li><span>$username</span> - <?php _e('Nome de usuário', 'wp-pro-quiz'); ?>
                                                </li>
                                                <li><span>$quizname</span> - <?php _e('Nome do Questionário', 'wp-pro-quiz'); ?>
                                                </li>
                                                <li><span>$result</span> - <?php _e('Resultado em porcentagem',
                                                        'wp-pro-quiz'); ?></li>
                                                <li><span>$points</span> - <?php _e('Pontos alcançados', 'wp-pro-quiz'); ?>
                                                </li>
                                                <li><span>$ip</span> - <?php _e('Endereço IP do usuário',
                                                        'wp-pro-quiz'); ?></li>
                                                <li><span>$categories</span> - <?php _e('Visão geral da categoria',
                                                        'wp-pro-quiz'); ?></li>
                                            </ul>
                                        </td>
                                        <td style="vertical-align: top;">
                                            <ul class="formVariables"></ul>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <?php

    }

    private function postBoxUserEmailOption()
    {
        /** @var WpProQuiz_Model_Email * */
        $email = $this->quiz->getUserEmail();
        $email = $email === null ? WpProQuiz_Model_Email::getDefault(false) : $email;
        $to = $email->getTo();
        ?>
        <div class="postbox" id="userEmailSettings">
            <h3 class="hndle"><?php _e('Configurações de e-mail do usuário', 'wp-pro-quiz'); ?></h3>

            <div class="inside">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <?php _e('Notificação de e-mail do usuário', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Notificação de e-mail do usuário', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="checkbox" name="userEmailNotification"
                                           value="1" <?php $this->checked($this->quiz->isUserEmailNotification()); ?>>
                                    <?php _e('Ativar', 'wp-pro-quiz'); ?>
                                </label>

                                <p class="description">
                                    <?php _e('Se você habilitar esta opção, um e-mail com o resultado do questionário será enviado ao usuário.',
                                        'wp-pro-quiz'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Para:', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" name="userEmail[toUser]"
                                       value="1" <?php $this->checked($email->isToUser()); ?>>
                                <?php _e('Endereço de e-mail do usuário (somente usuários registrados)', 'wp-pro-quiz'); ?>
                            </label><br>
                            <label>
                                <input type="checkbox" name="userEmail[toForm]"
                                       value="1" <?php $this->checked($email->isToForm()); ?>>
                                <?php _e('Campos personalizados', 'wp-pro-quiz'); ?> :
                                <select name="userEmail[to]" class="emailFormVariables"
                                        data-default="<?php echo empty($to) && $to != 0 ? -1 : $email->getTo(); ?>"></select>
                                <?php _e('(Digite o e-mail)', 'wp-pro-quiz'); ?>
                            </label>

                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('De:', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input type="text" name="userEmail[from]" value="<?php echo $email->getFrom(); ?>"
                                       class="regular-text">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Assunto:', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input type="text" name="userEmail[subject]" value="<?php echo $email->getSubject(); ?>"
                                       class="regular-text">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('HTML', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" name="userEmail[html]"
                                       value="1" <?php $this->checked($email->isHtml()); ?>> <?php _e('Ativar',
                                    'wp-pro-quiz'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?php _e('Corpo da mensagem:', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <?php
                            wp_editor($email->getMessage(), 'userEmailEditor',
                                array('textarea_rows' => 20, 'textarea_name' => 'userEmail[message]'));
                            ?>

                            <div style="padding-top: 10px;">
                                <table style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th style="padding: 0;">
                                            <?php _e('Variáveis ​​permitidas', 'wp-pro-quiz'); ?>
                                        </th>
                                        <th style="padding: 0;">
                                            <?php _e('Campos personalizados - Variáveis', 'wp-pro-quiz'); ?>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <ul>
                                                <li><span>$userId</span> - <?php _e('ID do usuário', 'wp-pro-quiz'); ?></li>
                                                <li><span>$username</span> - <?php _e('Nome de usuário', 'wp-pro-quiz'); ?>
                                                </li>
                                                <li><span>$quizname</span> - <?php _e('Nome do Questionário', 'wp-pro-quiz'); ?>
                                                </li>
                                                <li><span>$result</span> - <?php _e('Resultado em porcentagem',
                                                        'wp-pro-quiz'); ?></li>
                                                <li><span>$points</span> - <?php _e('Pontos alcançados', 'wp-pro-quiz'); ?>
                                                </li>
                                                <li><span>$ip</span> - <?php _e('Endereço IP do usuário',
                                                        'wp-pro-quiz'); ?></li>
                                                <li><span>$categories</span> - <?php _e('Visão geral da categoria',
                                                        'wp-pro-quiz'); ?></li>
                                            </ul>
                                        </td>
                                        <td style="vertical-align: top;">
                                            <ul class="formVariables"></ul>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
}
