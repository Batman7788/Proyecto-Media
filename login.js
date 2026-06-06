
var CODIGOS_ROL = {
    docente:   'DOCENTE2024',
    directivo: 'DIRECTIVO2024'
};

/* ─── DESTINOS POR ROL ─── */
var destinos = {
    estudiante: 'estudiante.html',
    docente:    'docente.html',
    directivo:  'directivo.html'
};

/* ─── ROL SELECCIONADO EN LOGIN ─── */
var rolLogin = null;

function cambiarTab(tab) {
    var isLogin = tab === 'login';

    document.getElementById('tab-login').classList.toggle('activo', isLogin);
    document.getElementById('tab-registro').classList.toggle('activo', !isLogin);

    document.getElementById('form-login').style.display    = isLogin ? 'block' : 'none';
    document.getElementById('form-registro').style.display = isLogin ? 'none'  : 'block';

    /* Limpiar mensajes al cambiar */
    ocultarMensajes();
}

/* ══════════════════════════
   SELECTOR DE ROL (login)
   ══════════════════════════ */
function selRol(rol, el) {
    rolLogin = rol;
    document.querySelectorAll('.rol-card').forEach(function(c) { c.classList.remove('sel'); });
    el.classList.add('sel');
    ocultarMensajes();
}

/* ══════════════════════════
   CAMBIO DE ROL (registro) → mostrar/ocultar código
   ══════════════════════════ */
function onCambioRol() {
    var rol = document.getElementById('reg-rol').value;
    var boxCodigo = document.getElementById('box-codigo');
    var label     = document.getElementById('codigo-label');
    var hint      = document.getElementById('codigo-hint');

    if (rol === 'docente' || rol === 'directivo') {
        boxCodigo.style.display = 'block';
        label.textContent = '🔐 Código de acceso para ' + rol;
        hint.textContent  = 'Pídele el código a un administrador para registrarte como ' + rol;
    } else {
        boxCodigo.style.display = 'none';
        document.getElementById('reg-codigo').value = '';
    }

    ocultarMensajes();
}

/* ══════════════════════════
   INICIAR SESIÓN
   ══════════════════════════ */
function hacerLogin() {
    var email  = (document.getElementById('login-email').value || '').trim().toLowerCase();
    var pass   = (document.getElementById('login-pass').value  || '').trim();
    var errEl  = document.getElementById('err-login');
    var btn    = document.getElementById('btn-login');

    ocultarMensajes();

    /* Validaciones básicas */
    if (!email) { mostrarError(errEl, 'Ingresa tu correo electrónico'); return; }
    if (!pass)  { mostrarError(errEl, 'Ingresa tu contraseña'); return; }
    if (!rolLogin) { mostrarError(errEl, 'Selecciona un rol para continuar'); return; }

    /* Buscar usuario en localStorage */
    var usuarios = obtenerUsuarios();
    var usuario  = usuarios.find(function(u) {
        return u.email === email && u.password === pass && u.rol === rolLogin;
    });

    if (!usuario) {
        /* Compatibilidad con cuentas demo antiguas (usuario/clave planos) */
        var demoLegacy = {
            estudiante: { email: 'estudiante', password: '1234' },
            docente:    { email: 'docente',    password: '1234' },
            directivo:  { email: 'directivo',  password: '1234' }
        };
        var demo = demoLegacy[rolLogin];
        if (demo && (email === demo.email || email === demo.email + '@demo.com') && pass === demo.password) {
            /* Usar credenciales de demo */
            finalizarLogin(rolLogin, 'Usuario Demo', email);
            return;
        }

        mostrarError(errEl, 'Correo, contraseña o rol incorrectos');
        agitarBtn(btn);
        return;
    }

    finalizarLogin(usuario.rol, usuario.nombre, usuario.email);
}

function finalizarLogin(rol, nombre, email) {
    localStorage.setItem('rolActual', rol);
    localStorage.setItem('usuarioNombre', nombre);
    localStorage.setItem('usuarioEmail', email);
    window.location.href = destinos[rol];
}

/* ══════════════════════════
   REGISTRARSE
   ══════════════════════════ */
function hacerRegistro() {
    var nombre  = (document.getElementById('reg-nombre').value || '').trim();
    var email   = (document.getElementById('reg-email').value  || '').trim().toLowerCase();
    var pass    = (document.getElementById('reg-pass').value   || '').trim();
    var rol     = document.getElementById('reg-rol').value;
    var codigo  = (document.getElementById('reg-codigo').value || '').trim();
    var errEl   = document.getElementById('err-registro');
    var okEl    = document.getElementById('ok-registro');
    var btn     = document.getElementById('btn-registro');

    ocultarMensajes();

    /* Validaciones */
    if (!nombre) { mostrarError(errEl, 'Ingresa tu nombre completo'); return; }
    if (!email || !email.includes('@')) { mostrarError(errEl, 'Ingresa un correo electrónico válido'); return; }
    if (pass.length < 6) { mostrarError(errEl, 'La contraseña debe tener al menos 6 caracteres'); return; }

    /* Validar código para docente / directivo */
    if (rol === 'docente' || rol === 'directivo') {
        if (!codigo) {
            mostrarError(errEl, 'Debes ingresar el código de acceso para el rol de ' + rol);
            return;
        }
        if (codigo !== CODIGOS_ROL[rol]) {
            mostrarError(errEl, 'Código de acceso incorrecto para el rol de ' + rol);
            agitarBtn(btn);
            return;
        }
    }

    /* Verificar que el email no exista ya */
    var usuarios = obtenerUsuarios();
    var yaExiste = usuarios.some(function(u) { return u.email === email; });
    if (yaExiste) {
        mostrarError(errEl, 'Ya existe una cuenta con ese correo electrónico');
        return;
    }

    /* Guardar nuevo usuario */
    usuarios.push({
        nombre:   nombre,
        email:    email,
        password: pass,
        rol:      rol,
        fechaRegistro: new Date().toLocaleDateString()
    });
    localStorage.setItem('usuarios', JSON.stringify(usuarios));

    /* Mostrar éxito y cambiar a login */
    mostrarOk(okEl, '¡Cuenta creada correctamente! Ya puedes iniciar sesión.');
    btn.disabled = true;

    setTimeout(function() {
        btn.disabled = false;
        cambiarTab('login');
        /* Prerellenar email en login */
        document.getElementById('login-email').value = email;
        /* Seleccionar automáticamente el rol registrado */
        var cardId = 'rol-' + rol;
        var card   = document.getElementById(cardId);
        if (card) selRol(rol, card);
    }, 1800);
}

/* ══════════════════════════
   UTILIDADES
   ══════════════════════════ */
function obtenerUsuarios() {
    var raw = localStorage.getItem('usuarios');
    return raw ? JSON.parse(raw) : [];
}

function mostrarError(el, msg) {
    el.textContent = msg;
    el.style.display = 'block';
}

function mostrarOk(el, msg) {
    el.textContent = msg;
    el.style.display = 'block';
}

function ocultarMensajes() {
    ['err-login', 'err-registro', 'ok-registro'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.style.display = 'none';
    });
}

function agitarBtn(btn) {
    btn.style.transition = 'transform .08s';
    var frames = ['-6px','6px','-4px','4px','0px'];
    var i = 0;
    var t = setInterval(function() {
        btn.style.transform = 'translateX(' + frames[i] + ')';
        i++;
        if (i >= frames.length) {
            clearInterval(t);
            btn.style.transform = '';
        }
    }, 60);
}

/* ─── CERRAR SESIÓN (reutilizada por las otras páginas via shared.js) ─── */
/* La función cerrarSesion() ya está en shared.js — no se duplica aquí */
