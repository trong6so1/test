<?php

namespace api\modules\v1;


use yii\filters\Cors;

/**
 * Class Module
 * @package api\modules\v1
 */
class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        $this->modules = [
            'report' => [
                'class' => report\Module::class,
            ],
            'category' => [
                'class' => category\Module::class,
            ],
            'customer' => [
                'class' => customer\Module::class,
            ],
            'product' => [
                'class' => product\Module::class,
            ],
            'service' => [
                'class' => service\Module::class,
            ],
            'order' => [
                'class' => order\Module::class,
            ]
        ];
    }

    public function behaviors(): array
    {
        $behaviors = parent::behaviors(); // TODO: Change the autogenerated stub

        $behaviors['corsFilter'] = [
            'class' => Cors::class, // the new Cors class inherited from yii2's
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'accept', 'Authorization', 'G-ClientID', "UserIP"],
            ],
        ];
        return $behaviors;
    }

}