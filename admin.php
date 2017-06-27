<?php
header("Content-Type: text/html; charset=utf-8;");
require_once 'src/check.php';
require_once 'dao/connection.php';
require_once 'dao/functions.php';

if ($_COOKIE['room'] != '543'){
    header("Location: /../index.php");
}
?>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Админка</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link type="text/css" rel="StyleSheet" href="http://bootstraptema.ru/plugins/2016/shieldui/style.css"/>
    <link rel="stylesheet" href="/static/css/tabs.css"/>
    <script src="http://bootstraptema.ru/plugins/jquery/jquery-1.11.3.min.js"></script>
    <script src="http://bootstraptema.ru/plugins/2016/shieldui/script.js"></script>
</head>
<body>

<a href="<?
print iconv("cp1251","utf-8","register.php");
?>">Зарегестрировать новую комнату
</a>

<table class="table">
    <thead>
    <tr>
        <th>№</th>
        <th>Комната</th>
        <th>Пароль</th>
        <th>IP</th>
    </tr>
    </thead>
    <tbody>
    <?
    $rooms = get_rooms($conn);
    ?>

    <?php foreach ($rooms as $room): ?>
        <tr>
            <td><?= $room["key_room"] ?></td>
            <td><?= iconv("cp1251","utf-8",$room["room"]) ?></td>
            <td><?= base64_decode($room["pass"]) ?></td>
            <td><?= $room["user_ip"] ?></td>
            <td><a href="
                  <?
                  print iconv("cp1251","utf-8","pass_update.php?room=".$room["room"]);
                  ?>">Сменить пароль
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<!--<%--Pincha--%>-->
</body>
</html>
