<?php
// Panel "protegido": comprueba variables de sesión que procesar_login.php nunca define con estos nombres.
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=inventario;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die('no conecta');
}

$id = (int) $_SESSION['usuario_id'];
$st = $pdo->prepare('SELECT * FROM usuarios WHERE id = ? LIMIT 1');
$st->execute([$id]);
$u = $st->fetch() ?: [];

$etiqueta = $u['nombre_completo'] ?? ($u['display_name'] ?? 'Usuario');
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Panel</title></head><body>
<h1>Panel</h1>
<p>Hola, <?php echo htmlspecialchars($etiqueta, ENT_QUOTES, 'UTF-8'); ?></p>
<p><a href="index.php">Inventario</a> | <a href="logout.php">Salir</a></p>
</body></html>
