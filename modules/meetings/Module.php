<?php

namespace app\modules\meetings;

/**
 * Модуль постановочных вопросов для совещаний.
 *
 * Основные сущности:
 * - Meeting — совещание
 * - MeetingQuestion — постановочный вопрос
 *
 * Жизненный цикл вопроса:
 * draft → pending → published
 *           ↓
 *        rejected
 *
 * Сценарии:
 * - create — создание черновика
 * - submit_for_review — отправка на модерацию
 *
 * Сервисы:
 * - CreateMeetingQuestionService — создание вопроса
 * - PublishQuestionService — публикация
 * - ReturnQuestionForReworkService — возврат на доработку
 *
 * @author Roman Drozdenko
 */
class Module extends \yii\base\Module
{
    // public $container = [
    //     'definitions' => [
    //         StatusTransitionServiceInterface::class => StatusTransitionService::class,
    //         PermissionServiceInterface::class      => PermissionService::class,

    //         \app\modules\meetings\services\ModerateQuestionService::class => [
    //             'statusService'   => StatusTransitionServiceInterface::class,
    //             'permissionService' => PermissionServiceInterface::class,
    //         ],
    //     ],
    // ];
    public $controllerNamespace = 'app\modules\meetings\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
