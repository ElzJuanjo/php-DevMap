<?php
include_once("db.php");
$conexion = conn();
$idComentario = $_POST['id'];

$conexion->query("DELETE FROM comentario WHERE id_comentario='$idComentario'");

exit;