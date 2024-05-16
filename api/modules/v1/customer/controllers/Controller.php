<?php

namespace api\modules\v1\customer\controllers;

use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;

class Controller extends \yii\rest\Controller
{
    public function verbs(): array
    {
        return [
            'create' => ['POST'],
        ];
    }

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
            ]
        ];
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create'],
                    'roles' => ['administrator'],
                ],
            ],
        ];
        return $behaviors;
    }
}