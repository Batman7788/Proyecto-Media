/* ─── GUARD ─── */
validarRol('estudiante');

/* ─── ENCERES (solo lectura) ─── */
function cargarEnceres() {
    var salon = parseInt(document.getElementById('sel-salon').value);
    var enceresPorSalon = obtenerEnceres();
    var datos = enceresPorSalon[salon];
    var cuerpo = document.getElementById('cuerpo-tabla');

    cuerpo.innerHTML = '';
    datos.forEach(function(enc) {
        var est = enc.cantidad >= 10
            ? '<span class="est-ok">● Suficiente</span>'
            : enc.cantidad >= 5
                ? '<span class="est-baj">● Bajo</span>'
                : '<span class="est-cri">● Crítico</span>';

        cuerpo.innerHTML += '<tr>'
            + '<td>' + enc.nombre + '</td>'
            + '<td><span class="cant-badge">' + enc.cantidad + '</span></td>'
            + '<td>' + est + '</td>'
            + '</tr>';
    });
}

/* Cargar enceres al iniciar */
cargarEnceres();
