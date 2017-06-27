<?php
$serverName = "192.168.2.139";
$connectionInfo = array( "Database"=>"_Routers", "UID"=>"sa", "PWD"=>"1ldfNHB");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if(!$conn){
    die(print_r(sqlsrv_errors(),true));
    echo "Ошибка подключения к БД";
    exit();
}