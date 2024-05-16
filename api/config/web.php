<?php

use yii\web\Response;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
$config = [
    'defaultRoute' => 'site/index',
    'modules' => [
        'v1' => [
            'class' => api\modules\v1\Module::class,
        ],
    ],
    'bootstrap' => ['log', 'queue'],
    'components' => [
        'user' => [
            'identityClass' => 'api\base\Identity'
        ],
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => true,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'Asia/Ho_Chi_Minh',
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'default',
            'mutex' => \yii\mutex\MysqlMutex::class,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error', 'warning'],
                    'logFile' => '@runtime/logs/queue.log',
                ],
            ],
        ],
        'response' => [
            'class' => Response::class,
            'format' => Response::FORMAT_JSON,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'rbac_auth_item',
            'itemChildTable' => "rbac_auth_item_child",
            'assignmentTable' => "rbac_auth_assignment",
            'ruleTable' => "rbac_auth_rule",
        ],
    ],
    'params' => $params
];

return $config;
