<?php
// Страница авторизации
require_once '/../dao/connection.php';
require_once '/../dao/functions.php';
# Функция для генерации случайной строки
function generateCode($length = 6)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $clen)];
    }
    return $code;
}

$err = array();

if (isset($_POST['submit'])) {

    # Вытаскиваем из БД запись, у которой логин равняеться введенному
    $room = get_rooms_by_number($conn, $_POST['login']);

    #Проверяем не спруфинг ли это
    $date_now = new DateTime();
    //создаем дату на 5 минут меньше, чтобы сравнить с датой в бд
    $date_now->modify('-' . '1' . ' hour'); // делаем текущую дату
    $date_now->modify('-' . '5' . ' min');
    //если человек заходил не раньше 5 минут то делаем флаг равный 0
    if ($room->authorization_date <= $date_now) {
        update_number_of_attempts($conn, $room->room, 0);
    }
    //если количество попыток меньше 5 или ip поменялся проверяем дальше
    if ($room->number_of_attempts < 5 || $room->user_ip != $_SERVER['REMOTE_ADDR']) {
        //добавляем новую дату авторизациии если пароль совпал
        $date_now->modify('+' . '5' . ' min');
        update_authorization_date($conn, $room->room, $date_now);
        //добавляем флаг
        update_number_of_attempts($conn, $room->room, $room->number_of_attempts + 1);
        //добавляем новый ip
        update_ip($conn, $room->room, $_SERVER['REMOTE_ADDR']);

        //echo base64_encode($_POST['password']);


        # Сравниваем пароли
        if ($room->pass === base64_encode($_POST['password'])) {
            # Генерируем случайное число и шифруем его
            $hash = md5(generateCode(10));

            if (!@$_POST['not_attach_ip']) {
                # Если пользователя выбрал привязку к IP
                # Переводим IP в строку
                $user_ip = $_SERVER['REMOTE_ADDR'];
                setcookie("ip", $user_ip, time() + 60 * 60 * 24 * 30);
            } else {
                $user_ip = "no attach ip";
                setcookie("ip", "not_attach_ip", time() + 60 * 60 * 24 * 30);
            }

            # Записываем в БД новый хеш авторизации и IP
            set_hash_and_ip($hash, $user_ip, $room->room, $conn);

            # Ставим куки
            setcookie("room", $room->room, time() + 60 * 60 * 24 * 30);
            setcookie("hash", $hash, time() + 60 * 60 * 24 * 30);
            # Переадресовываем браузер на страницу проверки нашего скрипта
            header("Location: ../index.php");

        } else {
            $err[] = "Вы ввели неправильный логин/пароль";
        }
    } else {
        $err[] = "Вход ограничен из-за большого количества попыток входа";
    }
}
