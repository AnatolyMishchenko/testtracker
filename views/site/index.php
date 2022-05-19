<?php

/** @var yii\web\View $this */

$this->title = 'Tracker';
?>
<div class="content">
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th>Дата создания</th>
            <th>Компания</th>
            <th>Проект</th>
            <th>Название</th>
            <th>Ставка</th>
            <th>Сумма (р.)</th>
            <th>Время (мин.)</th>
            <th>Статус</th>
            <th>Дата сдачи</th>
            <th>Обновить</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($tasks as $taskKey => $taskValue) { ?>
            <tr>
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
                <td><a href="/task/edit/<?php echo $taskValue->id; ?>">Обновить</a></td>
                <td><a href="/task/delete/<?php echo $taskValue->id; ?>">Удалить</a></td>
            </tr>
        <?php }
        ?>
        </tbody>
    </table>
</div>


