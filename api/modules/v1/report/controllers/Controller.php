<?php

namespace api\modules\v1\report\controllers;

use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;

class Controller extends \yii\rest\Controller
{
    public function verbs(): array
    {
        return [
            'index' => ['GET'],
            'create' => ['POST'],
            'search' => ['GET']
        ];
    }

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index'],
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'actions' => ['export'],
                    'roles' => ['@'],
                ],
            ]
        ];
        return $behaviors;
    }
}