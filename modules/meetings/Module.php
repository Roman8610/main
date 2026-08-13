<?php

namespace app\modules\meetings;

use app\modules\meetings\services\CreateMeetingQuestionService;
use app\modules\meetings\services\MeetingQuestionAccessService;

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
    public $controllerNamespace = 'app\modules\meetings\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
