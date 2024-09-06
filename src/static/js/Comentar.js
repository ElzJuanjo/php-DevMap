async function comentar(event) {
    event.preventDefault()
    const form = document.getElementById('formularioComentario');
    const comentario = document.getElementById('comentario').value;
    if (comentario.replace(/\s+/g, '')==="") {
        form.reportValidity();
    } else {
        const id_publicacion = document.getElementById('comentar');
        let formulario = new FormData();
        formulario.append('comentario', comentario);
        formulario.append('id_publicacion', id_publicacion.title);
        try {
            await fetch('coment.php', {
                method: 'POST',
                body: formulario
            });
            location.reload();
        } catch (error) {
            console.log("Error al comentar: ", error)
        }
    }
}

window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('comentar').addEventListener('click', comentar);
})