<?php
header("Content-Type: text/html; charset=utf-8;");
require_once 'src/check.php';
require_once 'dao/connection.php';
require_once 'dao/functions.php';
?>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Комната № <? echo $_COOKIE['room'] ?> </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link type="text/css" rel="StyleSheet" href="http://bootstraptema.ru/plugins/2016/shieldui/style.css"/>
    <link rel="stylesheet" href="/static/css/tabs.css"/>
    <script src="http://bootstraptema.ru/plugins/jquery/jquery-1.11.3.min.js"></script>
    <script src="http://bootstraptema.ru/plugins/2016/shieldui/script.js"></script>
</head>
<body>
<div class="tabs">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1" title="Вкладка 1"><span class="glyphicon glyphicon-home"></span> Состояние счета</label>

    <input id="tab2" type="radio" name="tabs">
    <label for="tab2" title="Вкладка 2"><span class="glyphicon glyphicon-signal"></span> История пополнения</label>

    <input id="tab3" type="radio" name="tabs">
    <label for="tab3" title="Вкладка 3"><span class="glyphicon glyphicon-eye-open"></span> Истрория подключений</label>

    <section id="content-tab1">
        <h2>Комната № <? echo $_COOKIE['room'] ?></h2>
        <div class="panel panel-default">
            <div class="panel-body">
                <label>Текущий баланс:</label>
            </div>
            <div class="panel-footer">
                <? $balance = get_balance($conn, $_COOKIE['room'])->balance;
                if($balance== 0) echo 0;
                else print_r($balance)
                ?> бел. руб.
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <label>Закончится баланс через:</label>
            </div>
            <div class="panel-footer">
                <? echo $balance / 0.1 ?> дней до окончания обслуживания
                <div class="progress progress-striped active">
                    <div class="progress-bar" style="width: <? echo $balance / 0.1 * 100 / 30 ?>%;">
                        <span class="sr-only">Завершено 60%</span>
                    </div>
                </div>
                День предварительной оплаты -
                <?
                $date = new DateTime();
                $date->modify('+'.$balance / 0.1.' day');
                echo $date->format("d.m.y");
                ?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <label>Тикущий статус:</label>
            </div>
            <?
            $stat = iconv("cp1251","utf-8",get_stat($conn, $_COOKIE['room'])->stat);
            if(strcasecmp($stat,"Активен")==0)
                $style = "background: #47a447;";
            else $style = "background: #f58220;";
            ?>
            <div class="panel-footer">
                <label class="green_fon" style="<?echo $style?>">
                    <?print_r($stat);?>
                </label>
            </div>
        </div>

        <a href="<?
                    echo iconv("cp1251","utf-8","/pass_update.php?room=".$_COOKIE['room'])
                 ?>
                " class="button">Поменять пароль</a>

        <a href="/src/out.php" class="button" name="logout" type="submit">Выйти</a>

    </section>
    <section id="content-tab2">
        <h2>Комната № <? echo $_COOKIE['room'] ?></h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Сумма</th>
                <th>Дата Пополнения</th>
            </tr>
            </thead>
            <tbody>
            <? $connections_balance = get_balance_history($conn, $_COOKIE['room']); ?>
            <?php foreach ($connections_balance as $connect): ?>
                <tr>
                    <td><?= $connect["_money"] ?></td>
                    <td><?= $connect["data_popolnenia"]->format('d/m/Y'); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <section id="content-tab3">
        <h2>Комната № <? echo $_COOKIE['room'] ?></h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Статус</th>
                <th>Дата подключения</th>
            </tr>
            </thead>
            <tbody>
            <? $connections_history = get_connection_history($conn, $_COOKIE['room']); ?>
            <?php foreach ($connections_history as $connect): ?>
                <tr>
                    <td><?= iconv("cp1251","utf-8", $connect["_stat"]) ?></td>
                    <td><?= $connect["data_conrction"]->format('d/m/Y'); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
<!--<%--Pincha--%>-->
</body>
</html>