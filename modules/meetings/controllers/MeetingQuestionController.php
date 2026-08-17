<?php

namespace app\modules\meetings\controllers;

use app\modules\meetings\forms\CreateMeetingQuestionForm;
use app\modules\meetings\models\MeetingQuestion;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MeetingQuestionController extends Controller
{
    public function actionIndex() {}
    /**
     * Создание нового постановочного вопроса
     */
    public function actionCreate(int $id)
    {
        $formModel = new CreateMeetingQuestionForm();

        $post = Yii::$app->request->post();

        if ($formModel->load($post)) {
            $formModel->meeting_id = $id;
            $formModel->user_id = 1; // Yii::$app->user->id
            $formModel->scenario =  $post['scenario'];

            if ($formModel->validate()) {
                $service = Yii::$app->getModule('meetings')->get('createAndSubmitForModerationService');
                $question = $service->run($formModel);
                return $this->redirect(['view', 'id' => $question->id]);
            }
        }
        return $this->render('create', ['formModel' => $formModel]);
    }

    /**
     * Модерация постановочного вопроса
     */
    public function actionModeration() {}

    /**
     * Редактирование постановочного вопроса
     */
    public function actionUpdate(int $id) {}
    /**
     * Просмотр постановочного вопроса
     */
    public function actionView(int $id)
    {
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
