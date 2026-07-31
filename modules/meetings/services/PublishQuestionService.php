<?php
namespace app\modules\meetings\services;

use app\modules\meetings\services\interfaces\PublishQuestionServiceInterface;

/**
 * Публикация постановочного вопроса
 * - Загружаем вопрос по ID, либо выбрасываем NotFoundException
 * - Проверяем права пользователя на публикацию
 * - Если пришли данные из формы , то загружаем их в модель
 * - Проверка допустимости изменения статуса происходит в поведении модели при валидации данных
 * - Устанавливаем статус published 
 * - Сохраняем все в транзакции
 */
class PublishQuestionService implements PublishQuestionServiceInterface{}
