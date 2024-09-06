const botonLogin = document.querySelectorAll('#botonLogin');

botonLogin.forEach(boton => {
    boton.addEventListener('click', async (e) => {
        let formulario = new FormData();
        e.preventDefault()
        formulario.append('correo', document.getElementById('correo').value);
        formulario.append('contrasena', document.getElementById('contrasena').value);

        try {
            const respuesta = await fetch('src/login.php', {
                method: 'POST',
                body: formulario
            });
            const datos = await respuesta.json();
            if (datos.status == 'logged') {
                console.log(document.getElementById('correo').value)
                window.location.href = 'src/wall.php';
            } else {
                Swal.fire({
                    title: "Correo o contraseña incorrectos",
                    confirmButtonText: "OK",
                });
            }
        } catch {
            console.log("Error en la petición.");
        }
    });
});