<?php
session_start();
include_once("db.php");
$conexion = conn();
$correo = $_SESSION['correo'];

$campo = $_POST['campo'];
$modificacion = $_POST['modificacion'];

$sql = "UPDATE usuario SET $campo = '$modificacion' WHERE correo = '$correo'";

if ($campo == "obtenerClave") {
    header('Content-Type: application/json');

    $sqlClave = "SELECT contrasena FROM usuario WHERE correo = '$correo'";
    $consulta = $conexion->query($sqlClave);
    $resultado = $consulta->fetch_assoc();
    $resultado = $resultado['contrasena'];

    $response = array(
        "message" => $resultado
    );

    echo json_encode($response);
} else if ($campo == "correo") {
    header('Content-Type: application/json');

    $sqlCorreo = "SELECT correo FROM usuario WHERE correo = '$modificacion'";
    $consulta = $conexion->query($sqlCorreo);
    $resultado = mysqli_num_rows($consulta);

    if ($resultado == 0) {
        $conexion->query("SET FOREIGN_KEY_CHECKS=0");
        $conexion->query($sql);
        $conexion->query("UPDATE comentario SET correo_usuario = '$modificacion' WHERE correo_usuario = '$correo'");
        $conexion->query("UPDATE likes SET correo_usuario = '$modificacion' WHERE correo_usuario = '$correo'");
        $conexion->query("UPDATE publicacion SET correo_usuario = '$modificacion' WHERE correo_usuario = '$correo'");
        $conexion->query("UPDATE resena SET correo_autor = '$modificacion' WHERE correo_autor = '$correo'");
        $conexion->query("UPDATE resena SET correo_resenado = '$modificacion' WHERE correo_resenado = '$correo'");
        $conexion->query("UPDATE seguidor SET seguido = '$modificacion' WHERE seguido = '$correo'");
        $conexion->query("UPDATE seguidor SET seguidor = '$modificacion' WHERE seguidor = '$correo'");
        $conexion->query("SET FOREIGN_KEY_CHECKS=1");

        $_SESSION['correo'] = $modificacion;

        $response = array(
            "status" => "accept"
        );
    } else {
        $response = array(
            "status" => "denied"
        );
    }
    echo json_encode($response);
} else if ($campo == "eliminar") {
    $conexion->query("SET FOREIGN_KEY_CHECKS=0");
    $conexion->query("DELETE FROM usuario WHERE correo = '$correo'");
    $conexion->query("DELETE FROM comentario WHERE correo_usuario = '$correo'");
    $conexion->query("DELETE FROM likes WHERE correo_usuario = '$correo'");
    $conexion->query("DELETE FROM publicacion WHERE correo_usuario = '$correo'");
    $conexion->query("DELETE FROM resena WHERE correo_autor = '$correo'");
    $conexion->query("DELETE FROM resena WHERE correo_resenado = '$correo'");
    $conexion->query("DELETE FROM seguidor WHERE seguido = '$correo'");
    $conexion->query("DELETE FROM seguidor WHERE seguidor = '$correo'");
    $conexion->query("SET FOREIGN_KEY_CHECKS=1");
} else {
    $conexion->query($sql);
}

exit;
