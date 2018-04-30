<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'rest-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
    ],
    'components' => [
        'user' => [
            'identityClass' => 'app\models\User',
            'enableSession' => false,
            'enableAutoLogin' => true,
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'smser' => [
            'class' => 'daixianceng\smser\CloudSmser',
            'username' => 'rencaiguanjia',
            'password' => 'd1910d8281cee93c26fc159b69d35ecb',
            'fileMode' => false
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            //'cachePath' => '@runtime/cache2',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'showScriptName' => false,
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'weibo' => [
                    'class' => 'yujiandong\authclient\Weibo',
                    'clientId' => 'wb_key',
                    'clientSecret' => 'wb_secret',
                ],
                'qq' => [
                    'class' => 'yujiandong\authclient\Qq',
                    'clientId' => 'qq_appid',
                    'clientSecret' => 'qq_appkey',
                ],
                'weixin' => [
                    'class' => 'yujiandong\authclient\Weixin',
                    'clientId' => 'weixin_appid',
                    'clientSecret' => 'weixin_appkey',
                ],
            ],
        ]
    ],
    'params' => $params,
];
