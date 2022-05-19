<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\models\StatusTask;
use app\models\Company;

$status = ['0' => 'Любой'];
$company = ['0' => 'Любой'];
$status += ArrayHelper::map(StatusTask::find()->All(), 'id', 'name');
$company += ArrayHelper::map(Company::find()->All(), 'id', 'name');

?>

<div class="content">
    <div class="header-els">
        <div class="header-item header-item-1">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row-form">
                <?= $form->field($model, 'dateBegin')->widget(DatePicker::className(), [
                    'dateFormat' => 'yyyy-MM-dd',
                ]) ?>
                <?= $form->field($model, 'company')
                    ->dropDownList($company) ?>
            </div>
            <div class="row-form">
                <?= $form->field($model, 'dateEnd')->widget(DatePicker::className(), [
                    'dateFormat' => 'yyyy-MM-dd',
                ]) ?>
                <?= $form->field($model, 'status')
                    ->dropDownList($status) ?>
            </div>
            <div class="row-form">
                <?= $form->field($model, 'generatePdf')->checkbox() ?>
                <?= Html::submitButton('Фильтр', ['class' => 'btn btn-success btn-filter', 'name' => 'filter-button']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
        <div class="header-item header-item-2">
            <div class="total-for-payment">
                <h3 class="itog">Итог</h3>
                <span class="help-text">(при значении фильтра статуса "любой", считаем по статусу "выполнено")</span>
                <div class="total-time total-item">
                    <label>Время:</label>
                    <div class="time-for-work">
                        <?php echo round($total['allWorkTime']/60,2); ?> ч. (<?php echo $total['allWorkTime']; ?> мин.)
                    </div>
                </div>
                <div class="total-sum total-item">
                    <label>Сумма:</label>
                    <div class="all-price"><?php echo $total['allPrice']; ?> р.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-mass">
        <?php $form = ActiveForm::begin(); ?>
        <div class="filter-mass-item">
            <?= $form->field($modelMassEvent, 'arrTasks')->textInput()->label(Yii::t('app', 'Выбранные id')); ?>
        </div>
        <div class="filter-mass-item">
            <?= $form->field($modelMassEvent, 'statusTask')
                ->dropDownList(ArrayHelper::map(StatusTask::find()->All(), 'id', 'name'))->label(Yii::t('app', 'Статус')); ?>
        </div>
        <div class="filter-mass-item">
            <?= Html::submitButton('Применить', ['class' => 'btn btn-success btn-filter-mass', 'name' => 'update-button']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
    <table class="table table-striped tasks-list">
        <thead class="thead-dark">
        <tr>
            <th>Выбор</th>
            <th>Дата создания</th>
            <th>Компания</th>
            <th>Проект</th>
            <th>Название</th>
            <th>Ставка</th>
            <th>Сумма (р.)</th>
            <th>Время (мин.)</th>
            <th>Статус</th>
            <th>Дата сдачи</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($tasks as $taskKey => $taskValue) { ?>
            <tr>
                <td><input type="checkbox" name="check-task" class="check-task" value="<?php echo $taskValue->id; ?>"></td>
                <td><?php echo $taskValue->created_at; ?></td>
                <td><?php echo $taskValue->companyName; ?></td>
                <td><?php echo $taskValue->project; ?></td>
                <td>
                    <a href ="<?php echo $taskValue->link; ?>" target="_blank"><?php echo $taskValue->title; ?></a>
                </td>
                <td><?php echo $taskValue->pay_per_hour; ?></td>
                <td width="150px">
                    Текущая: <?php echo round($taskValue->pay_per_hour*($taskValue->work_time/60),0); ?><br/>
                    Итог: <?php echo $taskValue->price; ?>
                </td>
                <td><?php echo $taskValue->work_time; ?></td>
                <td><?php echo $taskValue->statusName; ?></td>
                <td><?php echo $taskValue->completed_at; ?></td>
                <td><a href="/task/view/<?php echo $taskValue->id; ?>"><i class="fa fa-eye"></i></a> | <a href="/task/edit/<?php echo $taskValue->id; ?>"><i class="fa fa-edit"></i></a> | <a href="/task/delete/<?php echo $taskValue->id; ?>"><i class="fa fa-trash"></i></a></td>
            </tr>
        <?php }
        ?>
        </tbody>
    </table>
</div>

