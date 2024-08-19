const botonLike = document.querySelectorAll('#botonLike');

botonLike.forEach(boton => {
    boton.addEventListener('click', async () => {
        const idPublicacion = boton.title;
        let formulario = new FormData();
        formulario.append('id', idPublicacion);

        try {
            const respuesta = await fetch('like.php', {
                method: 'POST',
                body: formulario
            });
            const datos = await respuesta.json();
            boton.className = datos.Clase;
            boton.innerHTML = datos.Html;
        } catch {
            console.log("Error en la petición.");
        }
    });
});