<?php

if($_COOKIE['room']!="543") {
    if ($_COOKIE['room'] != $_GET['room']){
        header("Location: /../index.php");
    }
}
// Страница обновления пароля
require_once '/../dao/connection.php';
require_once '/../dao/functions.php';

if (isset($_POST['update_pass'])) {
    $err = array();
    $room = get_rooms_by_number($conn, $_POST['room']);
    //проверяем есть ли такая комната
    if ($room != null) {
        //проверяем новый пароль с паролем из базы
        if ($room->pass != base64_encode($_POST['old_password'])) {
            $err[] = "Неправильный пароль <br>";
        }
    }
    else {
        $err[] = "Такой комнаты нет в базе <br>";
    }
    if (count($err) == 0) {
        update_password($conn, $_POST['room'], base64_encode($_POST['new_password']));
        header("Location: /../admin.php");
    }
    else {
        foreach ($err AS $error) {
            print $error;
        }
    }
}
