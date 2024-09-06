<?php
include_once("db.php");
$conexion = conn();
session_start();
$correo = $_SESSION['correo'];
$comentario = $_POST['comentario'];
$id = $_POST['id_publicacion'];
$conexion->query("INSERT INTO comentario (correo_usuario,comentario,id_publicacion) VALUES ('$correo','$comentario','$id')");

exit;