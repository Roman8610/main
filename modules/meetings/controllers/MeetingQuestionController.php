<?php

namespace app\modules\meetings\controllers;

use app\modules\meetings\models\Departments;
use app\modules\meetings\models\DepQuestions;
use app\modules\meetings\models\Directions;
use app\modules\meetings\models\DirQuestions;
use app\modules\meetings\models\MeetingQuestion;
use Yii;
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
    public function actionCreate(int $id)
    {
        $modelForm = new MeetingQuestion();

        if ($modelForm->load(\Yii::$app->request->post())) {
            $modelForm->meeting_id = $id;
            $modelForm->status = 0;
            $modelForm->subsidiary_id = 1;
            $modelForm->sender_subsidiary_id = 1;


            if ($modelForm->save()) {

                if (!empty($modelForm->departments)) {
                    foreach ($modelForm->departments as $department) {
                        $departmentsModel = new Departments();
                        $departmentsModel->name = $department;

                        if ($departmentsModel->save()) {
                            $depQuestModel = new DepQuestions();
                            $depQuestModel->dep_id = $departmentsModel->id;
                            $depQuestModel->quest_id = $modelForm->id;
                            if ($depQuestModel->save()) {
                            }
                        }
                    }
                }

                if (!empty($modelForm->directions)) {
                    foreach ($modelForm->directions as $direction) {
                        $directionsModel = new Directions();
                        $directionsModel->name = $direction;

                        if ($directionsModel->save()) {
                            $dirQuestModel = new DirQuestions();
                            $dirQuestModel->dir_id = $directionsModel->id;
                            $dirQuestModel->quest_id = $modelForm->id;
                            if ($dirQuestModel->save()) {
                            }
                        }
                    }
                }

                Yii::$app->session->setFlash('success', 'Постановочный вопрос успешно добавлен');
                return $this->redirect(['view', 'id' => $modelForm->id]);
            }
        }

        return $this->render('create', [
            'modelForm' => $modelForm,
        ]);
    }

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
