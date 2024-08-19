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
            <a href="index.php"><button>
                    <h3>INICIAR SESIÓN</h3>
                </button></a>
        </div>
    </header>
    <main>
        <div class="formulario">
            <h1>REGISTRARSE</h1>
            <form id="registro" action="register.php" method="POST">
                <div class="campo">
                    <h3>Nombres:</h3>
                    <input type="text" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="campo">
                    <h3>Apellidos:</h3>
                    <input type="text" name="apellido" placeholder="Apellido" required>
                </div>
                <div class="campo">
                    <h3>Correo Electronico:</h3>
                    <input type="email" name="correo" placeholder="Correo Electronico" required>
                </div>
                <div class="campo">
                    <h3>Contraseña:</h3>
                    <input type="password" id="contrasena1" name="contrasena1" placeholder="Contraseña" required>
                </div>
                <div class="campo">
                    <h3>Confirmar Contraseña:</h3>
                    <input type="password" id="contrasena2" placeholder="Confirmar Contraseña" required>
                </div>
                <div class="campo">
                    <h3>Fecha de Nacimiento:</h3>
                    <input type="date" id="fecha" name="fecha" placeholder="Fecha de Nacimiento" required>
                </div>
                <div class="campo">
                    <h3>Pais: </h3>
                    <select id="paises" name="pais" class="form-control">
                        <!-- Listado de paises cargados de la API -->
                    </select>
                </div>
                <div class="campo">
                    <h3>Provincia:</h3>
                    <select id="departamentos" name="departamento" class="form-control">
                        <!-- Listado de departamentos cargados de la API -->
                    </select>
                </div>
                <div class="campo">
                    <h3>Ciudad:</h3>
                    <select id="ciudades" name="ciudad" class="form-control">
                        <!-- Listado de ciudades cargados de la API -->
                    </select>
                </div>
                <button type="submit">
                    <h3>Validar</h3>
                </button>
            </form>
        </div>
    </main>
    <footer>
        <div>
            <h4>Developed by: Alejandro Amador Ruiz & Juan José Jaramillo</h4>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./static/js/Api.js"></script>
    <script src="./static/js/Validaciones.js"></script>
    <script src="./static/js/Registro.js"></script>
</body>

</html>