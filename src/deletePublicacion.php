<?php
session_start();
include_once("db.php");
$conexion = conn();

$id = $_POST['id'];
$conexion->query("SET FOREIGN_KEY_CHECKS=0");
$conexion->query("DELETE FROM publicacion WHERE id_publicacion = '$id'");
$conexion->query("SET FOREIGN_KEY_CHECKS=1");
$response = array(
    "status" => "accept"
);

header('Content-Type: application/json');
echo json_encode($response);
exit;