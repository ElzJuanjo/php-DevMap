function validarCampos() {
    const camposValidar = ["Seleccionar el país", "Seleccionar el departamento", "Seleccionar la ciudad", ""]
    const paisSeleccionado = document.getElementById('paises').value;
    const departamentoSeleccionado = document.getElementById('departamentos').value;
    const ciudadSeleccionada = document.getElementById('ciudades').value;
    for (const campo of camposValidar) {
        if (paisSeleccionado === campo || departamentoSeleccionado === campo || ciudadSeleccionada === campo) {
            return false;
        }
    }
    return true;
}

function validarContrasenas() {
    const primerPass = document.getElementById('contrasena1').value;
    const segundaPass = document.getElementById('contrasena2').value;
    return primerPass === segundaPass;
}

function limiteFecha() {
    let fechaNacimiento = new Date(document.getElementById('fecha').value);
    let fechaActual = new Date();
    let fechaMenor = new Date('1960-01-01');

    return fechaNacimiento < fechaActual && fechaNacimiento > fechaMenor;
}

function sweetAlert(msg) {
    Swal.fire({
        title: msg,
        imageUrl: "https://media2.giphy.com/media/v1.Y2lkPTc5MGI3NjExMGs4NmxqbnFsY2c0dGd1OGNydWFmYTNsdDB5MmZoeTFyanhrcHB1ZiZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/KljWPErnYevfBeRbT6/giphy.webp",
        imageWidth: 400,
        imageHeight: 200,
        imageAlt: "Gif Nope",
        confirmButtonColor: '#4EBFD9'
    });
}