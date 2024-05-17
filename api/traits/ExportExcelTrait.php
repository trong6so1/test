<?php

namespace api\traits;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\helpers\BaseInflector;

trait ExportExcelTrait
{
    /**
     * @throws Exception
     */
    public function exportExcel($data, $fileDir, $fileName, $fields = null, $header = null): array
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        if (!empty($data)) {
            $fields = $fields ?? array_keys($data[0]->attributes);
            if (empty($header)) {
                foreach ($fields as $field) {
                    $header[] = BaseInflector::camel2words($field);
                }
            }
            $row = 1;
            $sheet->fromArray($header, null, 'A' . $row);
            foreach ($data as $model) {
                $row++;
                $rowData = [];
                foreach ($fields as $field) {
                    $rowData[] = $model->$field;
                }
                $sheet->fromArray($rowData, null, 'A' . $row);
            }
        }
        if (!is_dir($fileDir)) {
            mkdir($fileDir, 0777, true);
        }
        $filePath = $fileDir . $fileName;
        $write = new Xlsx($spreadsheet);
        $write->save($filePath);
        $statusCode = ApiConstant::SC_OK;
        $data = [
            'filePath' =>$filePath,
            'fileName' => $fileName,
        ];
        $error = null;
        $message = "Export successfully";
        return ResultHelper::build($statusCode, $data, $error, $message);
    }
}