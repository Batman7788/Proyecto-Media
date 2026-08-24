<?php
session_start();
if (isset($_SESSION['usuario_rol']) && in_array($_SESSION['usuario_rol'], ['estudiante', 'docente', 'directivo'], true)) {
    header('Location: ' . $_SESSION['usuario_rol'] . '.php');
    exit;
}
$mensaje = $_GET['error'] ?? '';
$exito = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Box — Acceso</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* ── LAYOUT AUTH (versión original) ── */
        #auth-screen {
            min-height: 100vh;
            background: #111;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow: hidden;
        }

        .auth-card {
            background: #1c1c1c;
            border: 1px solid #2a2a2a;
            border-radius: 18px;
            width: 100%;
            max-width: 420px;
            overflow: hidden;
            position: relative;
            z-index: 1;
            animation: aparecer .4s ease;
            box-shadow: none;
        }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .auth-header {
            padding: 2rem 2rem 1.5rem;
            border-bottom: 1px solid #2a2a2a;
            text-align: center;
        }

        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        .auth-logo svg {
            color: #f5c518;
            width: 26px;
            height: 26px;
        }

        .auth-logo span {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -.3px;
        }

        .auth-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #252525;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 3px;
            gap: 3px;
        }

        .auth-tab {
            padding: 8px 0;
            border: none;
            border-radius: 8px;
            background: transparent;
            color: #888;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s ease;
        }

        .auth-tab.activo {
            background: #f5c518;
            color: #111;
            font-weight: 800;
        }

        .auth-tab:not(.activo):hover {
            color: #fff;
        }

        .auth-body {
            padding: 1.75rem 2rem 2rem;
        }

        .campo-auth {
            margin-bottom: 1rem;
        }

        .campo-auth label {
            display: block;
            font-size: 12.5px;
            color: #888;
            margin-bottom: 6px;
            font-weight: 700;
            letter-spacing: .2px;
        }

        .campo-auth input,
        .campo-auth select {
            width: 100%;
            background: #252525;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 12px 14px;
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: border-color .2s ease;
            font-family: sans-serif;
            -webkit-appearance: none;
            appearance: none;
        }

        .campo-auth input:focus,
        .campo-auth select:focus {
            border-color: #f5c518;
            box-shadow: none;
        }

        .campo-auth input::placeholder {
            color: #555;
        }

        .campo-auth select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        .campo-auth select option {
            background: #1c1c1c;
            color: #fff;
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 1rem;
        }

        .rol-card {
            background: #252525;
            border: 2px solid #333;
            border-radius: 12px;
            padding: 12px 6px;
            text-align: center;
            cursor: pointer;
            transition: all .25s cubic-bezier(.34, 1.56, .64, 1);
            color: #888;
        }

        .rol-card:hover {
            border-color: #555;
            color: #ccc;
            transform: translateY(-3px);
        }

        .rol-card.sel {
            border-color: #f5c518;
            background: #2a2500;
            color: #f5c518;
            transform: translateY(-4px);
        }

        .rol-card svg {
            width: 22px;
            height: 22px;
            display: block;
            margin: 0 auto 5px;
        }

        .rol-card span {
            font-size: 12px;
            font-weight: 600;
        }

        .codigo-box {
            background: rgba(245, 197, 24, 0.08);
            border: 1px solid rgba(245, 197, 24, 0.45);
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 1rem;
        }

        .codigo-box label {
            display: block;
            font-size: 12.5px;
            color: #fef3c7;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .codigo-box input {
            width: 100%;
            background: rgba(255,255,255,0.97);
            border: 1px solid #f5c518;
            border-radius: 8px;
            padding: 10px 12px;
            color: #111;
            font-size: 13px;
            outline: none;
            transition: border-color .2s ease;
            font-family: monospace;
            letter-spacing: 1px;
        }

        .codigo-box input:focus {
            border-color: #f5c518;
        }

        .codigo-box input::placeholder {
            color: #3a2e00;
            letter-spacing: 0;
            font-family: sans-serif;
        }

        .codigo-hint {
            font-size: 11px;
            color: #6b4f00;
            margin-top: 6px;
        }

        .btn-auth {
            width: 100%;
            background: #f5c518;
            color: #111;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: transform .15s ease, background .2s ease;
            margin-top: .5rem;
        }

        .btn-auth:hover {
            background: #ffd740;
            transform: scale(1.02);
        }

        .btn-auth:active {
            transform: scale(.98);
        }

        .btn-auth:disabled {
            opacity: .5;
            cursor: not-allowed;
            transform: none;
        }

        .msg-error {
            color: #e24b4a;
            font-size: 12px;
            text-align: center;
            margin-top: 8px;
            min-height: 16px;
            display: none;
        }

        .msg-ok {
            color: #7ae582;
            font-size: 12px;
            text-align: center;
            margin-top: 8px;
            min-height: 16px;
            display: none;
        }

        .divider-auth {
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            margin: 1rem 0 .75rem;
            position: relative;
        }

        .divider-auth::before,
        .divider-auth::after {
            content: '';
            position: absolute;
            top: 50%;
            width: calc(50% - 20px);
            height: 1px;
            background: #222;
        }

        .divider-auth::before { left: 0; }
        .divider-auth::after  { right: 0; }

        .creds-footer {
            text-align: center;
            font-size: 11px;
            color: #cbd5e1;
            padding: 0 2rem 1.25rem;
            font-weight: 600;
        }

        .btn-inicio {
            display: inline-block;
            width: 48%;
            margin-top: 1rem;
            padding: 9px 12px;
            border: 1px solid rgba(245, 197, 24, 0.5);
            border-radius: 8px;
            background: rgba(245, 197, 24, 0.08);
            color: #f5c518;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all .2s ease;
            margin-left: 26%;
        }

        .btn-inicio:hover {
            background: rgba(245, 197, 24, 0.15);
            transform: translateY(-1px);
        }

        @media (max-width: 480px) {
            .auth-body { padding: 1.5rem 1.25rem 1.5rem; }
            .auth-header { padding: 1.5rem 1.25rem 1.25rem; }
        }
    </style>
</head>
<body>

<div id="auth-screen">
    <div class="auth-card">

        <!-- CABECERA -->
        <div class="auth-header">
            <div class="auth-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 21V9l9-6 9 6v12"/>
                    <path d="M9 21V12h6v9"/>
                    <path d="M3 9h18"/>
                </svg>
                <span>School Box</span>
            </div>
            <div class="auth-tabs">
                <button class="auth-tab activo" id="tab-login" onclick="cambiarTab('login')">Iniciar sesión</button>
                <button class="auth-tab" id="tab-registro" onclick="cambiarTab('registro')">Registrarse</button>
            </div>
        </div>

        <form id="login-form" action="login.php" method="POST">
            <!-- ══════════ FORMULARIO LOGIN ══════════ -->
            <div class="auth-body" id="form-login">

                <div id="err-login" class="msg-error"><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></div>

                <div class="campo-auth">
                    <label>Correo electrónico</label>
                    <input type="email" id="login-email" name="Correo" placeholder="tu@correo.com" onkeydown="if(event.key==='Enter')hacerLogin()"/>
                </div>

                <div class="campo-auth">
                    <label>Contraseña</label>
                    <input type="password" id="login-pass" name="contra" placeholder="••••••••" onkeydown="if(event.key==='Enter')hacerLogin()"/>
                </div>

                <input type="hidden" id="login-rol" name="rol" value="">

                <div class="campo-auth">
                    <label>Rol</label>
                    <div class="roles-grid">
                        <div class="rol-card" id="rol-estudiante" onclick="selRol('estudiante',this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                            </svg>
                            <span>Estudiante</span>
                        </div>
                        <div class="rol-card" id="rol-docente" onclick="selRol('docente',this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <path d="M3 9h18M9 21V9"/>
                            </svg>
                            <span>Docente</span>
                        </div>
                        <div class="rol-card" id="rol-directivo" onclick="selRol('directivo',this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                            <span>Directivo</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-auth" id="btn-login" onclick="hacerLogin(); return false;">Ingresar</button>

                <div class="divider-auth">o</div>

                <p style="text-align:center;font-size:12px;color:#555;">
                    ¿No tienes cuenta?
                    <button type="button" onclick="cambiarTab('registro')" style="background:none;border:none;color:#f5c518;font-size:12px;font-weight:600;cursor:pointer;padding:0;">Regístrate aquí</button>
                </p>
            </div>
        </form>

        <form id="registro-form" action="insertarproyectomedia.php" method="POST">
            <!-- ══════════ FORMULARIO REGISTRO ══════════ -->
            <div class="auth-body" id="form-registro" style="display:none;">

                <div id="err-registro" class="msg-error"><?php echo htmlspecialchars($exito, ENT_QUOTES, 'UTF-8'); ?></div>
                <div id="ok-registro" class="msg-ok"></div>

                <div class="campo-auth">
                    <label>Nombre completo</label>
                    <input type="text" id="reg-nombre" name="Nombre" placeholder="Juan Pérez"/>
                </div>

                <div class="campo-auth">
                    <label>Correo electrónico</label>
                    <input type="email" id="reg-email" name="Correo" placeholder="tu@correo.com"/>
                </div>

                <div class="campo-auth">
                    <label>Contraseña <span style="color:#444;font-size:10px;">(mín. 6 caracteres)</span></label>
                    <input type="password" id="reg-pass" name="contra" placeholder="••••••••"/>
                </div>

                <div class="campo-auth">
                    <label>Rol</label>
                    <select id="reg-rol" name="rol" onchange="onCambioRol()">
                        <option value="estudiante">🎓 Estudiante</option>
                        <option value="docente">👨‍🏫 Docente</option>
                        <option value="directivo">👔 Directivo</option>
                    </select>
                </div>

                <!-- Código de acceso (solo docente / directivo) -->
                <div class="codigo-box" id="box-codigo" style="display:none;">
                    <label id="codigo-label">🔐 Código de acceso</label>
                    <input type="text" id="reg-codigo" name="codigo" placeholder="Ingresa el código"/>
                    <p class="codigo-hint" id="codigo-hint">Necesitas un código especial para este rol</p>
                </div>

                <button type="submit" class="btn-auth" id="btn-registro" onclick="hacerRegistro(); return false;">Crear cuenta</button>

                <div class="divider-auth">o</div>

                <p style="text-align:center;font-size:12px;color:#555;">
                    ¿Ya tienes cuenta?
                    <button type="button" onclick="cambiarTab('login')" style="background:none;border:none;color:#f5c518;font-size:12px;font-weight:600;cursor:pointer;padding:0;">Inicia sesión</button>
                </p>
            </div>
        </form>

        <a href="inicio.php" class="btn-inicio">Ir a inicio</a>

        <!-- PIE: acceso con base de datos -->
        <div class="creds-footer">
            Acceso real con MySQL y sesión del servidor.
        </div>

    </div>
</div>

<script src="login.js"></script>
</body>
</html>
