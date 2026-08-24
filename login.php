<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registro.php');
    exit;
}

$correo = trim($_POST['Correo'] ?? '');
$contrasena = trim($_POST['contra'] ?? '');
$rol = trim($_POST['rol'] ?? '');

if ($correo === '' || $contrasena === '' || $rol === '') {
    header('Location: registro.php?error=' . urlencode('Completa correo, contraseña y rol.'));
    exit;
}

$stmt = $con->prepare('SELECT id, Nombre, Correo, contra, rol FROM registro WHERE Correo = ? AND rol = ? LIMIT 1');
if (!$stmt) {
    header('Location: registro.php?error=' . urlencode('No se pudo validar la cuenta.'));
    exit;
}

$stmt->bind_param('ss', $correo, $rol);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!$usuario || !password_verify($contrasena, $usuario['contra'])) {
    header('Location: registro.php?error=' . urlencode('Correo, contraseña o rol incorrectos.'));
    exit;
}

$_SESSION['usuario_id'] = (int) $usuario['id'];
$_SESSION['usuario_nombre'] = $usuario['Nombre'];
$_SESSION['usuario_rol'] = $usuario['rol'];

header('Location: ' . $usuario['rol'] . '.php');
exit;
