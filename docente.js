/* ─── GUARD ─── */
validarRol('docente');

/* ─── ENCERES (editar cantidades) ─── */
function cargarEnceres() {
    var salon = parseInt(document.getElementById('sel-salon').value);
    var enceresPorSalon = obtenerEnceres();
    var datos = enceresPorSalon[salon];
    var cuerpo = document.getElementById('cuerpo-tabla');

    cuerpo.innerHTML = '';
    datos.forEach(function(enc, i) {
        var est = enc.cantidad >= 10
            ? '<span class="est-ok">● Suficiente</span>'
            : enc.cantidad >= 5
                ? '<span class="est-baj">● Bajo</span>'
                : '<span class="est-cri">● Crítico</span>';

        /* Docente: solo puede editar la cantidad */
        var acc = '<input class="input-cant" type="number" min="0" value="' + enc.cantidad + '" id="inp-' + i + '" />'
                + ' <button class="btn-grd" onclick="guardar(' + salon + ',' + i + ')">Guardar</button>';

        cuerpo.innerHTML += '<tr>'
            + '<td>' + enc.nombre + '</td>'
            + '<td><span class="cant-badge">' + enc.cantidad + '</span></td>'
            + '<td>' + est + '</td>'
            + '<td>' + acc + '</td>'
            + '</tr>';
    });
}

function guardar(salon, idx) {
    var inp = document.getElementById('inp-' + idx);
    var nuevo = parseInt(inp.value);
    if (isNaN(nuevo) || nuevo < 0) return;

    var enceresPorSalon = obtenerEnceres();
    var viejo = enceresPorSalon[salon][idx].cantidad;
    var nombre = enceresPorSalon[salon][idx].nombre;

    enceresPorSalon[salon][idx].cantidad = nuevo;
    guardarEnceres(enceresPorSalon);

    /* Registrar en historial */
    var historial = obtenerHistorial();
    var ahora = new Date();
    historial.push({
        salon: salon, encer: nombre, de: viejo, a: nuevo, accion: 'editar',
        quien: 'Docente',
        hora: ahora.toLocaleTimeString() + ' · ' + ahora.toLocaleDateString()
    });
    guardarHistorial(historial);

    cargarEnceres();
}

/* Cargar enceres al iniciar */
cargarEnceres();
