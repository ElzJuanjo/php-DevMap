<?php
include_once("db.php");
$conexion = conn();
session_start();
$correo = $_SESSION['correo'];
$descripcion = $_POST['descripcion'];
$imagen = $_POST['imagen'];
$sql = "INSERT INTO publicacion (correo_usuario,descripcion,imagen,likes) VALUES ('$correo','$descripcion','$imagen','0')";
$conexion->query($sql);
echo "<script>window.location.href = 'wall.php';</script>";
exit;
