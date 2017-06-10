<?
header("Content-Type: text/html; charset=utf-8;");
require_once 'src/reg.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Вход в систему</title>
    <link href="static/css/style.css" type="text/css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
          rel='stylesheet' type='text/css'>
</head>
<body>
    <div class="container mregister">
        <div id="login">
            <h1>Регистрация</h1>
            <form action="register.php" id="registerform" method="post"name="registerform">
                <p><label for="user_login">Номер комнаты<br>
                        <input class="input" id="login" name="login"size="32"  type="text" value=""></label></p>
                <p><label for="user_pass">Пароль<br>
                        <input class="input" id="password" name="password"size="32"   type="password" value=""></label></p>
                <p class="submit"><input class="button" id="submit" name= "submit" type="submit" value="Зарегистрироваться"></p>
                <p class="regtext">Уже зарегистрированы? <a href= "login.php">Введите имя пользователя</a>!</p>
            </form>
        </div>
    </div>

<?require_once 'static/includes/footer.html';?>