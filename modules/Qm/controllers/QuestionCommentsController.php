<?php

namespace app\modules\Qm\controllers;

use app\modules\Qm\forms\CommentForm;
use app\modules\Qm\forms\DeleteCommentForm;
use app\modules\Qm\forms\UpdateCommentForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class QuestionCommentsController extends Controller
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
    public function actionCreate(int $id)
    {
        $formModel = new CommentForm();
        $formModel->question_id = $id;

        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
            $userId = Yii::$app->user->id;
            if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canCreateCommentToQuestion($formModel->question_id, $userId)) {
                throw new \yii\web\ForbiddenHttpException('Доступ запрещен');
            }
            Yii::$app->getModule('Qm')->get('createCommentService')->run($formModel);
            Yii::$app->session->setFlash('success', 'Ответ добавлен');
            return $this->redirect(Yii::$app->request->referrer ?: ['meetings']);
        }
    }

    public function actionUpdate(int $id)
    {
        $formModel = new UpdateCommentForm();
        $formModel->comment_id = $id;
        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
            $userId = Yii::$app->user->id;
            if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canUpdateComment($formModel->question_id, $userId)) {
                throw new \yii\web\ForbiddenHttpException('Доступ запрещен');
            }
        }
        Yii::$app->getModule('Qm')->get('updateCommentService')->run($formModel);
        Yii::$app->session->setFlash('success', 'Изменения сохранены');
        return $this->redirect(Yii::$app->request->referrer ?: ['meetings']);
    }

    public function actionDelete()
    {
        $formModel = new DeleteCommentForm();
        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
            $userId = Yii::$app->user->id;
            if (!Yii::$app->getModule('Qm')->get('meetingQuestionAccessService')->canDeleteComment($formModel->comment_id, $userId)) {
                throw new \yii\web\ForbiddenHttpException('Доступ запрещен');
            }
            $question_id = Yii::$app->getModule('Qm')->get('deleteCommentService')->run($formModel->comment_id);
            Yii::$app->session->setFlash('success', 'Ответ удален');
            return $this->redirect(['meeting-question/view', 'id' => $question_id]);
        }
    }
}
