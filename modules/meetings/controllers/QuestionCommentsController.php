<?php

namespace app\modules\meetings\controllers;

use app\modules\meetings\forms\CommentForm;
use app\modules\meetings\forms\DeleteCommentForm;
use app\modules\meetings\models\CommentQuestions;
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
            if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canCreateCommentToQuestion($formModel->question_id, $userId)) {
                throw new \yii\web\ForbiddenHttpException('Доступ запрещен');
            }
            Yii::$app->getModule('meetings')->get('createCommentService')->run($formModel);
            Yii::$app->session->setFlash('success', 'Ответ добавлен');
            return $this->redirect(Yii::$app->request->referrer ?: ['meetings']);
        }
    }

    public function actionUpdate(int $id) {}

    public function actionDelete()
    {
        $formModel = new DeleteCommentForm();
        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
            $userId = Yii::$app->user->id;
            if (!Yii::$app->getModule('meetings')->get('meetingQuestionAccessService')->canDeleteComment($formModel->comment_id, $userId)) {
                throw new \yii\web\ForbiddenHttpException('Доступ запрещен');
            }
            $question_id = Yii::$app->getModule('meetings')->get('deleteCommentService')->run($formModel->comment_id);
            Yii::$app->session->setFlash('success', 'Ответ удален');
            return $this->redirect(['meeting-question/view', 'id' => $question_id]);
        }
    }
}
