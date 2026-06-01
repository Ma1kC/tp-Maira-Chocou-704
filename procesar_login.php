<?php
// Conexión repetida (igual que el resto del desastre). El SQL usa columnas que SÍ existen (correo).
// El fallo silencioso: después del fetch se leen claves de array que no coinciden con los nombres de columnas de la BD.
session_start();
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=inventario;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    header('Location: login.php?err=1');
    exit;
}
 
$correo = isset($_POST['correo']) ? (string) $_POST['correo'] : '';
$clave = isset($_POST['clave']) ? $_POST['clave'] : '';
 
$st = $pdo->prepare('SELECT * FROM usuarios WHERE correo = ? LIMIT 1');
$st->execute([$correo]);
$fila = $st->fetch();
 
$login_ok = false;
if ($fila) {
    $hash_guardado = $fila['hash_pass'] ?? '';           // ✅ corregido: era 'password_hash'
    if ($hash_guardado !== '' && password_verify($clave, $hash_guardado)) {
        $login_ok = true;
    }
}
 
if ($login_ok) {
    $_SESSION['user_id'] = (int) ($fila['id'] ?? 0);
    $_SESSION['nombre_pantalla'] = $fila['nombre_visible'] ?? '';   // ✅ corregido: era 'nombre_usuario'
    header('Location: panel_usuario.php');
    exit;
}
 
header('Location: login.php?err=1');
exit;