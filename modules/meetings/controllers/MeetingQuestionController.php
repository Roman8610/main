<?php

namespace app\modules\meetings\controllers;

use app\modules\meetings\forms\MeetingQuestionForm;
use app\modules\meetings\forms\OffPublishedMeetingQuestionForm;
use app\modules\meetings\forms\PublishedMeetingQuestionModerationForm;
use app\modules\meetings\forms\RejectMeetingQuestionModerationForm;
use app\modules\meetings\models\CommentQuestions;
use app\modules\meetings\models\MeetingQuestion;
use app\modules\meetings\models\Subsidiary;
use Yii;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
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
                        'publish' => ['POST'],
                        'reject' => ['POST'],
                        'off' => ['POST'],
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
     * Отвечает за отображение страницы модерации постановочного вопроса
     */
    public function actionModeration(int $id)
    {
        $question = $this->findModel($id);
        $userId = Yii::$app->user->id;

        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canMakeModeration($id, $userId)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        $formModelPublish = new PublishedMeetingQuestionModerationForm();
        $formModelReject = new RejectMeetingQuestionModerationForm();

        return $this->render('moderation', [
            'formModelPublish' => $formModelPublish,
            'formModelReject' => $formModelReject,
            'question' => $question,
        ]);
    }

    /**
     * Отвечает за публикацию постановочного вопроса
     */
    public function actionPublish()
    {
        $formModel = new PublishedMeetingQuestionModerationForm();

        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
            $userId = Yii::$app->user->id;
            // проверить доступ
            if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canMakeModeration($formModel->question_id, $userId)) {
                throw new ForbiddenHttpException('Доступ запрещен');
            }
            // вызвать сервис публикации
            $service = Yii::$app->getModule('meetings')->get('publishMeetingQuestionService');
            $service->run($formModel);

            // redirect

        }
    }

    /**
     * Отвечает за снятие с публикации постановочного вопроса
     */
    public function actionOff()
    {
        $formModel = new OffPublishedMeetingQuestionForm();

        if ($formModel->load(Yii::$app->request->post(), '') && $formModel->validate()) {
            $userId = Yii::$app->user->id;
            // проверить доступ
            if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canMakeOff($formModel->question_id, $userId)) {
                throw new ForbiddenHttpException('Доступ запрещен');
            }
            // вызвать сервис публикации
            $service = Yii::$app->getModule('meetings')->get('offPublishMeetingQuestionService');
            $service->run($formModel);
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['meetings']);
    }

    /**
     * Отвечает за отклонение постановочного вопроса
     */
    public function actionReject()
    {
        echo "Отклонение вопроса";
        die();
        // проверить доступ
        // загрузить RejectMeetingQuestionModerationForm
        // провалидировать
        // вызвать сервис отклонения
        // redirect
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
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        if ($id === null || filter_var($id, FILTER_VALIDATE_INT) === false || (int) $id < 1) {
            throw new BadRequestHttpException('Некорректный идентификатор вопроса');
        }

        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canDelete($id, $userId)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        if (CommentQuestions::find()->where(['question_id' => $id])->count() != 0) {
            Yii::$app->session->setFlash('error', 'Перед удалением постановочного вопроса необходимо удалить все ответы');
            return $this->redirect(Yii::$app->request->referrer ?: ['meeting-question/view', 'id' => $id]);
        }

        if (Yii::$app->getModule('meetings')->get('deleteQuestionService')->run($id)) {
            Yii::$app->session->setFlash('success', 'Постановочный вопрос удален');
            return $this->redirect(['/meetings/meetings']);
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['meeting-question/view', 'id' => $id]);
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
