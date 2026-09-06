<?php

namespace app\modules\meetings\controllers;

use app\modules\meetings\forms\MeetingQuestionForm;
use app\modules\meetings\models\CommentQuestions;
use app\modules\meetings\models\MeetingQuestion;
use app\modules\meetings\models\Subsidiary;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class MeetingQuestionController extends Controller
{

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex() {}
    /**
     * Создание нового постановочного вопроса
     */
    public function actionCreate(int $id)
    {
        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canCreate($id, $userId)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        $formModel = new MeetingQuestionForm();
        $post = Yii::$app->request->post();
        $subsidiary = Subsidiary::find()->select(['name'])->indexBy('id')->column();

        if ($formModel->load($post)) {
            $formModel->meeting_id = $id;
            $formModel->user_id = $userId;
            $formModel->scenario =  $post['scenario'];

            if ($formModel->validate()) {
                $service = Yii::$app->getModule('meetings')->get('createAndSubmitForModerationService');
                $question = $service->run($formModel);
                return $this->redirect(['view', 'id' => $question->id]);
            }
        }
        return $this->render('create', [
            'formModel' => $formModel,
            'subsidiary' => $subsidiary,
        ]);
    }

    /**
     * Редактирование постановочного вопроса
     */
    public function actionUpdate(int $id)
    {
        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canUpdate($id, $userId)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
        $formModel = new MeetingQuestionForm();
        $question = $this->findModel($id);

        // Заполнем модель , чтобы пользователь получил форму с данными.
        $formModel->loadFromQuestion($question);

        $post = Yii::$app->request->post();
        if ($formModel->load($post)) {
            $formModel->id = $id;
            $formModel->user_id = $userId;
            $formModel->scenario =  $post['scenario'];

            if ($formModel->validate()) {
                $service = Yii::$app->getModule('meetings')->get('updateAndSubmitForModerationService');
                $question = $service->run($question, $formModel);
                return $this->redirect(['view', 'id' => $question->id]);
            }
        }

        $subsidiary = Subsidiary::find()->select(['name'])->indexBy('id')->column();

        return $this->render('update', [
            'formModel' => $formModel,
            'subsidiary' => $subsidiary,
        ]);
    }

    /**
     * Модерация постановочного вопроса
     */
    public function actionModeration(int $id)
    {
        $question = $this->findModel($id);

        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canMakeModeration($id, 1)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
        return $this->render('moderation', [
            'question' => $question,
        ]);
    }

    /**
     * Просмотр постановочного вопроса
     */
    public function actionView(int $id)
    {
        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canView($id, $userId)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        $question = $this->findModel($id);

        return $this->render('view', [
            'question' => $question,
        ]);
    }
    /**
     * Удаление постановочного вопроса
     */
    public function actionDelete(int $id)
    {
        // ПРОБЛЕМА !!!
        // Удаление происходит по GET - параметру !
        // dump(Yii::$app->request->get());
        // die;

        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canDelete($id, 1)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        $question = $this->findModel($id);

        if (CommentQuestions::find()->where(['question_id' => $id])->count() != 0) {
            Yii::$app->session->setFlash('error', 'Перед удалением постановочного вопроса необходимо удалить все ответы');
            return $this->redirect(Yii::$app->request->referrer ?: ['meeting-question/view', 'id' => $question->id]);
        }

        if ($question->delete()) {
            Yii::$app->session->setFlash('success', 'Постановочный вопрос удален');
        }
        return $this->redirect(['meetings/view', 'id' => $question->meeting->id]);
    }
    /**
     * Возвращает вопрос на доработку
     */
    public function actionRework(int $id) {}

    private function findModel(int $id): MeetingQuestion
    {
        if (($model = MeetingQuestion::findOne($id)) !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('Постановочный вопрос не найден');
    }
}
