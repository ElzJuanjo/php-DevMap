const botonEliminarPublicacion = document.querySelectorAll('#botonEliminarPublicacion');
const botonEliminarComentario = document.querySelectorAll('#botonEliminarComentario')

botonEliminarPublicacion.forEach(boton => {
    boton.addEventListener('click', async () => {
        const idPublicacion = boton.title;
        let formulario = new FormData();
        formulario.append('id', idPublicacion);

        try {
            const respuesta = await Swal.fire({
                title: "¿Deseas eliminar la publicación?",
                confirmButtonColor: 'red',
                confirmButtonText: "Eliminar",
                showCancelButton: true,
                cancelButtonText: "Cancelar"
            });
            if (respuesta.isConfirmed) {
                fetch('deletePublicacion.php', {
                    method: 'POST',
                    body: formulario
                });
                location.reload()
            }
        } catch (error) {
            console.error(error);
        }
    });
});

botonEliminarComentario.forEach(boton => {
    boton.addEventListener('click', async () => {
        const idComentario = boton.title;
        let formulario = new FormData();
        formulario.append('id',idComentario);
        try {
            const respuesta = await Swal.fire({
                title: "¿Deseas eliminar el comentario?",
                confirmButtonColor: 'red',
                confirmButtonText: "Eliminar",
                showCancelButton: true,
                cancelButtonText: "Cancelar"
            });
            if (respuesta.isConfirmed) {
                fetch('deleteComent.php', {
                    method: 'POST',
                    body: formulario
                });
                location.reload()
            }
            location.reload()
        } catch (error) {
            console.error(error)
        }
    })
})