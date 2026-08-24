<?php
// inicio.php - Página principal del sistema de inventario
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - I.E. Manuel J Betancur</title>
    <style>
        /* --- Paleta de colores basada en image_054709.png --- */
        :root {
            --bg-main: #121212;
            --bg-header: #181818;
            --bg-card: #202020;
            --accent-color: #f7d02c; /* Amarillo/Dorado */
            --text-primary: #ffffff;
            --text-secondary: #9e9e9e;
            --border-color: #333333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-primary);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- Encabezado y Navegación --- */
        header {
            background-color: var(--bg-header);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .logo-icon {
            color: var(--accent-color);
            font-size: 1.5rem;
            width: 60px;
            height: 60px;
            display: flex;
            
        }

        .btn-register {
            background-color: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            padding: 8px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            border-color: var(--text-primary);
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* --- Contenido Principal --- */
        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 60px 20px;
            text-align: center;
        }

        .hero-title {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .hero-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
            margin-bottom: 50px;
            max-width: 600px;
        }

        .content-section {
            display: flex;
            flex-direction: column;
            gap: 30px;
            max-width: 800px;
            width: 100%;
        }

        .card {
            background-color: var(--bg-card);
            border-radius: 12px;
            padding: 40px;
            border: 1px solid var(--border-color);
            text-align: left;
        }

        .card h2 {
            color: var(--accent-color);
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .card p {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 15px;
        }

        /* --- Sección de Creadores --- */
        .creators-list {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .creators-list li {
            background-color: var(--bg-main);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            text-align: center;
            font-size: 0.95rem;
        }

        /* --- Pie de página --- */
        footer {
            border-top: 1px solid var(--border-color);
            padding: 30px 40px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.85rem;
            background-color: var(--bg-header);
        }
    </style>
</head>
<body>

    <!-- Encabezado con Botón de Registro -->
    <header>
        <div class="logo-container">
            <span class="logo-icon"><img src="imagenes/EscudoMJBreal.png" alt="Escudo institucional de la Institución Educativa Manuel J Betancur"></span> I.E. Manuel J Betancur
        </div>
        <a href="registro.php" class="btn-register">Registrarse</a>
    </header>

    <!-- Contenido Principal -->
    <main>
        <h1 class="hero-title">¡Bienvenidos a nuestra Plataforma!</h1>
        <p class="hero-subtitle">Gestión y control de recursos de la Institución Educativa Manuel J Betancur.</p>

        <div class="content-section">
            
            <!-- Tarjeta de Información de la Página -->
            <div class="card">
                <h2>¿De qué trata esta plataforma?</h2>
                <p>
                    Esta página web ha sido desarrollada con un propósito claro: <strong>transformar y modernizar la administración de nuestros recursos</strong>. 
                </p>
                <p>
                    El sistema está diseñado para que los estudiantes, docentes y directivos se les facilite enormemente el acceso al inventario de enseres de la <strong>Institución Educativa Manuel J Betancur</strong>. A través de esta herramienta, buscamos promover la transparencia, el cuidado de nuestras instalaciones y agilizar las consultas, permitiendo que toda la comunidad educativa sepa exactamente con qué materiales y mobiliario contamos en cada salón y área común.
                </p>
            </div>

            <!-- Tarjeta de Desarrolladores -->
            <div class="card">
                <h2>Equipo de Desarrollo</h2>
                <p>Este proyecto fue ideado, diseñado y programado por el siguiente equipo de estudiantes comprometidos con la innovación tecnológica de nuestra institución:</p>
                
                <ul class="creators-list">
                    <li>Emmanuel Arredondo Holguin</li>
                    <li>Salome Montoya Pareja</li>
                    <li>Luciana Acevedo Valencia</li>
                    <li>Elizabeth Borja Ramos</li>
                    <li>Felipe Hernandez Velez</li>
                </ul>
            </div>

        </div>
    </main>

    <!-- Pie de Página -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sistema Escolar I.E. Manuel J Betancur. Todos los derechos reservados.</p>
    </footer>

</body>
</html>