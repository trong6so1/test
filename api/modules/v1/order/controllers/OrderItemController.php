<?php

namespace api\modules\v1\order\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\order\models\OrderItem;
use api\modules\v1\order\models\search\OrderItemSearch;
use api\traits\ExportExcelTrait;
use common\models\form\OrderItemForm;
use Yii;
use yii\db\Exception;

class OrderItemController extends Controller
{
    use ExportExcelTrait;
    /**
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $modelForm = new OrderItemForm();
        $modelForm->load(Yii::$app->request->post(), '');
        if ($modelForm->validate()) {
            $order = new OrderItem();
            $order->setAttributes($modelForm->attributes, false);
            if ($order->validate()) {
                if ($order->save()) {
                    $statusCode = ApiConstant::SC_OK;
                    $data = $order;
                    $error = null;
                    $message = 'Create order item success';
                } else {
                    $statusCode = ApiConstant::SC_EXCEPTION;
                    $data = null;
                    $error = 'There was an error during the adding process';
                    $message = 'Create order item failed';
                }
            } else {
                $statusCode = ApiConstant::SC_BAD_REQUEST;
                $data = null;
                $error = $order->errors;
                $message = 'Create order item failed';
            }
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = $modelForm->errors;
            $message = 'Create order item failed';
        }
        return ResultHelper::build($data, $statusCode, $error, $message);
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function actionExport(): array
    {
        $data = (new OrderItemSearch())->search(Yii::$app->request->queryParams)->getModels();
        $fileName = 'export_order_item_' . date('YmdHis') . '.xlsx';
        $fileDir = Yii::getAlias('@app/export/');
        if (!is_dir($fileDir)) {
            mkdir($fileDir, 0777, true);
        }
        $filePath = $fileDir . $fileName;
        return $this->exportExcel($data, $filePath, $fileName);
    }
}