<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">
    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?> <!--вставка ['options' => ['enctype' => 'multipart/form-data']] в параметры формы для отпавки картинок-->

    
    <div class="form-group field-category-parent_id"> <!--копируем из консоли вместо верхнего поля-->
        <label class="control-label" for="product-category_id">Родительская категори</label>
        <select id="product-category_id" class="form-control" name="Product[category_id]">
        <option value="0">Самостоятельная категория</option>
            <?= \app\components\MenuWidget::widget(['tpl' => 'select_product', 'model' => $model])?> <!--добавляем озешщті через виджет + отключаем кеширование в components/MenuWidget.php-->
        </select>
    </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'hit')->checkbox([ '0', '1', ])?>

    <?= $form->field($model, 'new')->checkbox([ '0', '1', ])?>

    <?= $form->field($model, 'sale')->checkbox([ '0', '1', ])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
