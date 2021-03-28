<?php
/**
 * @var $this View
 * @var $provider ActiveDataProvider
 */

use backend\models\Apple;
use yii\data\ActiveDataProvider;
use yii\web\View;

$this->title = Yii::t('app', "Главная страница");
?>

<?php //$models = $provider->getModels() ?>

<div class="site-index">

    <?php
    $apple = new Apple('green');

    echo $apple->color; // green

//    $apple->eat(50); // Бросить исключение - Съесть нельзя, яблоко на дереве
    echo $apple->size; // 1 - decimal

    $apple->fallToGround(); // упасть на землю
    $apple->eat(25); // откусить четверть яблока
    echo $apple->size; // 0,75

    ?>

    <div class="body-content">


    </div>

</div>
