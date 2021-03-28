<?php
/**
 * @var $this View
 * @var $provider ActiveDataProvider
 */

use backend\enums\AppleStatusEnum;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = Yii::t('app', "Главная страница");
?>

<div class="site-index">

    <p>
        <?= Yii::t('app', "В этом списке можете увидеть, список не съеденных яблок. Используя кнопку \"сгенерировать\" можете сгенерировать n количество яблок.") ?>
    </p>

    <div class="">
        <?= Html::a(Yii::t('app', "Сгенерировать"), "javascript:void(0)", [
                'class' => "confirm-btn",
            'data-href' => Url::to(['apple/generate'])
        ]) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'color',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return AppleStatusEnum::label($model->status);
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date("Y/m/d H:i", $model->created_at);
                },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return date("Y/m/d H:i", $model->created_at);
                },
            ],
            'size',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', "Действия"),
                'headerOptions' => ['width' => '80'],
                'template' => '{fall}{eaten}{rot}',
                'buttons' => [
                    'fall' => function ($url) {
                        return Html::a('<span class="glyphicon glyphicon-tower"></span>', $url,
                            [
                                'title' => Yii::t('app', 'Упасть'),
                                'class' => 'px-2'
                            ]);
                    },
                    'eaten' => function ($url) {
                        return Html::a('<span class="glyphicon glyphicon-heart"></span>', $url,
                            [
                                'title' => Yii::t('app', 'Съесть'),
                            ]);
                    },
                    'rot' => function ($url) {
                        return Html::a('<span class="glyphicon glyphicon-ok-circle"></span>', $url,
                            [
                                'title' => Yii::t('app', 'Проверка на испорченность'),
                            ]);
                    }
                ],
                'urlCreator' => function ($action, $model) {
                    switch ($action) {
                        case 'fall':
                            return Url::to(['apple/drop', 'id' => $model->id]);
                        case 'eaten':
                            return Url::to(['apple/eat', 'id' => $model->id]);
                        case 'rot':
                            return Url::to(['apple/rot', 'id' => $model->id]);
                    }
                }
            ]
        ],
        'rowOptions' => function ($model) {
            return ['class' => 'alert-' . AppleStatusEnum::colorByStatus()[$model->status]];
        }
    ]); ?>

</div>
