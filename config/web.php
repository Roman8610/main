<?php

use app\modules\Qm\services\CreateAndSubmitForModerationService;
use app\modules\Qm\services\CreateCommentService;
use app\modules\Qm\services\CreateDraftMeetingQuestionService;
use app\modules\Qm\services\DeleteCommentService;
use app\modules\Qm\services\DeleteQuestionService;
use app\modules\Qm\services\MeetingQuestionAccessService;
use app\modules\Qm\services\MeetingQuestionVisibilityFilterService;
use app\modules\Qm\services\OffPublishMeetingQuestionService;
use app\modules\Qm\services\SubmitForModerationService;
use app\modules\Qm\services\UpdateAndSubmitForModerationService;
use app\modules\Qm\services\UpdateDraftMeetingQuestionService;
use app\modules\Qm\services\PublishMeetingQuestionService;
use app\modules\Qm\services\RejectMeetingQuestionService;
use app\modules\Qm\services\UpdateCommentService;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'Qm' => [
            'class' => 'app\modules\Qm\Module',
            'components' => [
                'createDraftMeetingQuestionService' => [
                    'class' => CreateDraftMeetingQuestionService::class,
                ],
                'meetingQuestionAccessService' => [
                    'class' => MeetingQuestionAccessService::class,
                ],
                'createAndSubmitForModerationService' => [
                    'class' => CreateAndSubmitForModerationService::class,
                ],
                'submitForModerationService' => [
                    'class' => SubmitForModerationService::class,
                ],
                'meetingQuestionVisibilityFilterService' => [
                    'class' => MeetingQuestionVisibilityFilterService::class,
                ],
                'updateAndSubmitForModerationService' => [
                    'class' => UpdateAndSubmitForModerationService::class,
                ],
                'updateDraftMeetingQuestionService' => [
                    'class' => UpdateDraftMeetingQuestionService::class,
                ],
                'deleteQuestionService' => [
                    'class' => DeleteQuestionService::class,
                ],
                'publishMeetingQuestionService' => [
                    'class' => PublishMeetingQuestionService::class,
                ],
                'offPublishMeetingQuestionService' => [
                    'class' => OffPublishMeetingQuestionService::class,
                ],
                'rejectMeetingQuestionService' => [
                    'class' => RejectMeetingQuestionService::class,
                ],
                'createCommentService' => [
                    'class' => CreateCommentService::class,
                ],
                'deleteCommentService' => [
                    'class' => DeleteCommentService::class,
                ],
                'updateCommentService' =>[
                    'class' => UpdateCommentService::class,
                ],
            ]
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'cMRlg7FyfFtIlbp52R3XiZcsiMhrizkn',
        ],
        'icon' => [
            'class' => 'kartik\icons\Icon',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'Qm/meetings' => 'Qm/meetings/index',
            ],
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
