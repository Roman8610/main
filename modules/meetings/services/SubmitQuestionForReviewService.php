<?php
namespace app\modules\meetings\services;

use app\modules\meetings\services\interfaces\SubmitQuestionForReviewServiceInterface;

/**
 * Отправляет вопрос на модерацию
 *  - Проверяет текущий статус, он должен быть draft
 *  - Проверяет заполнение обязательных полей
 *  - Проверяет авторство, только автор может отправлять вопросы на модерацию
 *  - Устанавливает статус pending
 */
class SubmitQuestionForReviewService implements SubmitQuestionForReviewServiceInterface{
    
}