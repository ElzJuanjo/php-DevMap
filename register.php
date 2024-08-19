<?php
session_start();
include_once("db.php");
$conexion = conn();

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$correo = $_POST["correo"];
$contrasena = $_POST["contrasena1"];
$fecha = $_POST["fecha"];

$pais = $_POST["pais"];
$departamento = $_POST["departamento"];
$ciudad = $_POST["ciudad"];
$ubicacion = $ciudad . '-' . $departamento . '-' . $pais;

$sql = "INSERT INTO usuario (nombre,apellido,correo,contrasena,fecha_nacimiento,ubicacion,repositorio,bio,imagen,titulo) 
VALUES('$nombre','$apellido','$correo','$contrasena','$fecha','$ubicacion','','Este usuario no ha puesto nada en su bio.','https://t4.ftcdn.net/jpg/00/64/67/63/360_F_64676383_LdbmhiNM6Ypzb3FM4PPuFP9rHe7ri8Ju.jpg','Usuario de DevMap')";
$conexion->query($sql);

$_SESSION['correo'] = $correo;
echo "<script>window.location.href = 'wall.php';</script>";

exit;
