<?php
// Скрипт проверки
require_once '/../dao/connection.php';
require_once '/../dao/functions.php';
//проверяем есть вообще куки
if (isset($_COOKIE['room']) and isset($_COOKIE['hash'])){
    //получаем данные о комнате
    $userdata = get_rooms_by_number($conn, $_COOKIE['room']);
    //проверяем привязку к ip
    if ($_COOKIE['ip'] === 'not_attach_ip') {
        if (($userdata->hash !== $_COOKIE['hash'] or $userdata->room !== $_COOKIE['room'])
        ) {
            setcookie("ip", "", time() - 3600 * 24 * 30 * 12, "/");
            setcookie("room", "", time() - 3600 * 24 * 30 * 12, "/");
            setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
            header("Location: ../login.php");
        }
    }
    if ($_COOKIE['ip']!== null and $_COOKIE['ip'] !== 'not_attach_ip'){
        if (($userdata->hash !== $_COOKIE['hash'] or $userdata->room !== $_COOKIE['room']
                        or $userdata->user_ip !== $_COOKIE['ip'])
        ) {
            setcookie("ip", "", time() - 3600 * 24 * 30 * 12, "/");
            setcookie("room", "", time() - 3600 * 24 * 30 * 12, "/");
            setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
            header("Location: ../login.php");
        }
    }
}
else {
    //не включены куки
    header("Location: ../login.php");
}
