<?php

namespace app\modules\Qm\controllers;

use app\modules\Qm\forms\CommentForm;
use app\modules\Qm\forms\DeleteCommentForm;
use app\modules\Qm\forms\DeleteMeetingQuestionForm;
use app\modules\Qm\forms\MeetingQuestionForm;
use app\modules\Qm\forms\OffPublishedMeetingQuestionForm;
use app\modules\Qm\forms\PublishedMeetingQuestionModerationForm;
use app\modules\Qm\forms\RejectMeetingQuestionModerationForm;
use app\modules\Qm\forms\UpdateCommentForm;
use app\modules\Qm\models\CommentQuestions;
use app\modules\Qm\models\Departments;
use app\modules\Qm\models\MeetingQuestion;
use app\modules\Qm\models\Subsidiary;
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
        if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canCreate($id, $userId)) {
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
                $service = Yii::$app->getModule('Qm')->get('createAndSubmitForModerationService');
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
        if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canUpdate($id, $userId)) {
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
                $service = Yii::$app->getModule('Qm')->get('updateAndSubmitForModerationService');
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
        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canMakeModeration($id, $userId)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        $question = $this->findModel($id);

        $formModelPublish = new PublishedMeetingQuestionModerationForm();
        $formModelReject = new RejectMeetingQuestionModerationForm();

        $formModelPublish->setAttributes($question->attributes);
        $formModelPublish->departments = $question->getDepartments()
            ->select(['departments_id'])
            ->column();

        $formModelReject->setAttributes($question->attributes);

        $departments = Departments::find()->select(['name'])->indexBy('id')->column();
        return $this->render('moderation', [
            'formModelPublish' => $formModelPublish,
            'formModelReject' => $formModelReject,
            'question' => $question,
            'departments' => $departments,
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
            if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canMakeModeration($formModel->question_id, $userId)) {
                throw new ForbiddenHttpException('Доступ запрещен');
            }
            // вызвать сервис публикации
            $service = Yii::$app->getModule('Qm')->get('publishMeetingQuestionService');
            $service->run($formModel);

            return $this->redirect(['meeting-question/view', 'id' => $formModel->question_id]);
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
            if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canMakeOff($formModel->question_id, $userId)) {
                throw new ForbiddenHttpException('Доступ запрещен');
            }
            // вызвать сервис публикации
            $service = Yii::$app->getModule('Qm')->get('offPublishMeetingQuestionService');
            $service->run($formModel);
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['meetings']);
    }

    /**
     * Отвечает за отклонение постановочного вопроса
     */
    public function actionReject()
    {
        $formModel = new RejectMeetingQuestionModerationForm();

        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
            $userId = Yii::$app->user->id;
            if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canMakeModeration($formModel->question_id, $userId)) {
                throw new ForbiddenHttpException('Доступ запрещен');
            }
            Yii::$app->getModule('Qm')->get('rejectMeetingQuestionService')->run($formModel);
            Yii::$app->session->setFlash('success', 'Постановочный вопрос отклонен');

            return $this->redirect(['meeting-question/view', 'id' => $formModel->question_id]);
        }
    }

    /**
     * Просмотр постановочного вопроса
     */
    public function actionView(int $id)
    {
        $userId = Yii::$app->user->id;
        if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canView($id, $userId)) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        $formModelCommentCreate = new CommentForm();
        $formModelCommentUpdate = new UpdateCommentForm();
        $formModelCommentDelete = new DeleteCommentForm();

        $question = $this->findModel($id);

        return $this->render('view', [
            'question' => $question,
            'formModelCommentCreate' => $formModelCommentCreate,
            'formModelCommentUpdate' => $formModelCommentUpdate,
            'formModelCommentDelete' => $formModelCommentDelete,
        ]);
    }
    /**
     * Удаление постановочного вопроса
     */
    public function actionDelete()
    {
        $formModel = new DeleteMeetingQuestionForm();

        if ($formModel->load(Yii::$app->request->post(), '') && $formModel->validate()) {
            $userId = Yii::$app->user->id;
            if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canDelete($formModel->question_id, $userId)) {
                throw new ForbiddenHttpException('Доступ запрещен');
            }

            if (CommentQuestions::find()->where(['question_id' => $formModel->question_id])->count() != 0) {
                Yii::$app->session->setFlash('error', 'Перед удалением постановочного вопроса необходимо удалить все ответы');
                return $this->redirect(Yii::$app->request->referrer ?: ['meeting-question/view', 'id' => $formModel->question_id]);
            }

            Yii::$app->getModule('Qm')->get('deleteQuestionService')->run($formModel->question_id);
            Yii::$app->session->setFlash('success', 'Постановочный вопрос удален');
            return $this->redirect(['/Qm/meetings']);
        }
    }

    private function findModel(int $id): MeetingQuestion
    {
        if (($model = MeetingQuestion::findOne($id)) !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('Постановочный вопрос не найден');
    }
}
