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
            <a href="../index.php"><button>
                    <h3>CERRAR SESIÓN</h3>
                </button></a>
        </div>
    </header>
    <main>
        <div class="usuarioVista">
            <h1>MI CUENTA</h1>
            <?php
            $consulta = $conexion->query("SELECT * FROM usuario WHERE correo = '$activo'");
            $cantidadSeguidores = $conexion->query("SELECT COUNT(*) AS total FROM seguidor WHERE seguido = '$activo'");
            $seguidores = $cantidadSeguidores->fetch_assoc()['total'];
            $cantidadSeguidos = $conexion->query("SELECT COUNT(*) AS total FROM seguidor WHERE seguidor = '$activo'");
            $seguidos = $cantidadSeguidos->fetch_assoc()['total'];
            if ($consulta) {
                $fila = $consulta->fetch_assoc();
                $nombre = $fila['nombre'];
                $apellido = $fila['apellido'];
                $correo = $fila['correo'];
                $bio = $fila['bio'];
                $imagen = $fila['imagen'];
                $titulo = $fila['titulo'];
                $fecha = $fila['fecha_nacimiento'];
                $repositorio = $fila['repositorio'];
                $ubicacion = $fila['ubicacion'];

                $fechaNacimiento = new DateTime($fecha);
                $fechaActual = new DateTime();
                $diferencia = $fechaActual->diff($fechaNacimiento);
                $edad = $diferencia->y;

                echo "
                <div class='usuarioHeader'>
                    <img src='$imagen'>
                    <div class='itemInfo'>
                        <div class='edit'>
                            <h1>$nombre $apellido</h1>
                            <i class='fa-solid fa-pen-to-square' id='cambiarNombre'></i>
                        </div>
                        <div class='edit'>
                            <h3>$titulo</h3>
                            <i class='fa-solid fa-pen-to-square' id='cambiarTitulo'></i>
                        </div>
                        <div class='edit'>
                            <h4>$activo</h4>
                            <i class='fa-solid fa-pen-to-square' id='cambiarCorreo'></i>
                        </div>
                    </div>";
                if ($repositorio != "") {
                    echo "    
                    <div>
                        <br>
                        <br>
                        <div class='edit'>
                            <a href='$repositorio' target='_blank'>
                            <i class='fa-solid fa-folder fa-2xl' style='color: #4EBFD9;'></i>
                            <h3>Mi Repo</h3>
                            </a>
                            <i class='fa-solid fa-pen-to-square' id='cambiarRepo'></i>
                        </div>
                    </div>";
                }
                echo "
                </div>
                <div class='usuarioInfo'>
                    <div>
                        <a href='followers.php?followed=" . $correo . "'><h2>Seguidores: <h3>$seguidores</h3></h2></a>
                    </div>
                    <div>
                        <a href='following.php?following=" . $correo . "'><h2>Seguidos: <h3>$seguidos</h3></h2></a>
                    </div>
                </div>
                <div class='usuarioBio'>
                    <h2>Sobre mí</h2>
                    <div class='edit'>
                        <p>$bio</p>
                        <i class='fa-solid fa-pen-to-square' id='cambiarBio'></i>
                    </div>
                </div>
                <div class='usuarioInfo'>
                    <div class='itemInfo'>
                        <h2>Fecha de Nacimiento</h2>
                        <div class='edit'>
                            <h3>$fecha</h3>
                            <i class='fa-solid fa-pen-to-square' id='cambiarFecha'></i>
                        </div>
                        <h3>Edad: $edad</h3>
                    </div>
                    <div class='itemInfo'>
                        <h2>Ubicación</h2>
                        <div class='edit'>
                            <h3 id='ubicacion'>$ubicacion</h3>
                            <i class='fa-solid fa-pen-to-square' id=cambiarPais></i>
                        </div>
                        <img id='bandera' src='' width='50' alt='Bandera'>
                    </div>
                </div>
                <div>
                    <button id='cambiarImagen'>Cambiar Foto</button>
                    <button id='cambiarClave'>Cambiar Contrasena</button>";
                if ($repositorio == "") {
                    echo "<button id='cambiarRepo'>Agregar Repositorio</button>";
                }
                echo "
                    <button id='eliminarCuenta' class='red'>ELIMINAR CUENTA</button>
                </div>
                ";
            }
            ?>
        </div>
        <h1 class="titulo">MIS PUBLICACIONES</h1>
        <?php
        $sql = "SELECT p.id_publicacion, u.correo, u.nombre AS nombre,u.apellido AS apellido,p.fecha,p.descripcion,p.imagen AS pimagen,u.imagen AS uimagen,p.likes FROM publicacion p JOIN usuario u ON u.correo = correo_usuario WHERE correo_usuario = '$activo' ORDER BY fecha DESC";
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
                        <div>
                            <h4>$fecha</h4>
                            <i class='fa-solid fa-x fa-xl' style='color: #ff0000;' title='$id_publicacion' id='botonEliminarPublicacion'></i>
                        </div>
                        
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./static/js/CargarBandera.js"></script>
    <script src="./static/js/Api.js"></script>
    <script src="./static/js/Validaciones.js"></script>
    <script src="./static/js/Modificaciones.js"></script>
    <script src="./static/js/Likes.js"></script>
    <script src="./static/js/Eliminar.js"></script>
</body>

</html>