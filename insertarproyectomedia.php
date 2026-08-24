<?php
session_start();
include 'conexion.php';

$Correo = trim($_POST['Correo'] ?? '');
$contra = trim($_POST['contra'] ?? '');
$rol = trim($_POST['rol'] ?? '');
$Nombre = trim($_POST['Nombre'] ?? '');

if ($Correo === '' || $contra === '' || $rol === '' || $Nombre === '') {
    header('Location: registro.php?error=' . urlencode('Completa todos los campos del registro.'));
    exit;
}

if (!filter_var($Correo, FILTER_VALIDATE_EMAIL)) {
    header('Location: registro.php?error=' . urlencode('El correo no es válido.'));
    exit;
}

if (strlen($contra) < 6) {
    header('Location: registro.php?error=' . urlencode('La contraseña debe tener al menos 6 caracteres.'));
    exit;
}

if (!in_array($rol, ['estudiante', 'docente', 'directivo'], true)) {
    header('Location: registro.php?error=' . urlencode('Rol no válido.'));
    exit;
}

if (($rol === 'docente' || $rol === 'directivo') && (!isset($_POST['codigo']) || $_POST['codigo'] !== ($rol === 'docente' ? 'DOCENTE2024' : 'DIRECTIVO2024'))) {
    header('Location: registro.php?error=' . urlencode('Código de acceso incorrecto.'));
    exit;
}

$stmt = $con->prepare('SELECT Correo FROM registro WHERE Correo = ? LIMIT 1');
if (!$stmt) {
    header('Location: registro.php?error=' . urlencode('No se pudo verificar el correo.'));
    exit;
}
$stmt->bind_param('s', $Correo);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    header('Location: registro.php?error=' . urlencode('Ya existe una cuenta con ese correo.'));
    exit;
}

$hashPassword = password_hash($contra, PASSWORD_DEFAULT);

$insert = $con->prepare('INSERT INTO registro (Correo, contra, rol, Nombre) VALUES (?, ?, ?, ?)');
if (!$insert) {
    header('Location: registro.php?error=' . urlencode('No se pudo guardar el usuario.'));
    exit;
}

$insert->bind_param('ssss', $Correo, $hashPassword, $rol, $Nombre);
$insert->execute();

header('Location: registro.php?success=' . urlencode('Cuenta creada correctamente. Ya puedes iniciar sesión.'));
exit;

