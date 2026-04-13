/* ─── GUARD ─── */
validarRol('directivo');

/* ─── ENCERES (editar + eliminar + historial) ─── */
function cargarEnceres() {
    var salon = parseInt(document.getElementById('sel-salon').value);
    var enceresPorSalon = obtenerEnceres();
    var datos = enceresPorSalon[salon];
    var cuerpo = document.getElementById('cuerpo-tabla');
    var histBox = document.getElementById('historial-box');

    cuerpo.innerHTML = '';
    datos.forEach(function(enc, i) {
        var est = enc.cantidad >= 10
            ? '<span class="est-ok">● Suficiente</span>'
            : enc.cantidad >= 5
                ? '<span class="est-baj">● Bajo</span>'
                : '<span class="est-cri">● Crítico</span>';

        /* Directivo: editar cantidad + eliminar fila */
        var acc = '<input class="input-cant" type="number" min="0" value="' + enc.cantidad + '" id="inp-' + i + '" />'
                + ' <button class="btn-grd" onclick="guardar(' + salon + ',' + i + ')">Guardar</button>'
                + ' <button class="btn-eli" onclick="eliminar(' + salon + ',' + i + ')">Eliminar</button>';

        cuerpo.innerHTML += '<tr>'
            + '<td>' + enc.nombre + '</td>'
            + '<td><span class="cant-badge">' + enc.cantidad + '</span></td>'
            + '<td>' + est + '</td>'
            + '<td>' + acc + '</td>'
            + '</tr>';
    });

    /* Mostrar historial si hay entradas */
    var historial = obtenerHistorial();
    if (historial.length > 0) {
        var html = '<div class="hist-titulo">Historial de modificaciones</div>';
        historial.slice().reverse().forEach(function(h) {
            html += '<div class="hist-item">'
                + '<div class="hist-info">Salón <strong>' + h.salon + '</strong> — <strong>' + h.encer + '</strong>: '
                + h.de + ' → <strong style="color:#4caf50">' + h.a + '</strong>'
                + (h.accion === 'eliminar' ? ' <span style="color:#e24b4a">[eliminado]</span>' : '') + '</div>'
                + '<div class="hist-hora">' + h.quien + ' · ' + h.hora + '</div>'
                + '</div>';
        });
        histBox.innerHTML = html;
    } else {
        histBox.innerHTML = '';
    }
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

    var historial = obtenerHistorial();
    var ahora = new Date();
    historial.push({
        salon: salon, encer: nombre, de: viejo, a: nuevo, accion: 'editar',
        quien: 'Directivo',
        hora: ahora.toLocaleTimeString() + ' · ' + ahora.toLocaleDateString()
    });
    guardarHistorial(historial);

    cargarEnceres();
}

function eliminar(salon, idx) {
    var enceresPorSalon = obtenerEnceres();
    var nombre = enceresPorSalon[salon][idx].nombre;
    var viejo  = enceresPorSalon[salon][idx].cantidad;

    enceresPorSalon[salon].splice(idx, 1);
    guardarEnceres(enceresPorSalon);

    var historial = obtenerHistorial();
    var ahora = new Date();
    historial.push({
        salon: salon, encer: nombre, de: viejo, a: 0, accion: 'eliminar',
        quien: 'Directivo',
        hora: ahora.toLocaleTimeString() + ' · ' + ahora.toLocaleDateString()
    });
    guardarHistorial(historial);

    cargarEnceres();
}

/* Cargar enceres al iniciar */
cargarEnceres();
