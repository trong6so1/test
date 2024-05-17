<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\search\StaffIncomeSearch;
use api\traits\ExportExcelTrait;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Yii;

class StaffIncomeController extends Controller
{
    use ExportExcelTrait;

    public function actionIndex(): array
    {
        $data = (new StaffIncomeSearch())->search(Yii::$app->request->queryParams);
        $statusCode = ApiConstant::SC_OK;
        $data = [
            'data' => $data,
        ];
        $error = null;
        $message = 'Report staff income successfully';
        return ResultHelper::build($statusCode, $data, $error, $message);
    }

    /**
     * @throws Exception
     */
    public function actionExport(): array
    {
        $dataProvider = new StaffIncomeSearch();
        $fields = [
            "staff_id",
            "income_after_discount",
        ];
        $data = $dataProvider->search(Yii::$app->request->queryParams)->getModels();
        $fileName = 'export_report_staff_income_' . date('YmdHis') . '.xlsx';
        $fileDir = Yii::getAlias('@app/export/');
        return $this->exportExcel($data, $fileDir, $fileName, $fields);
    }
}