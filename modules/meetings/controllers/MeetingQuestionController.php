<?php

namespace app\modules\meetings\controllers;

use app\modules\meetings\models\MeetingQuestion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CRUD Постановочных вопросов
 */
class MeetingQuestionController extends Controller
{
    public function actionIndex() {}
    /**
     * Создание нового постановочного вопроса
     */
    public function actionCreate() {}
    /**
     * Редактирование постановочного вопроса
     */
    public function actionUpdate(int $id) {}
    /**
     * Просмотр постановочного вопроса
     */
    public function actionView(int $id) {
        $question = MeetingQuestion::findOne($id);

        if ($question === null) {
            throw new NotFoundHttpException('Постановочный вопрос не найден');
        }
        return $this->render('view', [
            'question' => $question,
        ]);
    } 
    /**
     * Удаление постановочного вопроса
     */
    public function actionDelete(int $id) {}
    /**
     * Возвращает вопрос на доработку
     */
    public function actionRework(int $id) {}
}
