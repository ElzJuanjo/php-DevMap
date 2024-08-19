<?php
session_start();
include_once("db.php");
$conexion = conn();

$id = $_POST['id'];
$correo = $_SESSION['correo'];

$likes = $conexion->query("SELECT * FROM likes WHERE id_publicacion='$id' AND correo_usuario = '$correo'");
$activo = $likes->num_rows;

if ($activo == 1) {
    $conexion->query("DELETE FROM likes WHERE id_publicacion='$id' AND correo_usuario = '$correo'");
    $cantidadLikes = $conexion->query("SELECT COUNT(*) AS total FROM likes WHERE id_publicacion = '$id'");
    $likes = $cantidadLikes->fetch_assoc()['total'];
    $response = array(
        "Clase" => "fa-regular fa-heart fa-2xl",
        "Html" => ' ' . $likes
    );
} else {
    $conexion->query("INSERT INTO likes (correo_usuario,id_publicacion) VALUES ('$correo','$id')");
    $cantidadLikes = $conexion->query("SELECT COUNT(*) AS total FROM likes WHERE id_publicacion = '$id'");
    $likes = $cantidadLikes->fetch_assoc()['total'];
    $response = array(
        "Clase" => "fa-solid fa-heart fa-2xl",
        "Html" => ' ' . $likes
    );
}
header('Content-Type: application/json');
echo json_encode($response);
