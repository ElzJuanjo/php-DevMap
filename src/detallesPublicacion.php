<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevMap</title>
    <link rel="stylesheet" href="static/css/styles.css">
    <link rel="icon" href="static/img/icon.ico">
    <script src="https://kit.fontawesome.com/478acdb782.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
</head>
<?php
session_start();
$id = intval($_GET['id']);
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
        <?php
        $sql = "SELECT p.id_publicacion, u.correo, u.nombre AS nombre,u.apellido AS apellido,p.fecha,p.descripcion,p.imagen AS pimagen,u.imagen AS uimagen,p.likes FROM publicacion p JOIN usuario u ON u.correo = correo_usuario WHERE id_publicacion = '$id'";
        $consulta = $conexion->query($sql);
        $cantidadComentarios = $conexion->query("SELECT COUNT(*) as total FROM comentario WHERE id_publicacion = '$id'");
        $comentarios = $conexion->query("SELECT c.id_comentario, c.comentario, u.correo, u.nombre, u.apellido, u.imagen, c.fecha FROM comentario c JOIN usuario u ON u.correo = c.correo_usuario WHERE c.id_publicacion = '$id' ORDER BY fecha DESC");
        $cantidadLikes = $conexion->query("SELECT COUNT(*) as total FROM likes WHERE id_publicacion = '$id'");
        $dioLike = $conexion->query("SELECT * FROM likes WHERE id_publicacion='$id' AND correo_usuario = '$activo'");
        if ($consulta) {
            $fila = $consulta->fetch_assoc();
            $cantidadComentarios = $cantidadComentarios->fetch_assoc()['total'];
            $cantidadLikes = $cantidadLikes->fetch_assoc()['total'];
            $autor = $fila['nombre'] . " " . $fila['apellido'];
            $fecha = $fila['fecha'];
            $correo = $fila['correo'];
            $descripcion = $fila['descripcion'];
            $imagenAutor = $fila['uimagen'];
            $imagenPublicacion = $fila['pimagen'];
            $likes = $fila['likes'];
            echo "
            <div class='publicacion'>
                <div class='headerPublicacion'>
                    <a href='account.php?correo=" . $correo . "'>
                        <div class='autorPublicacion'>
                            <img src='$imagenAutor'>
                            <div>
                                <h2>$autor</h2>
                                <h5>$correo</h5>
                            </div>
                        </div>
                    </a>
                    <h4>$fecha</h4>
                </div>
                <p>$descripcion</p>
                <img src='$imagenPublicacion'>
                <div class='detallesPublicacion'>";
            if ($dioLike->num_rows == 1) {
                echo "<i id='botonLike' class='fa-solid fa-heart fa-2xl' title='$id'> $cantidadLikes</i>";
            } else {
                echo "<i id='botonLike' class='fa-regular fa-heart fa-2xl' title='$id'> $cantidadLikes</i>";
            }

            echo "
                    <h3><i class='fa-solid fa-comments fa-2xl'> $cantidadComentarios</i></h3>
                </div>
                <div class='comentar'>
                <form id='formularioComentario' action=''>
                    <h2 class='titulo'>¿Quieres comentar algo?</h2>
                    <textarea id='comentario' name='comentario' class='comentarCajon' placeholder='Escribe aquí tu comentario' required></textarea>
                    <button id='comentar' title='$id' type='button'>Comentar</button>
                </form>
                </div>
                <br>
                <h2 class='titulo'>COMENTARIOS</h2>
                
            ";
            if ($comentarios->num_rows==0) {
                echo "
                <h3 style='text-align:center;'>Aún no hay ningún comentario.</h3>
                ";
            } else {
                while ($fila = $comentarios->fetch_assoc()) {
                    $correo = $fila['correo'];
                    $id_comentario = $fila['id_comentario'];
                    $autor = $fila['nombre'] . " " . $fila['apellido'];
                    $imagenAutor = $fila['imagen'];
                    $fecha = $fila['fecha'];
                    $comentario = $fila['comentario'];
                    echo "
                    <div class='comentario'>
                        <div class='headerComentario'>
                            <a href='account.php?correo=" . $correo . "'>
                                <div class='autorComentario'>
                                    <img src='$imagenAutor'>
                                    <div>
                                        <h3>$autor</h3>
                                    </div>
                                </div>
                            </a>
                            ";
                    if ($activo == $correo) {
                        echo "
                        <div>
                        <h3>$fecha</h3>
                        <i class='fa-solid fa-x' style='color: #ff0000;' title='$id_comentario' id='botonEliminarComentario'></i>
                        </div>
                        ";
                    } else {
                        echo "
                        <div>
                        <h3>$fecha</h3>
                        </div>
                        ";
                    }
                    echo "
                        </div>
                        <p>$comentario</p>
                    </div>
                    ";
                }
            }
        }
        echo "
        </div>
        ";
        ?>
    </main>
    <footer>
        <div>
            <h4>Developed by: Alejandro Amador Ruiz & Juan José Jaramillo</h4>
        </div>
    </footer>
    <script src="./static/js/Likes.js"></script>
    <script src="./static/js/Eliminar.js"></script>
    <script src="./static/js/Comentar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>