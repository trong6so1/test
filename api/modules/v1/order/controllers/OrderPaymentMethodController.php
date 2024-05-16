<?php

namespace api\modules\v1\order\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\order\models\OrderPaymentMethod;
use common\models\form\OrderPaymentMethodForm;
use Yii;
use yii\db\Exception;

class OrderPaymentMethodController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $modelForm = new OrderPaymentMethodForm();
        $modelForm->load(Yii::$app->request->post(), '');
        if ($modelForm->validate()) {
            $order = new OrderPaymentMethod();
            $order->setAttributes($modelForm->attributes, false);
            if ($order->validate()) {
                if ($order->save()) {
                    $statusCode = ApiConstant::SC_OK;
                    $data = $order;
                    $error = null;
                    $message = 'Create order payment method success';
                } else {
                    $statusCode = ApiConstant::SC_EXCEPTION;
                    $data = null;
                    $error = 'There was an error during the adding process';
                    $message = 'Create order payment method failed';
                }
            } else {
                $statusCode = ApiConstant::SC_BAD_REQUEST;
                $data = null;
                $error = $order->errors;
                $message = 'Create order payment method failed';
            }
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = $modelForm->errors;
            $message = 'Create order payment method failed';
        }
        return ResultHelper::build($data, $statusCode, $error, $message);
    }
}