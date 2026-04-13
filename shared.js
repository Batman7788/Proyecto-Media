/* ─── DATOS COMPARTIDOS ─── */

/* Inventario de enceres por salón (persistido en localStorage) */
function obtenerEnceres() {
    var guardado = localStorage.getItem('enceresPorSalon');
    if (guardado) return JSON.parse(guardado);

    /* Inicializar con valores aleatorios la primera vez */
    var data = {};
    for (var s = 1; s <= 10; s++) {
        data[s] = [
            { nombre: 'Sillas',       cantidad: Math.floor(Math.random() * 20) + 15 },
            { nombre: 'Mesas',        cantidad: Math.floor(Math.random() * 10) + 8  },
            { nombre: 'Computadores', cantidad: Math.floor(Math.random() * 15) + 5  },
            { nombre: 'Tableros',     cantidad: Math.floor(Math.random() * 3)  + 1  },
            { nombre: 'Videobeam',    cantidad: Math.floor(Math.random() * 2)  + 1  }
        ];
    }
    localStorage.setItem('enceresPorSalon', JSON.stringify(data));
    return data;
}

function guardarEnceres(data) {
    localStorage.setItem('enceresPorSalon', JSON.stringify(data));
}

/* Historial (persistido en localStorage) */
function obtenerHistorial() {
    var h = localStorage.getItem('historial');
    return h ? JSON.parse(h) : [];
}

function guardarHistorial(h) {
    localStorage.setItem('historial', JSON.stringify(h));
}

/* ─── NAVEGACIÓN ─── */
function mostrarVista(v) {
    document.querySelectorAll('.vista').forEach(function(x) { x.classList.remove('visible'); });
    document.getElementById('vista-' + v).classList.add('visible');

    document.querySelectorAll('.nav-btn').forEach(function(b) { b.classList.remove('activo-nav'); });
    var vistas = ['inicio', 'enceres', 'informacion', 'nosotros', 'sugerencias'];
    var idx = vistas.indexOf(v);
    if (idx >= 0) document.querySelectorAll('.nav-btn')[idx].classList.add('activo-nav');

    if (v === 'enceres') cargarEnceres();
}

/* ─── SUBTABS INFORMACIÓN ─── */
function mostrarInfoTab(tab, el) {
    document.querySelectorAll('.info-panel').forEach(function(p) { p.classList.remove('visible'); });
    document.querySelectorAll('.info-tab').forEach(function(t)   { t.classList.remove('activo-tab'); });
    document.getElementById('panel-' + tab).classList.add('visible');
    el.classList.add('activo-tab');
}

/* ─── SUGERENCIAS ─── */
function enviarSugerencia() {
    var nombre = document.getElementById('sug-nombre').value.trim();
    var texto  = document.getElementById('sug-texto').value.trim();
    if (!nombre || !texto) { alert('Por favor completa el nombre y la sugerencia.'); return; }
    document.getElementById('sug-nombre').value = '';
    document.getElementById('sug-grado').value  = '';
    document.getElementById('sug-texto').value  = '';
    var msg = document.getElementById('msg-sug');
    msg.style.display = 'block';
    setTimeout(function() { msg.style.display = 'none'; }, 4000);
}

/* ─── SOPORTE TÉCNICO ─── */
function mostrarArchivos(input) {
    var lista = document.getElementById('lista-archivos');
    if (input.files.length === 0) { lista.textContent = 'Ningún archivo seleccionado'; return; }
    var nombres = Array.from(input.files).map(function(f) { return f.name; }).join(', ');
    lista.textContent = input.files.length + ' archivo(s): ' + nombres;
}

function enviarSoporte() {
    var desc = document.getElementById('sop-desc').value.trim();
    if (!desc) { alert('Por favor escribe una descripción del problema.'); return; }
    document.getElementById('sop-desc').value = '';
    document.getElementById('lista-archivos').textContent = 'Ningún archivo seleccionado';
    document.getElementById('sop-archivo').value = '';
    var msg = document.getElementById('msg-sop');
    msg.style.display = 'block';
    setTimeout(function() { msg.style.display = 'none'; }, 4000);
}

/* ─── CERRAR SESIÓN ─── */
function cerrarSesion() {
    localStorage.removeItem('rolActual');
    window.location.href = 'index.html';
}

/* ─── GUARD: validar que el rol coincida ─── */
function validarRol(rolEsperado) {
    var rol = localStorage.getItem('rolActual');
    if (rol !== rolEsperado) {
        window.location.href = 'index.html';
        return false;
    }
    return true;
}
