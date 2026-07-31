<?php

namespace app\controllers;

use yii\web\Controller;

class IconsController extends Controller{
    public function actionIndex(){
        return $this->render('index');
    }
}