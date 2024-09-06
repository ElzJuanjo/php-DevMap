<?php
function conn()
{
    $hostname = "localhost";
    $usuariodb = "root";
    $password = "";
    $dbname = "dev";
    $conectar = mysqli_connect($hostname, $usuariodb, $password, $dbname);
    return $conectar;
}
