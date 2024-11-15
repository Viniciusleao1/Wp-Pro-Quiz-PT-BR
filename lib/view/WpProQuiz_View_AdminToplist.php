<?php

/**
 * @property WpProQuiz_Model_Quiz quiz
 */
class WpProQuiz_View_AdminToplist extends WpProQuiz_View_View
{

    public function show()
    {
        ?>
        <div class="wrap wpProQuiz_toplist">

            <input type="hidden" name="ajax_quiz_id" value="<?php echo $this->quiz->getId(); ?>">

            <h2><?php _e('Leaderboard', 'wp-pro-quiz');
                echo ': ', $this->quiz->getName(); ?></h2>
            <a class="button-secondary" href="admin.php?page=wpProQuiz"><?php _e('voltar à visão geral',
                    'wp-pro-quiz'); ?></a>

            <div id="poststuff">
                <div class="postbox">
                    <h3 class="hndle"><?php _e('Filtro', 'wp-pro-quiz'); ?></h3>

                    <div class="inside">
                        <ul>
                            <li>
                                <label>
                                    <?php _e('Ordenar por:', 'wp-pro-quiz'); ?>
                                    <select id="wpProQuiz_sorting">
                                        <option
                                            value="<?php echo WpProQuiz_Model_Quiz::QUIZ_TOPLIST_SORT_BEST; ?>"><?php _e('melhor usuário',
                                                'wp-pro-quiz'); ?></option>
                                        <option
                                            value="<?php echo WpProQuiz_Model_Quiz::QUIZ_TOPLIST_SORT_NEW; ?>"><?php _e('entrada mais recente',
                                                'wp-pro-quiz'); ?></option>
                                        <option
                                            value="<?php echo WpProQuiz_Model_Quiz::QUIZ_TOPLIST_SORT_OLD; ?>"><?php _e('entrada mais antiga',
                                                'wp-pro-quiz'); ?></option>
                                    </select>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <?php _e('Quantas entradas devem ser mostradas em uma página:', 'wp-pro-quiz'); ?>
                                    <select id="wpProQuiz_pageLimit">
                                        <option>1</option>
                                        <option>10</option>
                                        <option>50</option>
                                        <option selected="selected">100</option>
                                        <option>500</option>
                                        <option>1000</option>
                                    </select>
                                </label>
                            </li>
                            <li>
                                <span style="font-weight: bold;"><?php _e('Tipo', 'wp-pro-quiz'); ?>
                                    :</span> <?php _e('UR = usuário não registrado, R = usuário registrado', 'wp-pro-quiz'); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="wpProQuiz_loadData" class="wpProQuiz_blueBox"
                 style="background-color: #F8F5A8;padding: 20px;border: 1px dotted;margin-top: 10px;">
                <img alt="load"
                     src="data:image/gif;base64,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">
                <?php _e('Carregando', 'wp-pro-quiz'); ?>
            </div>

            <div id="wpProQuiz_content">
                <table class="wp-list-table widefat" id="wpProQuiz_toplistTable">
                    <thead>
                    <tr>
                        <th scope="col" width="20px"><input style="margin: 0;" type="checkbox" value="0"
                                                            id="wpProQuiz_checkedAll"></th>
                        <th scope="col"><?php _e('Usuário', 'wp-pro-quiz'); ?></th>
                        <th scope="col"><?php _e('E-Mail', 'wp-pro-quiz'); ?></th>
                        <th scope="col" width="50px"><?php _e('Tipo', 'wp-pro-quiz'); ?></th>
                        <th scope="col" width="150px"><?php _e('Entrou em', 'wp-pro-quiz'); ?></th>
                        <th scope="col" width="70px"><?php _e('Pontos', 'wp-pro-quiz'); ?></th>
                        <th scope="col" width="100px"><?php _e('Resultados', 'wp-pro-quiz'); ?></th>
                    </tr>
                    </thead>
                    <tbody id="">
                    <tr style="display: none;">
                        <td><input type="checkbox" name="checkedData[]"></td>
                        <td>
                            <strong class="wpProQuiz_username"></strong>
                            <input name="inline_editUsername" class="inline_editUsername" type="text" value=""
                                   style="display: none;">

                            <div class="row-actions">
													
							<span style="display: none;">
								<a class="wpProQuiz_edit" href="#"><?php _e('Editar', 'wp-pro-quiz'); ?></a> | 
							</span>
							<span>
								<a style="color: red;" class="wpProQuiz_delete" href="#"><?php _e('Excluir',
                                        'wp-pro-quiz'); ?></a>
							</span>

                            </div>
                            <div class="inline-edit" style="margin-top: 10px; display: none;">
                                <input type="button" value="<?php _e('salvar', 'wp-pro-quiz'); ?>"
                                       class="button-secondary inline_editSave">
                                <input type="button" value="<?php _e('cancelar', 'wp-pro-quiz'); ?>"
                                       class="button-secondary inline_editCancel">
                            </div>
                        </td>
                        <td>
                            <span class="wpProQuiz_email"></span>
                            <input name="inline_editEmail" class="inline_editEmail" value="" type="text"
                                   style="display: none;">
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight: bold;"></td>
                    </tr>
                    </tbody>
                </table>

                <div style="margin-top: 10px;">
                    <div style="float: left;">
                        <select id="wpProQuiz_actionName">
                            <option value="0" selected="selected"><?php _e('Ação', 'wp-pro-quiz'); ?></option>
                            <option value="delete"><?php _e('Excluir', 'wp-pro-quiz'); ?></option>
                        </select>
                        <input class="button-secondary" type="button" value="<?php _e('Aplicar', 'wp-pro-quiz'); ?>"
                               id="wpProQuiz_action">
                        <input class="button-secondary" type="button"
                               value="<?php _e('Excluir todas as entradas', 'wp-pro-quiz'); ?>" id="wpProQuiz_deleteAll">
                    </div>
                    <div style="float: right;">
                        <input style="font-weight: bold;" class="button-secondary" value="&lt;" type="button"
                               id="wpProQuiz_pageLeft">
                        <select id="wpProQuiz_currentPage">
                            <option value="1">1</option>
                        </select>
                        <input style="font-weight: bold;" class="button-secondary" value="&gt;" type="button"
                               id="wpProQuiz_pageRight">
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>

        <?php
    }
}