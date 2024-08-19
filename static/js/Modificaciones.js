async function cambiarPais() {
    const { value: valoresFormulario } = await Swal.fire({
        title: "Cambiar de Ubicación",
        html: `
            <select id="paises" class="swal2-input"></select>
            <select id="departamentos" class="swal2-input"></select>
            <select id="ciudades" class="swal2-input"></select>
        `,
        showCancelButton: true,
        confirmButtonColor: '#4EBFD9',
        focusConfirm: false,
        didOpen: () => {
            cargarPaises();

            document.getElementById('paises').addEventListener('change', actualizarDepartamentos);
            document.getElementById('departamentos').addEventListener('change', actualizarCiudades);
        },

        preConfirm: () => {
            return [
                document.getElementById("paises").value,
                document.getElementById("departamentos").value,
                document.getElementById("ciudades").value
            ];
        }
    });

    if (valoresFormulario) {
        if (validarCampos()) {
            valoresFormulario.reverse();
            const resultado = valoresFormulario.join('-');

            let formulario = new FormData();
            formulario.append('campo', 'ubicacion');
            formulario.append('modificacion', resultado);

            try {
                await fetch('modify.php', {
                    method: 'POST',
                    body: formulario
                });
                location.reload();
            } catch (error) {
                console.log("Error al actualizar la ubicación: " + error);
            }

        } else {
            sweetAlert("¡Debe completar todos los campos!");
        }
    }
}

async function cambiarNombre() {
    const { value: valoresFormulario } = await Swal.fire({
        title: "Cambiar de Nombre/Apellido",
        html: `
          <input id="nombre" class="swal2-input" placeholder="Nuevo Nombre">
          <input id="apellido" class="swal2-input" placeholder="Nuevo Apellido">
        `,
        showCancelButton: true,
        confirmButtonColor: '#4EBFD9',
        focusConfirm: false,
        preConfirm: () => {
            return [
                document.getElementById("nombre").value,
                document.getElementById("apellido").value
            ];
        }
    });
    if (valoresFormulario) {
        nombre = valoresFormulario[0].trim();
        apellido = valoresFormulario[1].trim();
        if (nombre != "") {
            let formulario = new FormData();
            formulario.append('campo', 'nombre');
            formulario.append('modificacion', nombre);

            try {
                await fetch('modify.php', {
                    method: 'POST',
                    body: formulario
                });
            } catch (error) {
                console.log("Error al actualizar el nombre: " + error);
            }
        }
        if (apellido != "") {
            let formulario = new FormData();
            formulario.append('campo', 'apellido');
            formulario.append('modificacion', apellido);

            try {
                await fetch('modify.php', {
                    method: 'POST',
                    body: formulario
                });
            } catch (error) {
                console.log("Error al actualizar el apellido: " + error);
            }
        }
        location.reload();
    }
}

async function cambiarDatos(encabezado, campo) {
    const { value: valorForm } = await Swal.fire({
        title: encabezado,
        input: "text",
        confirmButtonColor: '#4EBFD9',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return "¡El campo está vacío!";
            }
        }
    });
    if (valorForm) {
        let formulario = new FormData();
        formulario.append('campo', campo);
        formulario.append('modificacion', valorForm);

        try {
            await fetch('modify.php', {
                method: 'POST',
                body: formulario
            });
            location.reload();
        } catch (error) {
            console.log("Error al actualizar el " + campo + ": " + error);
        }
    }
}

async function cambiarCorreo() {
    const { value: email } = await Swal.fire({
        title: "Dirección del Correo:",
        input: "email",
        confirmButtonColor: '#4EBFD9',
        showCancelButton: true
    });
    if (email) {
        let formulario = new FormData();
        formulario.append('campo', 'correo');
        formulario.append('modificacion', email);

        try {
            const respuesta = await fetch('modify.php', {
                method: 'POST',
                body: formulario
            });
            let datos = await respuesta.json();
            datos = datos.status;
            if (datos != "denied") {
                location.reload();
            } else {
                Swal.fire({
                    title: "¡No puedes usar ese correo!",
                    confirmButtonColor: '#4EBFD9',
                    icon: "error"
                });
            }
        } catch (error) {
            console.log("Error al actualizar el correo: " + error);
        }
    }
}

async function cambiarUrl(encabezado, campo) {
    const { value: url } = await Swal.fire({
        title: encabezado,
        input: "url",
        confirmButtonColor: '#4EBFD9',
        showCancelButton: true
    });
    if (url) {
        let formulario = new FormData();
        formulario.append('campo', campo);
        formulario.append('modificacion', url);

        try {
            await fetch('modify.php', {
                method: 'POST',
                body: formulario
            });
            location.reload();
        } catch (error) {
            console.log("Error al actualizar el " + campo + ": " + error);
        }
    }
}

async function cambiarFecha() {
    const { value: date } = await Swal.fire({
        title: "Cambiar Fecha de Nacimiento",
        input: "date",
        confirmButtonColor: '#4EBFD9',
        showCancelButton: true,
        didOpen: () => {
            const fechaActual = (new Date()).toISOString();
            Swal.getInput().min = '1960-01-01';
            Swal.getInput().max = fechaActual.split("T")[0];
        }
    });
    if (date) {
        let formulario = new FormData();
        formulario.append('campo', 'fecha_nacimiento');
        formulario.append('modificacion', date);

        try {
            await fetch('modify.php', {
                method: 'POST',
                body: formulario
            });
            location.reload();
        } catch (error) {
            console.log("Error al actualizar la fecha: " + error);
        }
    }
}

async function cambiarClave() {
    let primerForm = new FormData();
    primerForm.append('campo', 'obtenerClave');
    primerForm.append('modificacion', '');

    let clave = '';
    try {
        const respuesta = await fetch('modify.php', {
            method: 'POST',
            body: primerForm
        });
        clave = await respuesta.json();
        clave = clave.message;
    } catch (error) {
        console.log("No se pudo obtener la contraseña: " + error);
    }
    const { value: valoresFormulario } = await Swal.fire({
        title: "Cambiar de Contraseña",
        html: `
          <input id="claveActual" class="swal2-input" placeholder="Clave Actual">
          <input id="nuevaClave" class="swal2-input" placeholder="Nueva Clave">
        `,
        showCancelButton: true,
        confirmButtonColor: '#4EBFD9',
        focusConfirm: false,
        preConfirm: () => {
            return [
                document.getElementById("claveActual").value,
                document.getElementById("nuevaClave").value
            ];
        }
    });
    if (valoresFormulario) {
        claveActual = valoresFormulario[0].trim();
        nuevaClave = valoresFormulario[1].trim();
        if (claveActual != "" && nuevaClave != "") {
            if (claveActual == clave) {
                let formulario = new FormData();
                formulario.append('campo', 'contrasena');
                formulario.append('modificacion', nuevaClave);
                try {
                    await fetch('modify.php', {
                        method: 'POST',
                        body: formulario
                    });
                    Swal.fire({
                        title: "¡Se ha cambiado la contraseña!",
                        confirmButtonColor: '#4EBFD9',
                        icon: "success"
                    });
                } catch (error) {
                    console.log("Error al actualizar la contraseña: " + error);
                }
            } else {
                sweetAlert("¡La contraseña actual no es correcta!")
            }
        } else {
            sweetAlert("¡Debe completar todos los campos!");
        }
    }
}

async function eliminarCuenta() {
    let primerForm = new FormData();
    primerForm.append('campo', 'obtenerClave');
    primerForm.append('modificacion', '');

    let clave = '';
    try {
        const respuesta = await fetch('modify.php', {
            method: 'POST',
            body: primerForm
        });
        clave = await respuesta.json();
        clave = clave.message;
    } catch (error) {
        console.log("No se pudo obtener la contraseña: " + error);
    }
    const { value: password } = await Swal.fire({
        title: "¿Deseas continuar?",
        input: "password",
        imageUrl: "https://media1.giphy.com/media/v1.Y2lkPTc5MGI3NjExYzI2dWE3cmk4d2Rrd2JhZThnampmaDhkbmQ2Z2RrYWhmYjM0bjdzOSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/TT7JW4Qm7uaNW/200.webp",
        inputLabel: "No podrás recuperar tu cuenta después de esto.",
        inputPlaceholder: "Clave Actual",
        confirmButtonColor: 'red',
        confirmButtonText: "Eliminar",
        showCancelButton: true
    });
    if (password) {
        if (password == clave) {
            let form = new FormData();
            form.append('campo', 'eliminar');
            form.append('modificacion', '');

            try {
                await fetch('modify.php', {
                    method: 'POST',
                    body: form
                });
                window.location.href = 'index.php';
            } catch (error) {
                console.log("Error al eliminar la cuenta: " + error);
            }
        } else {
            sweetAlert("¡La contraseña actual no es correcta!")
        }
    }
}

window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('cambiarPais').addEventListener('click', cambiarPais);
    document.getElementById('cambiarNombre').addEventListener('click', cambiarNombre);
    document.getElementById('cambiarTitulo').addEventListener('click', () => {
        cambiarDatos("Cambiar de Titulo", "titulo");
    });
    document.getElementById('cambiarBio').addEventListener('click', () => {
        cambiarDatos("Cambiar de Biografía", "bio");
    });
    document.getElementById('cambiarCorreo').addEventListener('click', cambiarCorreo);
    document.getElementById('cambiarRepo').addEventListener('click', () => {
        cambiarUrl("Link del Repositorio:", "repositorio");
    });
    document.getElementById('cambiarImagen').addEventListener('click', () => {
        cambiarUrl("Link de la Imagen:", "imagen");
    });
    document.getElementById('cambiarFecha').addEventListener('click', cambiarFecha);
    document.getElementById('cambiarClave').addEventListener('click', cambiarClave);
    document.getElementById('eliminarCuenta').addEventListener('click', eliminarCuenta);
});