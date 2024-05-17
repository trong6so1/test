<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\search\OrderItemSearch;
use api\traits\ExportExcelTrait;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Yii;

class TrendingServiceController extends Controller
{
    use ExportExcelTrait;

    public function actionIndex(): array
    {
        $data = (new OrderItemSearch())->search(Yii::$app->request->queryParams);
        $statusCode = ApiConstant::SC_OK;
        $data = [
            'data' => $data,
        ];
        $error = null;
        $message = 'Report trending service income successfully';
        return ResultHelper::build($statusCode, $data, $error, $message);
    }

    /**
     * @throws Exception
     */
    public function actionExport(): array
    {
        $dataProvider = new OrderItemSearch();
        $fields = [
            "item_id",
            "quantity_order",
        ];
        $data = $dataProvider->search(Yii::$app->request->queryParams)->getModels();
        $fileName = 'export_report_trending_service_' . date('YmdHis') . '.xlsx';
        $fileDir = Yii::getAlias('@app/export/');
        if (!is_dir($fileDir)) {
            mkdir($fileDir, 0777, true);
        }
        $filePath = $fileDir . $fileName;
        return $this->exportExcel($data, $filePath, $fileName, $fields);
    }
}