<?php
$serverName = "192.168.2.139";
$connectionInfo = array( "Database"=>"_Routers", "UID"=>"root", "PWD"=>"root");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if(!$conn){
    die(print_r(sqlsrv_errors(),true));
    echo "Ошибка подключения к БД";
    exit();
}