<?php
namespace app\modules\meetings\services;

use app\modules\meetings\services\interfaces\CreateMeetingQuestionServiceInterface;

/**
 * Создание вопроса
 * Создает и заполняет модель из формы
 * Устанавливает автора, дату и время создания вопроса
 * Устанавливает статус draft
 * Запускает валидацию согласно установленному сценарию
 */
class CreateMeetingQuestionService implements CreateMeetingQuestionServiceInterface{} 