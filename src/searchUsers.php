<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevMap</title>
    <link rel="stylesheet" href="static/css/styles.css">
    <link rel="icon" href="static/img/icon.ico">
</head>
<?php
session_start();
ini_set('display_errors', 0);
error_reporting(0);
include_once("db.php");
$conexion = conn();
$activo = $_SESSION['correo'];
if ($activo == "") {
    echo "<script>window.location.href = '../index.php';</script>";
}
$consulta = $conexion->query("SELECT nombre, apellido, imagen FROM usuario WHERE correo = '$activo'");
if ($consulta) {
    $fila = $consulta->fetch_assoc();
    $nombre = $fila['nombre'];
    $apellido = $fila['apellido'];
    $imagen = $fila['imagen'];
}
?>

<body>
    <header>
        <div>
            <a href="wall.php"><img src="static/img/logo.png" alt="ERROR"></a>
        </div>
        <div class="closeSesion">
            <?php
            echo "
            <img src=$imagen>
            <h3>$nombre $apellido</h3>
            ";
            ?>
            <a href="myAccount.php"><button>
                    <h3>MI CUENTA</h3>
                </button></a>
            <a href="../index.php"><button>
                    <h3>CERRAR SESIÓN</h3>
                </button></a>
        </div>
    </header>
    <main>
        <div class="formulario">
            <form action="searchUsers.php" method="POST">
                <div class="campo">
                    <h3>Buscar Usuario:</h3>
                    <input type="text" placeholder="Correo o nombre del usuario" name="correo">
                </div>
                <button type="submit">
                    <h3>Buscar</h3>
                </button>
            </form>
            <?php
            $correo = $_POST["correo"];
            $sql = "SELECT nombre, apellido, imagen, correo FROM usuario WHERE correo = '0'"; 
            if (strstr($correo, "@") != false) {
                $sql = "SELECT nombre, apellido, imagen, correo FROM usuario WHERE correo = '$correo'";
            } else if ($correo != "") {
                $sql = "SELECT nombre, apellido, imagen, correo FROM usuario WHERE nombre LIKE '%$correo%' OR apellido LIKE '%$correo%' ORDER BY nombre";
            }
              
            $consulta = $conexion->query($sql);
            $resultado = $consulta->num_rows;
            if ($resultado >= 1) {
                while ($fila = $consulta->fetch_assoc()) {
                    $nombre = $fila['nombre'];
                    $apellido = $fila['apellido'];
                    $imagen = $fila['imagen'];
                    $correo = $fila['correo'];
                    echo "
                    <div class='usuario'>
                        <h1>$nombre $apellido</h1>
                        <h3>$correo</h3>
                        <img src='$imagen'>
                        <br>
                        <a href='account.php?correo=" . $correo . "'><button>VER MÁS</button></a>
                    </div>

                    ";
                }
            } else {
                echo "<br>No se ha encontrado ningún usuario.";
            }
            ?>
        </div>
    </main>
    <footer>
        <div>
            <h4>Developed by: Alejandro Amador Ruiz & Juan José Jaramillo</h4>
        </div>
    </footer>
</body>

</html>