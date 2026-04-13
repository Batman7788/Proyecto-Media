/* ─── CREDENCIALES ─── */
var usuarios = {
    estudiante: { usuario: 'estudiante', clave: '1234' },
    docente:    { usuario: 'docente',    clave: '1234' },
    directivo:  { usuario: 'directivo', clave: '1234' }
};

var rolActual = null;

/* Destinos de redirección por rol */
var destinos = {
    estudiante: 'estudiante.html',
    docente:    'docente.html',
    directivo:  'directivo.html'
};

function seleccionarRol(rol, el) {
    rolActual = rol;
    document.querySelectorAll('.rol-btn').forEach(function(b) { b.classList.remove('sel'); });
    el.classList.add('sel');
    document.getElementById('error-msg').textContent = '';
}

function ingresar() {
    var msg = document.getElementById('error-msg');
    if (!rolActual) { msg.textContent = 'Selecciona un rol primero'; return; }

    var u = document.getElementById('usuario').value.trim();
    var c = document.getElementById('clave').value.trim();

    if (u !== usuarios[rolActual].usuario || c !== usuarios[rolActual].clave) {
        msg.textContent = 'Usuario o contraseña incorrectos'; return;
    }

    /* Guardar rol en localStorage y redirigir */
    localStorage.setItem('rolActual', rolActual);
    window.location.href = destinos[rolActual];
}
