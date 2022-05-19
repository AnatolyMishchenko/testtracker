<?php

/* @var $this yii\web\View */

?>

<table class="table table-striped">
    <thead class="thead-dark">
    <tr>
        <th>Поле</th>
        <th>Значение</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($task as $taskKey => $taskValue) { ?>
            <tr>
                <td>Заголовок:</td>
                <td><?php echo $taskValue->title; ?></td>
            </tr>
            <tr>
                <td>Описание:</td>
                <td><?php echo $taskValue->body; ?></td>
            </tr>
            <tr>
                <td>Дата создания:</td>
                <td><?php echo $taskValue->created_at; ?></td>
            </tr>
            <tr>
                <td>Компания:</td>
                <td><?php echo $taskValue->companyName; ?></td>
            </tr>
            <tr>
                <td>Проект:</td>
                <td><?php echo $taskValue->project; ?></td>
            </tr>
            <tr>
                <td>Ставка за час:</td>
                <td><?php echo $taskValue->pay_per_hour; ?></td>
            </tr>
            <tr>
                <td>Сумма:</td>
                <td>Текущая: <?php echo round($taskValue->pay_per_hour*($taskValue->work_time/60),0); ?><br/>
                    Итог: <?php echo $taskValue->price; ?>
                </td>
            </tr>
            <tr>
                <td>Статус:</td>
                <td><?php echo $taskValue->statusName; ?></td>
            </tr>
            <tr>
                <td>Дата выполнения:</td>
                <td><?php echo $taskValue->completed_at; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>