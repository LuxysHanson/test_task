<?php

namespace backend\controllers;

class AppleController extends BaseController
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}