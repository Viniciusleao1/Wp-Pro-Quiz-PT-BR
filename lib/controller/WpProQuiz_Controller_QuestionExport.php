<?php

class WpProQuiz_Controller_QuestionExport extends WpProQuiz_Controller_Controller
{
    public function route()
    {
        $this->handleExport();
    }

    protected function handleExport()
    {
        if (!current_user_can('wpProQuiz_export')) {
            wp_die(__('Você não tem permissões suficientes para acessar esta página.'));
        }

        $exportIds = $this->prepareExportIds($_POST['exportIds']);

        if (empty($exportIds) || empty($_POST['exportType'])) {
            wp_die(__('Argumentos inválidos'));
        }

        $questionExport = new WpProQuiz_Helper_QuestionExport();
        $exporter = $questionExport->factory($exportIds, $_POST['exportType']);

        if ($exporter === null) {
            wp_die(__('Exportador não suportado'));
        }

        $response = $exporter->response();

        if($response instanceof WP_Error) {
            wp_die($response);
        } else if ($response !== null) {
            echo $response;
        }

        exit;
    }

    /**
     * @param array $ids
     * @return array
     */
    protected function prepareExportIds($ids)
    {
        return array_map('intval', array_filter($ids, 'is_numeric'));
    }
}
