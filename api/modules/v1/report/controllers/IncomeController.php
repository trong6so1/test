<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\search\OrderPaymentMethodSearch;
use api\traits\ExportExcelTrait;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Yii;

class IncomeController extends Controller
{
    use ExportExcelTrait;

    public function actionIndex(): array
    {
        $report = (new OrderPaymentMethodSearch())->search(Yii::$app->request->queryParams);
        $statusCode = ApiConstant::STATUS_OK;
        $data = $report;
        $error = null;
        $message = "Report income successfully";
        return ResultHelper::build($statusCode, $data, $error, $message);
    }

    /**
     * @throws Exception
     */
    public function actionExport(): array
    {
        $dataProvider = new OrderPaymentMethodSearch();
        $fields = $dataProvider->fields();
        $data = $dataProvider->search(Yii::$app->request->queryParams)->getModels();
        $fileName = 'export_report_income_' . date('YmdHis') . '.xlsx';
        $fileDir = Yii::getAlias('@app/export/');
        return $this->exportExcel($data, $fileDir, $fileName, $fields);
    }
}