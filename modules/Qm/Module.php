<?php

namespace app\modules\Qm;

use app\modules\Qm\services\CreateMeetingQuestionService;
use app\modules\Qm\services\MeetingQuestionAccessService;

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
    public $controllerNamespace = 'app\modules\Qm\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
