<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\search\OrderSearch;
use api\traits\ExportExcelTrait;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Yii;
use yii\base\InvalidConfigException;

class OrderController extends Controller
{
    use ExportExcelTrait;

    public function actionIndex(): array
    {
        $report = (new OrderSearch())->search(Yii::$app->request->queryParams);
        $statusCode = ApiConstant::STATUS_OK;
        $data = $report;
        $error = null;
        $message = "Report order successfully";
        return ResultHelper::build($statusCode, $data, $error, $message);
    }

    /**
     * @throws Exception
     */
    public function actionExport(): array
    {
        $dataProvider = new OrderSearch();
        $fields = $dataProvider->fields();
        $data = $dataProvider->search(Yii::$app->request->queryParams)->getModels();
        $fileName = 'export_report_order_' . date('YmdHis') . '.xlsx';
        $fileDir = Yii::getAlias('@app/export/');
        return $this->exportExcel($data, $fileDir, $fileName, $fields);
    }
}