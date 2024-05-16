<?php

namespace api\modules\v1\customer\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\customer\models\Customer;
use common\models\base\BaseCustomerGroup;
use common\models\form\CustomerForm;
use Yii;
use yii\db\Exception;

class SiteController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $modelForm = new CustomerForm();
        $modelForm->load(Yii::$app->request->post(), '');
        if ($modelForm->validate()) {
            $customer = new Customer();
            $customer->setAttributes($modelForm->attributes, false);
            if ($customer->validate()) {
                if ($customer->save()) {
                    if (!empty($customer->group_id)) {
                        $customerGroup = new BaseCustomerGroup();
                        $customerGroup->setAttributes([
                            'group_id' => $customer->group_id,
                            'customer_id' => $customer->id
                        ], false);
                        $customerGroup->save();
                    }
                    $statusCode = ApiConstant::SC_OK;
                    $data = $customer;
                    $error = null;
                    $message = 'Create customer success';
                } else {
                    $statusCode = ApiConstant::SC_EXCEPTION;
                    $data = null;
                    $error = 'There was an error during the adding process';
                    $message = 'Create customer failed';
                }
            } else {
                $statusCode = ApiConstant::SC_BAD_REQUEST;
                $data = null;
                $error = $customer->errors;
                $message = 'Create customer failed';
            }
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = $modelForm->errors;
            $message = 'Create customer failed';
        }
        return ResultHelper::build($data, $statusCode, $error, $message);
    }
}