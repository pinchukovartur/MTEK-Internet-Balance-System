<?
header("Content-Type: text/html; charset=utf-8;");
?>
<?require_once 'src/new_pass.php';?>
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
        <h1>Смена пароля</h1>
        <form action="pass_update.php" id="registerform" method="post">
            <p>
                <label for="old_pass">Старый пароль<br>
                    <input class="input" id="password" name="old_password"size="32"   type="password" value="">
                </label>
            </p>
            <p>
                <label for="new_pass">Новый пароль<br>
                    <input class="input" id="password" name="new_password"size="32"   type="password" value="">
                </label>
                <input type="hidden" name="room" value="<?echo $_GET['room']?>"
            </p>
            <p class="submit"><input class="button" id="submit" name= "update_pass" type="submit" value="Обновить"></p>
        </form>
    </div>
</div>

<?require_once 'static/includes/footer.html';?>