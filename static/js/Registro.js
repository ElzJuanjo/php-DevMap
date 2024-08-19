function validarRegistro() {
    const formRegistro = document.getElementById('registro');
    formRegistro.addEventListener('submit', evt => {
        if (!validarCampos()) {
            evt.preventDefault();
            sweetAlert("¡Debe completar todos los campos!");
        }
        else if (!validarContrasenas()) {
            evt.preventDefault();
            sweetAlert("¡Las contraseñas no coinciden!");
        }
        else if (!limiteFecha()) {
            evt.preventDefault();
            sweetAlert("¡La fecha de nacimiento no es válida!");
        }
    });
}

window.addEventListener('DOMContentLoaded', async () => {
    validarRegistro();
    await cargarPaises();
    document.getElementById('paises').addEventListener('change', actualizarDepartamentos);
    document.getElementById('departamentos').addEventListener('change', actualizarCiudades);
});