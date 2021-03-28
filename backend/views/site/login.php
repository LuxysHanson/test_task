<?php
/**
 * @var $model LoginForm
 * @var $this View
 * @var $form ActiveForm
 */

use common\models\LoginForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

$this->title = Yii::t('app', "Авторизация");
?>

<div class="site-login">

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <h5><?= Yii::t('app', "Введите пароль администратора") ?></h5>

    <?= $form->field($model, 'password')->passwordInput(['autofous' => true]) ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', "Войти"), [
            'class' => 'btn btn-primary btn-block',
            'name' => 'login-button'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>