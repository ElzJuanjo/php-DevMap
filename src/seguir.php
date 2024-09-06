<?php
include_once("db.php");
$conexion = conn();
session_start();
$seguidor = $_SESSION['correo'];
$seguido = $_POST['seguido'];

$checkFollow = $conexion->query("SELECT * FROM seguidor WHERE seguido = '$seguido' and seguidor='$seguidor'")->num_rows;

if ($checkFollow == 1) {
    $conexion->query("SET FOREIGN_KEY_CHECKS=0");
    $conexion->query("DELETE FROM seguidor WHERE seguido = '$seguido' and seguidor='$seguidor'");
    $conexion->query("SET FOREIGN_KEY_CHECKS=1");
    $seguidores = $conexion->query("SELECT * FROM seguidor WHERE seguido = '$seguido'")->num_rows;
    $respuesta = array(
        'mensaje' => '<h3>Seguir</h3>',
        'clase' => 'seguir',
        'seguidores' => $seguidores
    );
} else {
    $conexion->query("INSERT INTO seguidor (seguido,seguidor) VALUES ('$seguido','$seguidor')");
    $seguidores = $conexion->query("SELECT * FROM seguidor WHERE seguido = '$seguido'")->num_rows;
    $respuesta = array(
        'mensaje' => '<h3>Seguido</h3>',
        'clase' => 'seguido',
        'seguidores' => $seguidores
    );
}
echo json_encode($respuesta);
exit;