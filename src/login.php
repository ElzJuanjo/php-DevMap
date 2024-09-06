<?php
session_start();
include_once("db.php");
$conexion = conn();
$contrasena = $_POST["contrasena"];
$correo = $_POST["correo"];

$consulta = $conexion->query("SELECT * FROM usuario WHERE correo = '$correo' AND contrasena = '$contrasena'");
$resultado = $consulta->num_rows;

if ($resultado == 1) {
    $_SESSION['correo'] = $correo;
    $respuesta = array(
        'status' => 'logged'
    );
} else {
    $respuesta = array(
        'status' => 'notLogged'
    );
}

echo json_encode($respuesta);

exit;
