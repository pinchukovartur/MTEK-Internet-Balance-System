<?php
// Страница обновления пароля
require_once '/../dao/connection.php';
require_once '/../dao/functions.php';

if (isset($_POST['update_pass'])) {
    $err = array();
    $room = get_rooms_by_number($conn, $_POST['room']);
    //проверяем есть ли такая комната
    if ($room != null) {
        //проверяем новый пароль с паролем из базы
        if ($room->pass != md5(md5($_POST['old_password']))) {
            $err[] = "Неправильный пароль <br>";
        }
    }
    else {
        $err[] = "Такой комнаты нет в базе <br>";
    }
    if (count($err) == 0) {
        update_password($conn, $_POST['room'], md5(md5(trim($_POST['new_password']))));
        setcookie("ip", "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie("room", "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
        header("Location: /../login.php");
    }
    else {
        foreach ($err AS $error) {
            print $error;
        }
    }
}
