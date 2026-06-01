<?php
session_start();
if (!isset($_SESSION['user_id'])) {
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
 
// Datos del usuario
$id = (int) $_SESSION['user_id'];
$st = $pdo->prepare('SELECT * FROM usuarios WHERE id = ? LIMIT 1');
$st->execute([$id]);
$u = $st->fetch() ?: [];
$nombre = htmlspecialchars($u['nombre_visible'] ?? $_SESSION['nombre_pantalla'] ?? 'Usuario', ENT_QUOTES, 'UTF-8');
 
// Stats rápidas
$total_productos  = $pdo->query('SELECT COUNT(*) FROM productos')->fetchColumn();
$total_stock      = $pdo->query('SELECT COALESCE(SUM(stock),0) FROM productos')->fetchColumn();
$total_categorias = $pdo->query('SELECT COUNT(*) FROM categorias')->fetchColumn();
$total_mov        = $pdo->query('SELECT COUNT(*) FROM movimientos')->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel · nuvo.</title>
    <link rel="stylesheet" href="css/panel.css">
</head>
<body>
 
<!-- Navbar -->
<nav class="panel-nav">
    <a href="index.html" class="nav-brand">
        <span class="logo-text">nuvo.</span>
        <span class="logo-sub">inventario interno</span>
    </a>
    <div class="nav-links">
        <a href="ver_productos.php">Productos</a>
        <a href="buscar.php">Buscar</a>
        <a href="logout.php" class="btn-logout">Salir →</a>
    </div>
</nav>
 
<!-- Contenido -->
<div class="panel-wrapper">
 
    <!-- Saludo -->
    <div class="panel-hello">
        <p class="greeting">Panel de usuario</p>
        <h1>Hola, <em><?= $nombre ?>.</em></h1>
    </div>
 
    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-label">Productos</div>
            <div class="stat-value"><?= $total_productos ?></div>
            <div class="stat-sub">en el sistema</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🗂️</div>
            <div class="stat-label">Unidades en stock</div>
            <div class="stat-value"><?= number_format($total_stock) ?></div>
            <div class="stat-sub">total acumulado</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🏷️</div>
            <div class="stat-label">Categorías</div>
            <div class="stat-value"><?= $total_categorias ?></div>
            <div class="stat-sub">activas</div>
        </div>
    </div>
 
    <!-- Accesos rápidos -->
    <div class="actions-section">
        <p class="section-title">Accesos rápidos</p>
        <div class="actions-grid">
            <a href="ver_productos.php" class="action-card">
                <div class="action-icon">📋</div>
                <div class="action-info">
                    <span class="action-name">Ver productos</span>
                    <span class="action-desc">Listado completo del inventario</span>
                </div>
            </a>
            <a href="agregar_producto.php" class="action-card">
                <div class="action-icon">➕</div>
                <div class="action-info">
                    <span class="action-name">Agregar producto</span>
                    <span class="action-desc">Registrar un artículo nuevo</span>
                </div>
            </a>
            <a href="buscar.php" class="action-card">
                <div class="action-icon">🔍</div>
                <div class="action-info">
                    <span class="action-name">Buscar</span>
                    <span class="action-desc">Encontrá un producto rápido</span>
                </div>
            </a>
            <a href="movimientos_historial.php" class="action-card">
                <div class="action-icon">📈</div>
                <div class="action-info">
                    <span class="action-name">Historial</span>
                    <span class="action-desc"><?= $total_mov ?> movimientos registrados</span>
                </div>
            </a>
        </div>
    </div>
 
    <!-- Footer -->
    <div class="panel-footer">
        <span>nuvo. inventario interno</span>
        <a href="index.php">← Volver al inicio</a>
    </div>
 
</div>
 
</body>
</html>
