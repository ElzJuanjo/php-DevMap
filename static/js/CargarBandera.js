async function obtenerBandera(pais) {
    try {
        const respuesta = await fetch('https://flagcdn.com/en/codes.json');
        const datos = await respuesta.json();
        for (let key in datos) {
            if (datos[key] == pais) {
                return key;
            }
        }
    } catch (error) {
        console.log("Error al obtener la bandera: " + error);
    }
}

async function cargarBandera() {
    const ubicacion = document.getElementById('ubicacion').innerHTML.split('-');
    const pais = ubicacion[2];
    const valor = await obtenerBandera(pais);

    const bandera = document.getElementById('bandera');
    bandera.src = `https://flagcdn.com/${valor}.svg`;
}

window.addEventListener('DOMContentLoaded', cargarBandera);