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
include_once("db.php");
$conexion = conn();
$activo = $_SESSION['correo'];
if ($activo == "") {
    echo "<script>window.location.href = 'index.php';</script>";
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
            <a href="index.php"><button>
                    <h3>CERRAR SESIÓN</h3>
                </button></a>
        </div>
    </header>
    <main>
        <div class="formulario">
            <h1>PUBLICAR</h1>
            <form action="upload2.php" method="POST">
                <h3>Descripción:</h3>
                <textarea name="descripcion" placeholder="Escribe aquí lo que quieras publicar" required></textarea>
                <div class="campo">
                    <h3>Imagen (URL):</h3>
                    <input type="url" name="imagen" placeholder="URL">
                </div>
                <button type="submit">PUBLICAR</button>
            </form>
        </div>

    </main>
    <footer>
        <div>
            <h4>Developed by: Alejandro Amador Ruiz & Juan José Jaramillo</h4>
        </div>
    </footer>
</body>

</html>