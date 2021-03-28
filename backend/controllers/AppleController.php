<?php

namespace backend\controllers;

use backend\enums\AppleStatusEnum;
use backend\models\Apple;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\Url;

class AppleController extends BaseController
{

    public static $modelClass = Apple::class;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['drop', 'eat', 'rot', 'generate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ]);
    }

    public function actionIndex()
    {
        $provider = new ActiveDataProvider([
            'query' => Apple::find()->where([
                '<>', 'status', AppleStatusEnum::STATUS_EATEN
            ])
        ]);

        return $this->render('index', [
            'provider' => $provider
        ]);
    }

    public function actionDrop($id)
    {
        $apple = Apple::findOne([ 'id' => $id ]);

        if ($apple->status == AppleStatusEnum::STATUS_ROT) {
            Yii::$app->session->setFlash('warning', Yii::t('app', "Яблоко гнилое!"));
            return $this->redirect(Yii::$app->request->referrer);
        }

        if ($apple->status != AppleStatusEnum::STATUS_FALL) {
            $apple->status = AppleStatusEnum::STATUS_FALL;
            $apple->updated_at = time();
            if ($apple->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', "Операция прошла успешно!"));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        Yii::$app->session->setFlash('warning', Yii::t('app', "Яблоко упало и лежит на земле!"));
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionEat($id, $eat = 0)
    {
        $apple = Apple::findOne([ 'id' => $id ]);

        if ($apple->status == AppleStatusEnum::STATUS_HANGING) {
            Yii::$app->session->setFlash('warning', Yii::t('app', "Съесть нельзя, яблоко на дереве!"));
            return $this->redirect(Yii::$app->request->referrer);
        }

        if ($apple->status == AppleStatusEnum::STATUS_ROT) {
            Yii::$app->session->setFlash('warning', Yii::t('app', "Съесть нельзя, яблоко испорчено!"));
            return $this->redirect(Yii::$app->request->referrer);
        }

        if ($apple->size >= $eat) {

            if ($apple->size == $eat) {
                $apple->status = AppleStatusEnum::STATUS_EATEN;
            }

            $percent = rand(0, 100);
            $part = ($percent * $apple->size) / 100;
            $apple->size = round($apple->size - $part, 2);
            if ($apple->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', "Операция прошла успешно!"));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        Yii::$app->session->setFlash('danger', Yii::t('app', "Невозможно съесть, так как размер меньше!"));
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Проверка на испорченность
     */
    public function actionRot($id)
    {
        $apple = Apple::find()->where([
            'AND',
            ['id' => $id],
            ['>=', new Expression('NOW()'), new Expression('updated_at + 5*60*60')]
        ])->one();

        if ($apple) {
            if ($apple->status == AppleStatusEnum::STATUS_HANGING) {
                Yii::$app->session->setFlash('warning', Yii::t('app', "Испортиться не может, яблоко на дереве!"));
                return $this->redirect(Yii::$app->request->referrer);
            }

            $apple->status = AppleStatusEnum::STATUS_ROT;
            $apple->size = 0;
            if ($apple->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', "Операция прошла успешно!"));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        Yii::$app->session->setFlash('success', Yii::t('app', "Яблоко еще не испортилась!"));
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionGenerate()
    {
        if ($postData = Yii::$app->request->post()) {
            $appleCount = $postData['size'];

            for ($i = 0; $i < $appleCount; $i++) {

                $apple = new Apple();
                $apple->color = $apple->colors[array_rand($apple->colors)];
                $apple->status = rand(0,2);

                $start = time();
                $end = $start + 2592000; //3600*24*30

                $apple->created_at = mt_rand($start, $end);

                if ($apple->status == AppleStatusEnum::STATUS_FALL) {
                    $apple->updated_at = $apple->created_at;
                }

                $apple->save();
            }

            return $this->redirect(Url::to(['apple/list']));
        }

        return false;
    }
}