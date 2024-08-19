<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevMap</title>
    <link rel="stylesheet" href="static/css/styles.css">
    <link rel="icon" href="static/img/icon.ico">
    <script src="https://kit.fontawesome.com/478acdb782.js" crossorigin="anonymous"></script>
</head>
<?php
session_start();
include_once("db.php");
ini_set('display_errors', 0);
error_reporting(0);
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
        <div class="panel">
            <div>
                <?php
                echo "
                <h3>Hola $nombre, ¿Qué quieres hacer hoy?</h3>
                ";
                ?>
            </div>
            <a href="searchUsers.php"><button>Buscar Usuario</button></a>
            <a href="upload.php"><button>Publicar Algo</button></a>
            <div class="panelFiltro">
                <form method="POST">
                    <h3>Ordenar por:</h3>
                    <select name="filtro" id="" class="filtrador">
                        <option value="fecha" selected >Más Recientes</option>
                        <option value="likes">Con Más Likes</option>
                        <option value="comentarios">Con Más Comentarios</option>
                    </select>
                    <button type="Submit">Filtrar</button>
                </form>
            </div>
        </div>

        <?php
        $filtro = "fecha";
        try {
            $filtro = $_POST['filtro'];
        } catch (e) {

        }
        if ($filtro == 'fecha') {
            echo "<h1 class='titulo'>PUBLICACIONES MÁS RECIENTES</h1>";
            $sql = "SELECT p.id_publicacion, u.correo, u.nombre AS nombre,u.apellido AS apellido,p.fecha,p.descripcion,p.imagen AS pimagen,u.imagen AS uimagen,p.likes FROM publicacion p JOIN usuario u ON u.correo = correo_usuario ORDER BY fecha DESC";
        } else if ($filtro == 'likes') {
            echo "<h1 class='titulo'>PUBLICACIONES CON MÁS LIKES</h1>";
            $sql = "SELECT p.id_publicacion, u.correo, u.nombre AS nombre, u.apellido AS apellido, p.fecha, p.descripcion, p.imagen AS pimagen, u.imagen AS uimagen, COUNT(l.id_like) AS likes FROM publicacion p JOIN usuario u ON u.correo = p.correo_usuario LEFT JOIN likes l ON p.id_publicacion = l.id_publicacion GROUP BY p.id_publicacion, u.correo, u.nombre, u.apellido, p.fecha, p.descripcion, p.imagen, u.imagen ORDER BY likes DESC";
        } else if ($filtro == 'comentarios') {
            echo "<h1 class='titulo'>PUBLICACIONES CON MÁS COMENTARIOS</h1>";
            $sql = "SELECT p.id_publicacion, u.correo, u.nombre AS nombre, u.apellido AS apellido, p.fecha, p.descripcion, p.imagen AS pimagen, u.imagen AS uimagen, COUNT(c.id_comentario) AS comentarios FROM publicacion p JOIN usuario u ON u.correo = p.correo_usuario LEFT JOIN comentario c ON p.id_publicacion = c.id_publicacion GROUP BY p.id_publicacion, u.correo, u.nombre, u.apellido, p.fecha, p.descripcion, p.imagen, u.imagen ORDER BY comentarios DESC";
        } else {
            echo "<h1 class='titulo'>PUBLICACIONES MÁS RECIENTES</h1>";
            $sql = "SELECT p.id_publicacion, u.correo, u.nombre AS nombre,u.apellido AS apellido,p.fecha,p.descripcion,p.imagen AS pimagen,u.imagen AS uimagen,p.likes FROM publicacion p JOIN usuario u ON u.correo = correo_usuario ORDER BY fecha DESC";
        }
        $consulta = $conexion->query($sql);
        if ($consulta) {
            while ($fila = $consulta->fetch_assoc()) {
                $id_publicacion = $fila['id_publicacion'];
                $cantidadLikes = $conexion->query("SELECT COUNT(*) AS total FROM likes WHERE id_publicacion = '$id_publicacion'");
                $likes = $cantidadLikes->fetch_assoc()['total'];
                $dioLike = $conexion->query("SELECT * FROM likes WHERE id_publicacion='$id_publicacion' AND correo_usuario = '$activo'");
                $cantidadComentarios = $conexion->query("SELECT COUNT(*) AS total FROM comentario WHERE id_publicacion='$id_publicacion'");
                $comentarios = $cantidadComentarios->fetch_assoc()['total'];
                $autor = $fila['nombre'] . " " . $fila['apellido'];
                $fecha = $fila['fecha'];
                $correo = $fila['correo'];
                $descripcion = $fila['descripcion'];
                $imagenAutor = $fila['uimagen'];
                $imagenPublicacion = $fila['pimagen'];
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
                    echo "<i id='botonLike' class='fa-solid fa-heart fa-2xl' title='$id_publicacion'> $likes</i>";
                } else {
                    echo "<i id='botonLike' class='fa-regular fa-heart fa-2xl' title='$id_publicacion'> $likes</i>";
                }
                echo "
                        <a href='detallesPublicacion.php?id=" . $id_publicacion . "'><h3><i class='fa-solid fa-comments fa-2xl'> $comentarios</i></h3></a>
                    </div>
                </div>  
                ";
            }
        }
        ?>

    </main>
    <footer>
        <div>
            <h4>Developed by: Alejandro Amador Ruiz & Juan José Jaramillo</h4>
        </div>
    </footer>
    <script src="./static/js/Likes.js"></script>
</body>

</html>