<?php

namespace backend\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;

class BaseController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /*public function delete($id)
    {
        $model = static::$modelClass::findOne([ 'id' => (int) $id ]);
    }*/
}