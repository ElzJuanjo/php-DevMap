const botonSeguir = document.querySelectorAll('#seguir');
let seguidores = document.querySelectorAll('#seguidores');

botonSeguir.forEach(boton => {
    boton.addEventListener('click', async () => {
        const seguido = boton.title;
        let formulario = new FormData();
        formulario.append('seguido', seguido);

        try {
            const respuesta = await fetch('seguir.php', {
                method: 'POST',
                body: formulario
            });
            const datos = await respuesta.json();
            boton.innerHTML = datos.mensaje;
            boton.className = datos.clase;
            seguidores.forEach(elemento => {
                elemento.innerHTML = datos.seguidores;
            });
        } catch {
            console.log("Error en la petición.");
        }
    });
});