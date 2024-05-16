<?php

namespace api\modules\v1\product\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\product\models\Product;
use common\models\form\ProductForm;
use Yii;
use yii\db\Exception;

class SiteController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $modelForm = new ProductForm();
        $modelForm->load(Yii::$app->request->post(), '');
        if ($modelForm->validate()) {
            $product = new Product();
            $product->setAttributes($modelForm->attributes, false);
            if ($product->validate()) {
                if ($product->save()) {
                    $statusCode = ApiConstant::SC_OK;
                    $data = $product;
                    $error = null;
                    $message = 'Create product success';
                } else {
                    $statusCode = ApiConstant::SC_EXCEPTION;
                    $data = null;
                    $error = 'There was an error during the adding process';
                    $message = 'Create product failed';
                }
            } else {
                $statusCode = ApiConstant::SC_BAD_REQUEST;
                $data = null;
                $error = $product->errors;
                $message = 'Create product failed';
            }
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = $modelForm->errors;
            $message = 'Create product failed';
        }
        return ResultHelper::build($statusCode, $data, $error, $message);
    }
}