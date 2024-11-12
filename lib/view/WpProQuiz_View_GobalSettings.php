<?php

/**
 * @property WpProQuiz_Model_GlobalSettings settings
 * @property bool isRaw
 * @property WpProQuiz_Model_Category[] category
 * @property WpProQuiz_Model_Category[] categoryQuiz
 * @property array email
 * @property array userEmail
 * @property WpProQuiz_Model_Template[] templateQuiz
 * @property WpProQuiz_Model_Template[] templateQuestion
 * @property string toplistDataFormat
 * @property string statisticTimeFormat
 */
class WpProQuiz_View_GobalSettings extends WpProQuiz_View_View
{

    public function show()
    {
        ?>
        <style>
            .wpProQuiz-tab-content:not(.wpProQuiz-tab-content-active) {
                display: none;
            }
        </style>

        <div class="wrap wpProQuiz_globalSettings">
            <h2 style="margin-bottom: 10px;"><?php _e('Configurações globais', 'wp-pro-quiz'); ?></h2>

            <div class="nav-tab-wrapper wpProQuiz-top-tab-wrapper">
                <a href="#globalContent" data-tab="globalContent" class="nav-tab nav-tab-active"><?php _e('Configurações globais', 'wp-pro-quiz'); ?></a>
                <a href="#problemContent" data-tab="problemContent" class="nav-tab "><?php _e('Configurações em caso de problemas', 'wp-pro-quiz'); ?></a>
            </div>

            <form method="post">
                <div id="poststuff">
                    <div id="globalContent" class="wpProQuiz-tab-content wpProQuiz-tab-content-active">

                        <?php $this->globalSettings(); ?>

                    </div>

                    <div id="problemContent" class="wpProQuiz-tab-content">
                        <div class="postbox">
                            <?php $this->problemSettings(); ?>
                        </div>
                    </div>

                    <input type="submit" name="submit" class="button-primary" id="wpProQuiz_save"
                           value="<?php _e('Salvar', 'wp-pro-quiz'); ?>">
                </div>
            </form>
        </div>

        <?php
    }

    private function globalSettings()
    {

        ?>
        <div class="postbox">
            <h3 class="hndle"><?php _e('Configurações globais', 'wp-pro-quiz'); ?></h3>

            <div class="inside">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <?php _e('Formato de tempo da Leaderboard', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Formato de tempo da Leaderboard', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <label>
                                    <input type="radio" name="toplist_date_format"
                                           value="d.m.Y H:i" <?php $this->checked($this->toplistDataFormat,
                                        'd.m.Y H:i'); ?>> 06.11.2010 12:50
                                </label> <br>
                                <label>
                                    <input type="radio" name="toplist_date_format"
                                           value="Y/m/d g:i A" <?php $this->checked($this->toplistDataFormat,
                                        'Y/m/d g:i A'); ?>> 2010/11/06 12:50 AM
                                </label> <br>
                                <label>
                                    <input type="radio" name="toplist_date_format"
                                           value="Y/m/d \a\t g:i A" <?php $this->checked($this->toplistDataFormat,
                                        'Y/m/d \a\t g:i A'); ?>> 2010/11/06 at 12:50 AM
                                </label> <br>
                                <label>
                                    <input type="radio" name="toplist_date_format"
                                           value="Y/m/d \a\t g:ia" <?php $this->checked($this->toplistDataFormat,
                                        'Y/m/d \a\t g:ia'); ?>> 2010/11/06 at 12:50am
                                </label> <br>
                                <label>
                                    <input type="radio" name="toplist_date_format"
                                           value="F j, Y g:i a" <?php $this->checked($this->toplistDataFormat,
                                        'F j, Y g:i a'); ?>> November 6, 2010 12:50 am
                                </label> <br>
                                <label>
                                    <input type="radio" name="toplist_date_format"
                                           value="M j, Y @ G:i" <?php $this->checked($this->toplistDataFormat,
                                        'M j, Y @ G:i'); ?>> Nov 6, 2010 @ 0:50
                                </label> <br>
                                <label>
                                    <input type="radio" name="toplist_date_format"
                                           value="custom" <?php echo in_array($this->toplistDataFormat, array(
                                        'd.m.Y H:i',
                                        'Y/m/d g:i A',
                                        'Y/m/d \a\t g:i A',
                                        'Y/m/d \a\t g:ia',
                                        'F j, Y g:i a',
                                        'M j, Y @ G:i'
                                    )) ? '' : 'checked="checked"'; ?> >
                                    <?php _e('Personalizado', 'wp-pro-quiz'); ?>:
                                    <input class="medium-text" name="toplist_date_format_custom" style="width: 100px;"
                                           value="<?php echo $this->toplistDataFormat; ?>">
                                </label>

                                <p>
                                    <a href="http://codex.wordpress.org/Formatting_Date_and_Time"
                                       target="_blank"><?php _e('Documentação sobre formatação de data e hora',
                                            'wp-pro-quiz'); ?></a>
                                </p>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <?php _e('Formato de tempo estatístico', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Formato de tempo estatístico', 'wp-pro-quiz'); ?></span>
                                </legend>

                                <label>
                                    <?php _e('Selecione um exemplo:', 'wp-pro-quiz'); ?>
                                    <select id="statistic_time_format_select">
                                        <option value="0"></option>
                                        <option value="d.m.Y H:i"> 06.11.2010 12:50</option>
                                        <option value="Y/m/d g:i A"> 2010/11/06 12:50 AM</option>
                                        <option value="Y/m/d \a\t g:i A"> 2010/11/06 at 12:50 AM</option>
                                        <option value="Y/m/d \a\t g:ia"> 2010/11/06 at 12:50am</option>
                                        <option value="F j, Y g:i a"> November 6, 2010 12:50 am</option>
                                        <option value="M j, Y @ G:i"> Nov 6, 2010 @ 0:50</option>
                                    </select>
                                </label>

                                <div style="margin-top: 10px;">
                                    <label>
                                        <?php _e('Formato de hora:', 'wp-pro-quiz'); ?>:
                                        <input class="medium-text" name="statisticTimeFormat"
                                               value="<?php echo $this->statisticTimeFormat; ?>">
                                    </label>

                                    <p>
                                        <a href="http://codex.wordpress.org/Formatting_Date_and_Time"
                                           target="_blank"><?php _e('Documentação sobre formatação de data e hora',
                                                'wp-pro-quiz'); ?></a>
                                    </p>
                                </div>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <?php _e('Gerenciamento de categorias', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Gerenciamento de categorias', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <select name="category">
                                    <?php foreach ($this->category as $cat) {
                                        echo '<option value="' . $cat->getCategoryId() . '">' . $cat->getCategoryName() . '</option>';

                                    } ?>
                                </select>

                                <div style="padding-top: 5px;">
                                    <input type="text" value="" name="categoryEditText">
                                </div>
                                <div style="padding-top: 5px;">
                                    <input type="button" value="<?php _e('Excluir', 'wp-pro-quiz'); ?>"
                                           name="categoryDelete" class="button-secondary">
                                    <input type="button" value="<?php _e('Editar', 'wp-pro-quiz'); ?>" name="categoryEdit"
                                           class="button-secondary">
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>

                        <th scope="row">
                            <?php _e('Gerenciamento de categoria de questionário', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Gerenciamento de categoria de questionário', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <select name="categoryQuiz">
                                    <?php foreach ($this->categoryQuiz as $cat) {
                                        echo '<option value="' . $cat->getCategoryId() . '">' . $cat->getCategoryName() . '</option>';

                                    } ?>
                                </select>

                                <div style="padding-top: 5px;">
                                    <input type="text" value="" name="categoryQuizEditText">
                                </div>
                                <div style="padding-top: 5px;">
                                    <input type="button" value="<?php _e('Excluir', 'wp-pro-quiz'); ?>"
                                           name="categoryQuizDelete" class="button-secondary">
                                    <input type="button" value="<?php _e('Editar', 'wp-pro-quiz'); ?>"
                                           name="categoryQuizEdit" class="button-secondary">
                                </div>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <?php _e('Gerenciamento de modelos de questionário', 'wp-pro-quiz'); ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php _e('Gerenciamento de modelos de questionário', 'wp-pro-quiz'); ?></span>
                                </legend>
                                <select name="templateQuiz">
                                    <?php foreach ($this->templateQuiz as $templateQuiz) {
                                        echo '<option value="' . $templateQuiz->getTemplateId() . '">' . esc_html($templateQuiz->getName()) . '</option>';

                                    } ?>
                                </select>

                                <div style="padding-top: 5px;">
                                    <input type="text" value="" name="templateQuizEditText">
                                </div>
                                <div style="padding-top: 5px;">
                                    <input type="button" value="<?php _e('Excluir', 'wp-pro-quiz'); ?>"
                                           name="templateQuizDelete" class="button-secondary">
                                    <input type="button" value="<?php _e('Editar', 'wp-pro-quiz'); ?>"
                                           name="templateQuizEdit" class="button-secondary">
                                </div>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
<th scope="row">
    <?php _e('Gerenciamento de modelos de questões', 'wp-pro-quiz'); ?>
</th>
<td>
    <fieldset>
        <legend class="screen-reader-text">
            <span><?php _e('Gerenciamento de modelos de questões', 'wp-pro-quiz'); ?></span>
        </legend>
        <select name="templateQuestion">
            <?php foreach ($this->templateQuestion as $templateQuestion) {
                echo '<option value="' . $templateQuestion->getTemplateId() . '">' . esc_html($templateQuestion->getName()) . '</option>';
            } ?>
        </select>
        <div style="padding-top: 5px;">
            <input type="text" value="" name="templateQuestionEditText">
        </div>
        <div style="padding-top: 5px;">
            <input type="button" value="<?php _e('Excluir', 'wp-pro-quiz'); ?>" name="templateQuestionDelete" class="button-secondary">
            <input type="button" value="<?php _e('Editar', 'wp-pro-quiz'); ?>" name="templateQuestionEdit" class="button-secondary">
        </div>
    </fieldset>
</td>
</tr>
</tbody>
</table>

</div>
</div>

<!-- Seção para Exemplos de Shortcodes com Dropdown -->
<h2><?php _e('Exemplos de Shortcodes para Gráficos', 'wp-pro-quiz'); ?></h2>
<p><?php _e('Utilize os seguintes shortcodes para adicionar gráficos relacionados ao quiz em suas páginas ou posts.', 'wp-pro-quiz'); ?></p>

<style>
    /* Estilos Gerais */
    h3 {
        background-color: #0073aa; /* Cor de fundo */
        color: white; /* Cor do texto */
        padding: 10px; /* Padding para o título */
        border-radius: 5px; /* Bordas arredondadas */
        cursor: pointer; /* Cursor de ponteiro */
        margin: 5px 0; /* Margem para separar os títulos */
        transition: background-color 0.3s; /* Transição suave */
    }

    h3:hover {
        background-color: #005177; /* Cor ao passar o mouse */
    }

    /* Estilos do Dropdown */
    div[id$="Dropdown"] {
        display: none; /* Inicialmente escondido */
        margin-left: 20px; /* Recuo à esquerda */
        height: 100px;
        padding: 10px; /* Padding interno */
        border: 1px solid #0073aa; /* Borda */
        border-radius: 5px; /* Bordas arredondadas */
        background-color: #f9f9f9; /* Cor de fundo do dropdown */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombreamento */
        transition: all 0.3s; /* Transição suave de estilo */
    }

    div[id$="Dropdown"]:hover {
        background-color: #e9e9e9; /* Cor de fundo ao passar o mouse */
    }

    code {
        display: block; /* Ocupa a linha toda */
        background-color: #e1e1e1; /* Cor de fundo do código */
        padding: 5px; /* Padding para o código */
        border-radius: 4px; /* Bordas arredondadas para o código */
        font-family: monospace; /* Fonte monoespaçada */
        margin: 5px 0; /* Margem para separação */
    }
</style>

<script>
    function toggleDropdown(dropdownId) {
        var dropdownContent = document.getElementById(dropdownId);
        dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
    }
</script>

<div>
    <h3 onclick="toggleDropdown('pieChartDropdown')">
        <?php _e('Gráfico de Pizza', 'wp-pro-quiz'); ?>
    </h3>
    <div id="pieChartDropdown">
        <p><?php _e('Para exibir o gráfico de pizza com o ID do quiz 1:', 'wp-pro-quiz'); ?></p>
        <code><?php echo esc_html('[wp_pro_quiz_pie_chart quiz_id="1"]'); ?></code>
        <div>
            <?php echo do_shortcode('[wp_pro_quiz_pie_chart quiz_id="1"]'); ?>
        </div>
    </div>
</div>

<div>
    <h3 onclick="toggleDropdown('lineChartDropdown')">
        <?php _e('Gráfico de Linha', 'wp-pro-quiz'); ?>
    </h3>
    <div id="lineChartDropdown">
        <p><?php _e('Para exibir o gráfico de linha com o ID do quiz 1:', 'wp-pro-quiz'); ?></p>
        <code><?php echo esc_html('[wp_pro_quiz_line_chart quiz_id="1"]'); ?></code>
        <div>
            <?php echo do_shortcode('[wp_pro_quiz_line_chart quiz_id="1"]'); ?>
        </div>
    </div>
</div>

<div>
    <h3 onclick="toggleDropdown('barChartDropdown')">
        <?php _e('Gráfico de Barras', 'wp-pro-quiz'); ?>
    </h3>
    <div id="barChartDropdown">
        <p><?php _e('Para exibir o gráfico de barra com o ID do quiz 1:', 'wp-pro-quiz'); ?></p>
        <code><?php echo esc_html('[wp_pro_quiz_bar_chart quiz_id="1"]'); ?></code>
        <div>
            <?php echo do_shortcode('[wp_pro_quiz_bar_chart quiz_id="1"]'); ?>
        </div>
    </div>
</div>

<div>
    <h3 onclick="toggleDropdown('extraLineChartDropdown')">
        <?php _e('Gráfico de Linha Adicional', 'wp-pro-quiz'); ?>
    </h3>
    <div id="extraLineChartDropdown">
        <p><?php _e('Para exibir o gráfico de linha adicional com o ID do quiz 1:', 'wp-pro-quiz'); ?></p>
        <code><?php echo esc_html('[wp_pro_quiz_extra_line_chart quiz_id="1"]'); ?></code>
        <div>
            <?php echo do_shortcode('[wp_pro_quiz_extra_line_chart quiz_id="1"]'); ?>
        </div>
    </div>
</div>



<?php
}


    private function problemSettings()
    {
        if ($this->isRaw) {
            $rawSystem = __('para ativar', 'wp-pro-quiz');
        } else {
            $rawSystem = __('não ativar', 'wp-pro-quiz');
        }

        ?>

        <div class="updated" id="problemInfo" style="display: none;">
            <h3><?php _e('Observe', 'wp-pro-quiz'); ?></h3>

            <p>
                <?php _e('Essas configurações só devem ser definidas em casos de problemas com o Wp-Pro-Quiz-PT-BR.', 'wp-pro-quiz'); ?>
            </p>
        </div>

        <h3 class="hndle"><?php _e('Configurações em caso de problemas', 'wp-pro-quiz'); ?></h3>
        <div class="inside">
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row">
                        <?php _e('Adicionar automaticamente shortcode [raw]', 'wp-pro-quiz'); ?>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e('Adicionar automaticamente shortcode [raw]', 'wp-pro-quiz'); ?></span>
                            </legend>
                            <label>
                                <input type="checkbox" value="1"
                                       name="addRawShortcode" <?php echo $this->settings->isAddRawShortcode() ? 'checked="checked"' : '' ?> >
                                <?php _e('Ativar', 'wp-pro-quiz'); ?> <span
                                    class="description">( <?php printf(__('É recomendável %s esta opção no seu sistema.',
                                        'wp-pro-quiz'),
                                        '<span style=" font-weight: bold;">' . $rawSystem . '</span>'); ?> )</span>
                            </label>

                            <p class="description">
                                <?php _e('Se esta opção estiver ativada, um shortcode [raw] será automaticamente definido em torno do shortcode WpProQuiz ( [WpProQuiz X] ) em [raw] [WpProQuiz X] [/raw]',
                                    'wp-pro-quiz'); ?>
                            </p>

                            <p class="description">
                                <?php _e('Temas próprios alteram a ordem interna dos filtros, o que causa os problemas. Com shortcode adicional [raw] isso é prevenido.',
                                    'wp-pro-quiz'); ?>
                            </p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php _e('Não carregue os arquivos Javascript no rodapé', 'wp-pro-quiz'); ?>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e('Não carregue os arquivos Javascript no rodapé',
                                        'wp-pro-quiz'); ?></span>
                            </legend>
                            <label>
                                <input type="checkbox" value="1"
                                       name="jsLoadInHead" <?php echo $this->settings->isJsLoadInHead() ? 'checked="checked"' : '' ?> >
                                <?php _e('Ativar', 'wp-pro-quiz'); ?>
                            </label>

                            <p class="description">
                                <?php _e('Geralmente todos os arquivos WpProQuiz-Javascript são carregados no rodapé e somente quando são realmente necessários.',
                                    'wp-pro-quiz'); ?>
                            </p>

                            <p class="description">
                                <?php _e('Em temas muito antigos do Wordpress isso pode causar problemas.', 'wp-pro-quiz'); ?>
                            </p>

                            <p class="description">
                                <?php _e('Se você ativar esta opção, todos os arquivos WpProQuiz-Javascript serão carregados no cabeçalho, mesmo que não sejam necessários.',
                                    'wp-pro-quiz'); ?>
                            </p>

                            <p class="description">
                                <?php printf(__('Qualquer pessoa que queira aprender mais sobre este tópico deve ler os seguintes sites %s e %s.',
                                    'wp-pro-quiz'),
                                    '<a href="http://codex.wordpress.org/Theme_Development#Footer_.28footer.php.29" target="_blank">Theme Development</a>',
                                    '<a href="http://codex.wordpress.org/Function_Reference/wp_footer" target="_blank">Function Reference/wp footer</a>'); ?>
                            </p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php _e('Biblioteca de toque', 'wp-pro-quiz'); ?>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e('Biblioteca de toque', 'wp-pro-quiz'); ?></span>
                            </legend>
                            <label>
                                <input type="checkbox" value="1"
                                       name="touchLibraryDeactivate" <?php echo $this->settings->isTouchLibraryDeactivate() ? 'checked="checked"' : '' ?> >
                                <?php _e('Desativar', 'wp-pro-quiz'); ?>
                            </label>

                            <p class="description">
                                <?php _e('Na versão 0.13, uma nova Biblioteca Touch foi adicionada para dispositivos móveis.',
                                    'wp-pro-quiz'); ?>
                            </p>

                            <p class="description">
                                <?php _e('Se você tiver algum problema com a Biblioteca Touch, desative-a.',
                                    'wp-pro-quiz'); ?>
                            </p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php _e('Suporte jQuery cors', 'wp-pro-quiz'); ?>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e('Suporte jQuery cors', 'wp-pro-quiz'); ?></span>
                            </legend>
                            <label>
                                <input type="checkbox" value="1"
                                       name="corsActivated" <?php echo $this->settings->isCorsActivated() ? 'checked="checked"' : '' ?> >
                                <?php _e('Ativar', 'wp-pro-quiz'); ?>
                            </label>

                            <p class="description">
                                <?php _e('É necessário apenas em casos raros.', 'wp-pro-quiz'); ?>
                            </p>

                            <p class="description">
                                <?php _e('Se você tiver problemas com o ajax frontal, ative-o.',
                                    'wp-pro-quiz'); ?>
                            </p>

                            <p class="description">
                                <?php _e('por exemplo, Domínio com caracteres especiais em combinação com IE',
                                    'wp-pro-quiz'); ?>
                            </p>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php _e('Reparar banco de dados', 'wp-pro-quiz'); ?>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
                                <span><?php _e('Reparar banco de dados', 'wp-pro-quiz'); ?></span>
                            </legend>
                            <input type="submit" name="databaseFix" class="button-primary"
                                   value="<?php _e('Reparar banco de dados', 'wp-pro-quiz'); ?>">

                            <p class="description">
                                <?php _e('Nenhuma data será apagada. Somente tabelas WP-Pro-Quiz serão reparadas.',
                                    'wp-pro-quiz'); ?>
                            </p>
                        </fieldset>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <?php
    }

}
