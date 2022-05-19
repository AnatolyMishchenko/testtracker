<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\models\StatusTask;
use app\models\Company;

?>

<div class="content">
    <div class="task-form-content">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'title')->textInput() ?>
        <?= $form->field($model, 'body')->textarea(['rows' => 5, 'cols' => 5]) ?>
        <?= $form->field($model, 'created_at')->widget(DatePicker::className(), [
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>
        <?= $form->field($model, 'company')
            ->dropDownList(ArrayHelper::map(Company::find()->All(), 'id', 'name')
            ) ?>
        <?= $form->field($model, 'project')->textInput() ?>
        <?= $form->field($model, 'link')->textInput() ?>
        <?= $form->field($model, 'pay_per_hour')->textInput() ?>
        <?= $form->field($model, 'price')->textInput() ?>
        <?= $form->field($model, 'work_time')->textInput() ?>
        <?= $form->field($model, 'completed_at')->widget(DatePicker::className(), [
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>
        <?= $form->field($model, 'status')
            ->dropDownList(ArrayHelper::map(StatusTask::find()->All(), 'id', 'name')
            ) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
