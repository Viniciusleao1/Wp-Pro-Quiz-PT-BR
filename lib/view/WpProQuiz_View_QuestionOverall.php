<?php

/**
 * @property WpProQuiz_Model_Quiz quiz
 * @property  WpProQuiz_Model_Question[] questionItems
 * @property  int questionCount
 * @property WpProQuiz_Model_Category[] categoryItems
 * @property int perPage
 * @property array $exportFormats
 * @property array $importFormats
 */
class WpProQuiz_View_QuestionOverall extends WpProQuiz_View_View {

	public function show() {
?>
<style>
.wpProQuiz_exportList, .wpProQuiz_importList, .wpProQuiz_questionCopy, .wpProQuiz_setQuestionCategoryList {
	padding: 20px;
	background-color: rgb(223, 238, 255);
	border: 1px dotted;
	margin-top: 10px;
}
.wpProQuiz_exportList ul, .wpProQuiz_setQuestionCategoryList ul {
	list-style: none;
	margin: 0;
	padding: 0;
}
.wpProQuiz_exportList li, .wpProQuiz_setQuestionCategoryList li {
	float: left;
	padding: 3px;
	border: 1px solid #B3B3B3;
	margin-right: 5px;
	background-color: #F3F3F3;
}
.sortTable td {
	cursor: move;
}
</style>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		var isEmpty = function(str) {
			str = $.trim(str);
			return (!str || 0 === str.length);
		};

		var ajaxPost = function(func, data, success) {
			var d = {
				action: 'wp_pro_quiz_admin_ajax',
				func: func,
				data: data
			};

			$.post(ajaxurl, d, success, 'json');
		};

		function initGlobal() {
			var $setCategoryBox = $('#wpProQuiz_setQuestionCategoryList_box > div');
			var $categorySelect = $setCategoryBox.find('[name="category"]');

			$categorySelect.change(function() {
				$setCategoryBox.find('#categoryAddBox').toggle($(this).val() == "-1");
			}).change();

			$setCategoryBox.find('#categoryAddBtn').click(function () {
				var name = $.trim($setCategoryBox.find('input[name="categoryAdd"]').val());

				if(isEmpty(name)) {
					return;
				}

				var data = {
					categoryName: name,
					type: 'question'
				};

				ajaxPost('categoryAdd', data, function(json) {
					if(json.err) {
						$('#categoryMsgBox').text(json.err).show('fast').delay(2000).hide('fast');
						return;
					}

					var $option = $(document.createElement('option'))
						.val(json.categoryId)
						.text(json.categoryName)
						.attr('selected', 'selected');

					$categorySelect.append($option).change();

				});
			});

			$setCategoryBox.find('#setCategoriesStart').click(function () {
				var items = getCheckedItems();

				if(!items || !items.length) {
					alert(wpProQuizLocalize.no_selected_quiz);

					return false;
				}

				var data = {
					categoryId: $categorySelect.val(),
					questionIds: items.map(function (i) {
						return i.ID;
					})
				};

				$('#ajaxLoad').show();

				ajaxPost('setQuestionMultipleCategories', data, function(json) {
					location.reload();
				});
			});

			$('.wpProQuiz_import').click(function () {
                showWpProQuizModalBox('', 'wpProQuiz_questionImportList_box');

                return false;
            });
		}

		initGlobal();

		function showWpProQuizModalBox(title, id, height) {
			var width = Math.min($('.wpProQuiz_questionOverall').width() - 50, 600);
			var a = '#TB_inline?width='+ width +'&inlineId=' + id;

			if(height === true) {
				a += '&height=' + ($(window).height() - 100);
			}

			tb_show(title, a, false);
		}

		function getCheckedItems() {
			var items = $('[name="questions[]"]:checked').map(function (i) {
				var $this = $(this);
				var $tr = $this.parents('tr');

				var item = {
					ID: $this.val(),
					name: $.trim($tr.find('.name .row-title').text())
				};

				return item;
			}).get();

			return items;
		}

		function handleExportAction() {
            var items = getCheckedItems();

            if (!items || !items.length)
                return false;

            var $exportBox = $('.wpProQuiz_exportList');
            var $hiddenBox = $exportBox.find('#exportHidden').empty();
            var $ulBox = $exportBox.find('ul').empty();

            $.each(items, function (i, v) {
                $ulBox.append(
                    $('<li>').text(v.name)
                );

                $hiddenBox.append(
                    $('<input type="hidden" name="exportIds[]">').val(v.ID)
                );
            });

            showWpProQuizModalBox('', 'wpProQuiz_questionExportList_box');

            return true;
        }

		function handleSetCategoryAction() {
			var items = getCheckedItems();

			if(!items || !items.length)
				return false;

			var $setCategoryBox = $('.wpProQuiz_setQuestionCategoryList');
			var $hiddenBox = $setCategoryBox.find('#setCategoryHidden').empty();
			var $ulBox = $setCategoryBox.find('ul').empty();

			$.each(items, function (i, v) {
				$ulBox.append(
					$('<li>').text(v.name)
				);

				$hiddenBox.append(
					$('<input type="hidden" name="exportIds[]">').val(v.ID)
				);
			});

			showWpProQuizModalBox('', 'wpProQuiz_setQuestionCategoryList_box');

			return true;
		}

		function handleDeleteAction() {
			var items = getCheckedItems();
			var $form = $('#deleteForm').empty();

			$.each(items, function (i, v) {
				$form.append(
					$('<input>').attr({
						type: 'hidden',
						name: 'ids[]',
						value: v.ID
					})
				);
			});

			$form.submit();
		}

		function handleAction(action) {
			switch (action) {
				case 'set_category':
					handleSetCategoryAction();
					return false;
				case 'delete':
					handleDeleteAction();
					return false;
                case 'export':
                    handleExportAction();
                    return false;
			}

			return true;
		}

		$('#doaction').click(function () {
			return handleAction($('[name="action"]').val());
		});

		$('#doaction2').click(function () {
			return handleAction($('[name="action2"]').val());
		});

		$('#sortQuestionBtn').click(function () {
			var tbody = $('#wpProQuiz_sortQuestion table tbody').empty().sortable();
			var data = {
				quizId: $('[name="quiz_id"]').val()
			};

			ajaxPost('loadQuestionsSort', data, function (json) {
				$.each(json, function (i, v) {
					tbody.append(
						$('<tr>').append(
							$('<td>')
								.text(v.title)
								.data('questionId', v.id)
						)
					);
				});
			});

			showWpProQuizModalBox('', 'wpProQuiz_sortQuestion_box', true);
		});

		$('.saveQuestionSort').click(function () {
			var questionData = $('#wpProQuiz_sortQuestion table tbody tr > td').map(function (i, v) {
				return  $(v).data('questionId');
			}).get();

			var data = {
				sort: questionData
			};

			ajaxPost('questionSaveSort', data, function (json) {
				location.href='?page=wpProQuiz&module=question&quiz_id=' + $('[name="quiz_id"]').val();
			});
		});

		$('#wpProQuiz_questionCopyBtn').click(function () {

			var list = $('#questionCopySelect').hide().empty();

			var data = {
				quizId: $('[name="quiz_id"]').val()
			};

			$('#loadDataImg').show();

			ajaxPost('questionaLoadCopyQuestion', data, function (json) {
				$.each(json, function(i, v) {
						var group = $(document.createElement('optgroup'))
							.attr('label', v.name);

						$.each(v.question, function(qi, qv) {
							$(document.createElement('option'))
								.val(qv.id)
								.text(qv.name)
								.appendTo(group);
						});

						list.append(group);

					});

					$('#loadDataImg').hide();
					list.show();
			});

			showWpProQuizModalBox('', 'wpProQuiz_questionCopy_box', true);
		});

		$('.wpProQuiz_delete').click(function(e) {
			var b = confirm(wpProQuizLocalize.delete_msg);

			if(!b) {
				e.preventDefault();
				return false;
			}

			return true;
		});

	});

</script>

		<?php
			add_thickbox();

			$this->showQuestonExportListBox();
			$this->showQuestionImportListBox();
			$this->showSetQuestionCategoryListBox();
			$this->showSortQuestionBox();
			$this->showCopyQuestionBox();
		?>


<div class="wrap wpProQuiz_questionOverall">
	<h2>
		<?php printf(__('Questionário: %s', 'wp-pro-quiz'), $this->quiz->getName()); ?>

		<?php if(current_user_can('wpProQuiz_edit_quiz')) { ?>
			<a class="add-new-h2" href="?page=wpProQuiz&module=question&action=addEdit&quiz_id=<?php echo $this->quiz->getId(); ?>"><?php _e('Adicionar pergunta', 'wp-pro-quiz'); ?></a>
		<?php } ?>
        <?php if (current_user_can('wpProQuiz_import')) { ?>
            <a class="add-new-h2 wpProQuiz_import" href="#"><?php echo __('Importar', 'wp-pro-quiz'); ?></a>
        <?php } ?>

		<?php do_action('wpProQuiz_view_questionOverall_head_buttons', $this); ?>
	</h2>

	<p>
		<a class="" href="admin.php?page=wpProQuiz"><?php _e('voltar para a visão geral', 'wp-pro-quiz'); ?></a>
	</p>

	<p>
		<?php if(current_user_can('wpProQuiz_edit_quiz')) { ?>
			<a class="button-secondary" href="admin.php?page=wpProQuiz&action=addEdit&quizId=<?php echo $this->quiz->getId(); ?>"><?php _e('Editar questionário', 'wp-pro-quiz'); ?></a>
			<a class="button-secondary" id="sortQuestionBtn" href="#"><?php _e('Classificar questão', 'wp-pro-quiz'); ?></a>
			<a class="button-secondary" href="#" id="wpProQuiz_questionCopyBtn"><?php _e('Copiar questões de outro questionário', 'wp-pro-quiz'); ?></a>
		<?php } ?>
        <?php do_action('wpProQuiz_view_questionOverall_body_buttons', $this); ?>
	</p>

	<form action="?page=wpProQuiz&module=question&action=delete_multi&quiz_id=<?php echo $this->quiz->getId(); ?>" method="post" style="display: none;" id="deleteForm">

	</form>

	<form method="get">
		<input type="hidden" name="page" value="wpProQuiz">
		<input type="hidden" name="module" value="question">
		<input type="hidden" name="quiz_id" value="<?php echo $this->quiz->getId(); ?>">
	<?php
		if(!class_exists('WP_List_Table')){
			require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
		}

		$table = new WpProQuiz_View_QuestionOverallTable($this->questionItems, $this->questionCount, $this->categoryItems, $this->perPage);

		$table->prepare_items();

		?>
			<p class="search-box">
				<?php $table->search_box( __('Search'), 'search_id' ); ?>
			</p>
		<?php

		$table->display();
	?>
	</form>

	<?php
	}

	protected function showCopyQuestionBox() {
		?>

		<div id="wpProQuiz_questionCopy_box" style="display: none;">
			<div class="wpProQuiz_questionCopy">
				<form action="admin.php?page=wpProQuiz&module=question&quiz_id=<?php echo $this->quiz->getId(); ?>&action=copy_question" method="POST">
					<h3 style="margin-top: 0;"><?php _e('Copiar questões de outro questionário', 'wp-pro-quiz'); ?></h3>
					<p><?php echo __('Aqui você pode copiar questões de outro questionário para este questionário. (Seleção múltipla habilitada)', 'wp-pro-quiz'); ?></p>

					<div style="padding: 20px; display: none;" id="loadDataImg">
						<img alt="load" src="data:image/gif;base64,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">
						<?php echo __('Carregando', 'wp-pro-quiz'); ?>
					</div>

					<div style="padding: 10px;">
						<select name="copyIds[]" size="15" multiple="multiple" style="min-width: 200px; display: none;" id="questionCopySelect">
						</select>
					</div>

					<input class="button-primary" name="questionCopy" value="<?php echo __('Copiar questões', 'wp-pro-quiz'); ?>" type="submit">
				</form>
			</div>
		</div>

		<?php
	}

	protected function showSetQuestionCategoryListBox() {
		?>

		<div id="wpProQuiz_setQuestionCategoryList_box" style="display: none;">
			<div class="wpProQuiz_setQuestionCategoryList">
				<form action="#" method="POST">
					<h3 style="margin-top: 0;"><?php _e('Definir categorias de questões', 'wp-pro-quiz'); ?></h3>
					<p><?php _e('Define várias categorias de questões', 'wp-pro-quiz'); ?></p>
					<div style="margin-bottom: 10px">
					</div>
					<ul></ul>
					<div style="clear: both; margin-bottom: 10px;"></div>
					<div id="setCategoryHidden"></div>

					<div style="margin-bottom: 10px;">
						<p class="description">
							<?php _e('Você pode atribuir uma categoria de classificação para uma questão.', 'wp-pro-quiz'); ?>
						</p>
						<p class="description">
							<?php _e('Você pode gerenciar categorias nas configurações globais.', 'wp-pro-quiz'); ?>
						</p>
						<div>
							<select name="category">
								<option value="-1">--- <?php _e('Criar nova categoria', 'wp-pro-quiz'); ?> ----</option>
								<option value="0" selected="selected">--- <?php _e('Nenhuma categoria', 'wp-pro-quiz'); ?> ---</option>
								<?php
								foreach($this->categoryItems as $cat) {
									echo '<option value="'.$cat->getCategoryId().'">'.$cat->getCategoryName().'</option>';
								}
								?>
							</select>
						</div>
						<div style="display: none;" id="categoryAddBox">
							<h4><?php _e('Criar nova categoria', 'wp-pro-quiz'); ?></h4>
							<input type="text" name="categoryAdd" value="">
							<input type="button" class="button-secondary" name="" id="categoryAddBtn" value="<?php _e('Criar', 'wp-pro-quiz'); ?>">
						</div>
						<div id="categoryMsgBox" style="display:none; padding: 5px; border: 1px solid rgb(160, 160, 160); background-color: rgb(255, 255, 168); font-weight: bold; margin: 5px; ">
							<?php _e('Categoria salva', 'wp-pro-quiz'); ?>
						</div>
					</div>

					<input class="button-primary" name="setCategoriesStart" id="setCategoriesStart" value="<?php _e('Salvar', 'wp-pro-quiz'); ?>" type="button">
					<img id="ajaxLoad" style="display: none;" alt="load" src="data:image/gif;base64,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">
				</form>
			</div>
		</div>

	<?php
	}

	protected function showSortQuestionBox() {
		?>

		<div id="wpProQuiz_sortQuestion_box" style="display: none;">
			<div id="wpProQuiz_sortQuestion">
				<h4><?php _e('Classificar questões', 'wp-pro-quiz'); ?></h4>
				<p>
					<a href="#" class="button-secondary saveQuestionSort"><?php _e( 'Salvar' ); ?></a>
				</p>
				<table class="widefat sortTable">
					<tbody>
					</tbody>
				</table>
				<p>
					<a href="#" class="button-secondary saveQuestionSort"><?php _e( 'Salvar' ); ?></a>
				</p>
			</div>
		</div>
		<?php
	}

	protected function showQuestonExportListBox()
    {
        ?>

        <div id="wpProQuiz_questionExportList_box" style="display: none;">
            <div class="wpProQuiz_exportList">
                <form action="<?php echo admin_url('admin.php?page=wpProQuiz&module=questionExport&action=export&noheader=true'); ?>" method="POST">
                    <h3 style="margin-top: 0;"><?php _e('Exportar', 'wp-pro-quiz'); ?></h3>

                    <p><?php echo __('Selecione a respectiva pergunta que você deseja exportar e clique em "Iniciar exportação"',
                            'wp-pro-quiz'); ?></p>

                    <?php do_action('wpProQuiz_view_questionOverall_exportListBox', $this); ?>

                    <ul></ul>
                    <div style="clear: both; margin-bottom: 10px;"></div>
                    <div id="exportHidden"></div>
                    <div style="margin-bottom: 15px;">
                        <label><?php _e('Format:'); ?></label>
                        <select name="exportType">
                            <?php
                                foreach ($this->exportFormats as $key => $value) {
                                    echo '<option value="'.esc_attr($key).'">'.esc_html($value).'</option>';
                                }
                                ?>
                        </select>
                    </div>
                    <input class="button-primary" name="exportStart" id="exportStart"
                           value="<?php echo __('Iniciar exportação', 'wp-pro-quiz'); ?>" type="submit">
                </form>
            </div>
        </div>

        <?php
    }

    protected function showQuestionImportListBox()
    {
        ?>

        <div id="wpProQuiz_questionImportList_box" style="display: none;">
            <div class="wpProQuiz_importList">
                <form action="<?php echo admin_url('admin.php?page=wpProQuiz&module=questionImport&action=preview&quizId='.$this->quiz->getId()); ?>" method="POST"
                      enctype="multipart/form-data">
                    <h3 style="margin-top: 0;"><?php _e('Importar', 'wp-pro-quiz'); ?></h3>

                    <p><?php _e('Importe apenas arquivos de fontes conhecidas e confiáveis.', 'wp-pro-quiz'); ?></p>
                    <p><?php echo sprintf(__('Formatos suportados: %s', 'wp-pro-quiz'), implode(', ', $this->importFormats['extensions'])) ?></p>

                    <?php do_action('wpProQuiz_view_questionOverall_importListBox', $this); ?>

                    <div style="margin-bottom: 10px">
                        <?php
                        $uploadMB = $this->getMaxUploadSize();
                        ?>
                        <input type="file" name="import" accept="<?php echo implode(',', $this->importFormats['accept']) ?>"
                               required="required"> <?php printf(__('Máximo %d MiB', 'wp-pro-quiz'), $uploadMB); ?>
                    </div>
                    <input class="button-primary" name="importStart" id="importStart"
                           value="<?php _e('Iniciar importação', 'wp-pro-quiz'); ?>" type="submit">
                </form>
            </div>
        </div>

        <?php
    }

    protected function getMaxUploadSize()
    {
        $maxUpload = (int)(ini_get('upload_max_filesize'));
        $maxPost = (int)(ini_get('post_max_size'));
        $memoryLimit = (int)(ini_get('memory_limit'));
        $uploadMB = min($maxUpload, $maxPost, $memoryLimit);

        return apply_filters('wpProQuiz_filter_max_update_size', $uploadMB);
    }
}
