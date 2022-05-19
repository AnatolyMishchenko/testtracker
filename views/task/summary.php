<?php ?>
<style>
    .table tr td, .table tr th {
        padding: 10px;
        border: 1px solid #000;
    }
    .table tr th {
        text-align: left;
    }
    h1 {
        text-align: center;
    }
</style>
<h1>Отчет</h1>
<h2>За период: <?php echo $filters['dateBegin']; ?> - <?php echo $filters['dateEnd']; ?></h2>
<h2>Итог: <?php echo round($total['allWorkTime']/60,2); ?> ч. (<?php echo $total['allWorkTime']; ?> мин.) - <?php echo $total['allPrice']; ?> р.</h2>
<br/>
<div class="content">
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th>Компания</th>
            <th>Проект</th>
            <th>Название</th>
            <th>Ставка (р.)</th>
            <th>Сумма (р.)</th>
            <th>Время (мин.)</th>
            <th>Статус</th>
            <th>Дата сдачи</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($tasks as $taskKey => $taskValue) { ?>
            <tr>
                <td><?php echo $taskValue->companyName; ?></td>
                <td><?php echo $taskValue->project; ?></td>
                <td>
                    <a href ="<?php echo $taskValue->link; ?>" target="_blank"><?php echo $taskValue->title; ?></a>
                </td>
                <td><?php echo $taskValue->pay_per_hour; ?></td>
                <td>
                    <?php echo $taskValue->price; ?>
                </td>
                <td><?php echo $taskValue->work_time; ?></td>
                <td><?php echo $taskValue->statusName; ?></td>
                <td><?php echo $taskValue->completed_at; ?></td>
            </tr>
        <?php }
        ?>
        </tbody>
    </table>
</div>
