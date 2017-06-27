<?php
// Страница регестрации
require_once '/../dao/connection.php';
require_once '/../dao/functions.php';

if (isset($_POST['submit'])) {
    $err = array();
    // проверям логин
    if (!preg_match("/^[0-9]+$/", $_POST['login'])) {
        $err[] = "Логин может состоять только из цифр";
    }
    if (strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30) {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";

    }
    // проверяем, не сущестует ли комната с таким номером
    $room = get_rooms_by_number($conn, $_POST['login']);
    if ($room != null) {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }
    // Если нет ошибок, то добавляем в БД нового пользователя
    if (count($err) == 0) {
        registration($conn, $_POST['login'], base64_encode($_POST['password']));
        header("Location: ../admin.php");
    } else {
        foreach ($err AS $error) {
            print $error;
        }
    }
}
