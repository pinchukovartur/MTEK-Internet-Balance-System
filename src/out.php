<?php
setcookie("ip", "", time() - 3600 * 24 * 30 * 12, "/");
setcookie("room", "", time() - 3600 * 24 * 30 * 12, "/");
setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
header("Location: /../login.php");
