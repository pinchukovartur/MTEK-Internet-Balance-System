<?
header("Content-Type: text/html; charset=utf-8;");
require_once 'src/log.php';
?>

    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Вход в систему</title>
        <link href="static/css/style.css" type="text/css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
              rel='stylesheet' type='text/css'>
    </head>
<body>

<div class="container mlogin">
    <div id="login">
        <h1>Вход</h1>
        <?
        foreach ($err AS $error) {
            print $error;
        }
        ?>
        <form action="" id="loginform" method="post" name="loginform">
            <p><label for="user_login">Номер комнаты<br>
                    <? $rooms = get_rooms($conn); ?>
                    <input class="input" type='text' id='rez' name="login"/>
                    <select class="select" id="login" size="1" onchange="document.getElementById('rez').value=value">
                        <?php foreach ($rooms as $room): ?>
                            <option value = "<?= iconv("cp1251","utf-8",$room["room"]) ?>">
                                <?= iconv("cp1251","utf-8",$room["room"]) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label></p>
            <p><label for="password">Пароль<br>
                    <input class="input" id="password" name="password" size="20"
                           type="password" value=""></label></p>
            Не прикреплять к IP(не безопасно) <input type="checkbox" name="not_attach_ip"><br>
            <p class="submit"><input class="button" name="submit" type="submit" value="Войти"></p>

        </form>
    </div>
</div>




<?php include 'static/includes/footer.html';
