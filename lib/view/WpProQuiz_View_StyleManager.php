<?php

class WpProQuiz_View_StyleManager extends WpProQuiz_View_View
{

    public function show()
    {

        ?>


        <div class="wrap">
            <h2 style="margin-bottom: 10px;"><?php echo $this->header; ?></h2>
            <a class="button-secondary" href="admin.php?page=wpProQuiz"><?php _e('voltar para a visão geral',
                    'wp-pro-quiz'); ?></a>

            <form method="post">
                <div id="poststuff">
                    <div class="postbox">
                        <h3 class="hndle"><?php _e('Frente', 'wp-pro-quiz'); ?></h3>

                        <div class="wrap wpProQuiz_quizEdit">
                            <table class="form-table">
                                <tbody>
                                <tr>
                                    <td width="50%">


                                    </td>
                                    <td>


                                        <div style="" class="wpProQuiz_quiz">
                                            <ol class="wpProQuiz_list">


                                                <li class="wpProQuiz_listItem" style="display: list-item;">
                                                    <div class="wpProQuiz_question_page">
                                                        Frage <span>4</span> von <span>7</span>
                                                        <span style="float:right;">1 Punkte</span>

                                                        <div style="clear: right;"></div>
                                                    </div>
                                                    <h3><span>4</span>. Frage</h3>

                                                    <div class="wpProQuiz_question" style="margin: 10px 0px 0px 0px;">
                                                        <div class="wpProQuiz_question_text">
                                                            <p>Frage3</p>
                                                        </div>
                                                        <ul class="wpProQuiz_questionList">


                                                            <li class="wpProQuiz_questionListItem" style="">
                                                                <label>
                                                                    <input class="wpProQuiz_questionInput"
                                                                           type="checkbox" name="question_5_26"
                                                                           value="2"> Test </label>
                                                            </li>
                                                            <li class="wpProQuiz_questionListItem" style="">
                                                                <label>
                                                                    <input class="wpProQuiz_questionInput"
                                                                           type="checkbox" name="question_5_26"
                                                                           value="1"> Test </label>
                                                            </li>
                                                            <li class="wpProQuiz_questionListItem" style="">
                                                                <label>
                                                                    <input class="wpProQuiz_questionInput"
                                                                           type="checkbox" name="question_5_26"
                                                                           value="3"> Test </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="wpProQuiz_response" style="">
                                                        <div style="" class="wpProQuiz_correct">
						<span>
							Korrekt						</span>

                                                            <p>
                                                            </p>
                                                        </div>

                                                    </div>
                                                    <div class="wpProQuiz_tipp" style="display: none;">
                                                        <h3>Tipp</h3>
                                                    </div>
                                                    <input type="button" name="check" value="Prüfen"
                                                           class="wpProQuiz_QuestionButton"
                                                           style="float: left !important; margin-right: 10px !important;">
                                                    <input type="button" name="back" value="Zurück"
                                                           class="wpProQuiz_QuestionButton"
                                                           style="float: left !important; margin-right: 10px !important; ">
                                                    <input type="button" name="next" value="Nächste Frage"
                                                           class="wpProQuiz_QuestionButton" style="float: right; ">

                                                    <div style="clear: both;"></div>
                                                </li>
                                            </ol>
                                        </div>


                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <?php
    }
}