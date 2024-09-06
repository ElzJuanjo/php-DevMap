async function obtenerToken() {
    try {
        const respuesta = await fetch('https://www.universal-tutorial.com/api/getaccesstoken', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'api-token': 'D4qjYCSFne0K6aPa6YwgOX3IJ633PVpJHB7PjZMEDNMJ78kjCWvL2qgCwG9T8od_seI',
                'user-email': 'elzjuanjojv@gmail.com'
            }
        });
        const datos = await respuesta.json();
        return datos.auth_token;
    } catch (error) {
        console.log('Error al obtener el token: ' + error);
    }
}

async function obtenerDatos(url) {
    const token = await obtenerToken();
    try {
        const respuesta = await fetch(url, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
        return await respuesta.json();
    } catch (error) {
        console.log('Error al obtener los datos: ' + error);
    }
}

async function obtenerPaises() {
    return await obtenerDatos('https://www.universal-tutorial.com/api/countries/');
}

async function obtenerDepartamentos(pais) {
    return await obtenerDatos(`https://www.universal-tutorial.com/api/states/${pais}`);
}

async function obtenerCiudades(departamento) {
    return await obtenerDatos(`https://www.universal-tutorial.com/api/cities/${departamento}`);
}

function llenarSelector(selectorId, items) {
    const selector = document.getElementById(selectorId);
    if (items && Array.isArray(items) && selector) {
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.country_name || item.state_name || item.city_name;
            option.textContent = item.country_name || item.state_name || item.city_name;
            selector.appendChild(option);
        });
    } else {
        console.log(`No se han podido cargar los datos para ${selectorId}.`);
    }
}

function reiniciarItems(selectorId, textoInicial) {
    const selector = document.getElementById(selectorId);
    if (selector) {
        selector.innerHTML = '';
        const textoSeleccionar = document.createElement('option');
        textoSeleccionar.disabled = true;
        textoSeleccionar.selected = true;
        textoSeleccionar.textContent = textoInicial;
        selector.appendChild(textoSeleccionar);
    }
}

async function cargarPaises() {
    const paises = await obtenerPaises();
    reiniciarItems('paises', 'Seleccionar el país');
    llenarSelector('paises', paises);
}

async function cargarDepartamentos(pais) {
    const departamentos = await obtenerDepartamentos(pais);
    llenarSelector('departamentos', departamentos);
}

async function cargarCiudades(departamento) {
    const ciudades = await obtenerCiudades(departamento);
    llenarSelector('ciudades', ciudades);
}

async function actualizarDepartamentos() {
    const paisSeleccionado = document.getElementById('paises').value;
    reiniciarItems('departamentos', 'Seleccionar el departamento');
    reiniciarItems('ciudades', 'Seleccionar la ciudad')
    await cargarDepartamentos(paisSeleccionado);
}

async function actualizarCiudades() {
    const departamentoSeleccionado = document.getElementById('departamentos').value;
    reiniciarItems('ciudades', 'Seleccionar la ciudad')
    await cargarCiudades(departamentoSeleccionado);
}