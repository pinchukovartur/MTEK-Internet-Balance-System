<?php
// Страница авторизации
require_once '/../dao/connection.php';
require_once '/../dao/functions.php';
# Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

if(isset($_POST['submit']))
{
    # Вытаскиваем из БД запись, у которой логин равняеться введенному
    $room = get_rooms_by_number($conn,($_POST['login']));
    # Сравниваем пароли
    if($room->pass === md5(md5($_POST['password'])))
    {
        # Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));



        if(!@$_POST['not_attach_ip'])
        {
            # Если пользователя выбрал привязку к IP
            # Переводим IP в строку
            $user_ip = $_SERVER['REMOTE_ADDR'];
            setcookie("ip", $user_ip, time()+60*60*24*30);
        }
        else{
            $user_ip = "no attach ip";
            setcookie("ip", "not_attach_ip", time()+60*60*24*30);
        }

        # Записываем в БД новый хеш авторизации и IP
        set_hash_and_ip($hash,$user_ip,$room->room,$conn);

        # Ставим куки
        setcookie("room", $room->room, time()+60*60*24*30);
        setcookie("hash", $hash, time()+60*60*24*30);
        # Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: ../index.php");
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
}
