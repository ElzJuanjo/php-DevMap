<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevMap</title>
    <link rel="stylesheet" href="static/css/styles.css">
    <link rel="icon" href="static/img/icon.ico">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
</head>
<?php
session_start();
$_SESSION['correo'] = "";
?>

<body>
    <header>
        <div>
            <a href="index.php"><img src="static/img/logo.png" alt="ERROR"></a>
        </div>
        <div>
            <a href="register1.php"><button>
                    <h3>REGISTRARSE</h3>
                </button></a>
        </div>
    </header>
    <main>
        <div class="formulario">
            <h1>INICAR SESIÓN</h1>
            <form>
                <div class="campo">
                    <h3>Correo Electronico:</h3>
                    <input type="email" placeholder="Correo Electronico" id="correo" required>
                </div>
                <div class="campo">
                    <h3>Contraseña:</h3>
                    <input type="password" placeholder="Contraseña" id="contrasena" required>
                </div>
                <button id = "botonLogin">
                    <h3>Iniciar</h3>
                </button>
            </form>
        </div>
    </main>
    <footer>
        <div>
            <h4>Developed by: Alejandro Amador Ruiz & Juan José Jaramillo</h4>
        </div>
    </footer>
</body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./static/js/Login.js"></script>

</html>