<?php
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=inventario;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die('Error DB');
}
 
$id = (int) ($_GET['id'] ?? 0);
$st = $pdo->prepare('SELECT p.*, c.nombre AS cat_nom FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE p.id = ?');
$st->execute([$id]);
$prod = $st->fetch();
 
if (!$prod) {
    header('Location: ver_productos.php');
    exit;
}
 
$nombre   = htmlspecialchars($prod['nombre'], ENT_QUOTES, 'UTF-8');
$cat      = $prod['cat_nom'] ? htmlspecialchars($prod['cat_nom'], ENT_QUOTES, 'UTF-8') : null;
$nota     = trim((string) $prod['nota']);
$stockLow = (int) $prod['stock'] <= 5;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $nombre ?> · nuvo.</title>
    <link rel="stylesheet" href="css/detalles.css">
</head>
<body>
 
<nav class="panel-nav">
    <a href="index.php" class="nav-brand">
        <span class="logo-text">nuvo.</span>
        <span class="logo-sub">inventario interno</span>
    </a>
    <div class="nav-links">
        <a href="ver_productos.php">Productos</a>
        <a href="panel_usuario.php">Panel</a>
        <a href="logout.php" class="btn-nav">Salir →</a>
    </div>
</nav>
 
<div class="det-wrapper">
 
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="ver_productos.php">Productos</a>
        <span class="sep">›</span>
        <span><?= $nombre ?></span>
    </div>
 
    <!-- Card principal -->
    <div class="det-card">
 
        <!-- Nombre + categoría -->
        <div class="det-card-header">
            <div class="det-card-header-left">
                <div class="det-id">Producto #<?= (int) $prod['id'] ?></div>
                <h1><em><?= $nombre ?></em></h1>
            </div>
            <?php if ($cat): ?>
                <span class="cat-badge"><?= $cat ?></span>
            <?php endif; ?>
        </div>
 
        <!-- Stats: stock y precio -->
        <div class="det-stats">
            <div class="det-stat">
                <span class="stat-label">Stock disponible</span>
                <span class="stat-value <?= $stockLow ? 'stock-low' : '' ?>"><?= (int) $prod['stock'] ?></span>
                <?php if ($stockLow): ?>
                    <span class="stat-sub" style="color:#c0392b;">⚠ Stock bajo</span>
                <?php else: ?>
                    <span class="stat-sub">unidades</span>
                <?php endif; ?>
            </div>
            <div class="det-stat">
                <span class="stat-label">Precio unitario</span>
                <span class="stat-value">$<?= number_format((float) $prod['precio'], 2) ?></span>
                <span class="stat-sub">por unidad</span>
            </div>
        </div>
 
        <!-- Nota -->
        <div class="det-nota">
            <div class="nota-label">Nota</div>
            <?php if ($nota !== ''): ?>
                <div class="nota-text"><?= htmlspecialchars($nota, ENT_QUOTES, 'UTF-8') ?></div>
            <?php else: ?>
                <span class="nota-empty">Sin notas registradas.</span>
            <?php endif; ?>
        </div>
 
        <!-- Vender desde el detalle -->
        <div class="det-vender">
            <div class="vender-label">Registrar venta</div>
            <form method="get" action="vender.php" class="vender-form">
                <input type="hidden" name="id" value="<?= (int) $prod['id'] ?>">
                <div class="vender-input-wrap">
                    <label for="cant">Cantidad</label>
                    <input id="cant" name="cant" type="number" value="1" min="1" max="<?= (int) $prod['stock'] ?>">
                </div>
                <button type="submit" class="btn-vender">💸 Ir a vender</button>
            </form>
        </div>
 
    </div>
 
    <!-- Acciones -->
    <div class="det-actions">
        <a href="editar_producto.php?id=<?= (int) $prod['id'] ?>" class="btn-accion btn-edit">✏ Editar</a>
        <a href="borrar_producto.php?id=<?= (int) $prod['id'] ?>" class="btn-accion btn-del"
           onclick="return confirm('¿Borrar <?= addslashes($nombre) ?>?')">🗑 Borrar</a>
        <a href="ver_productos.php" class="btn-accion btn-back">← Volver</a>
    </div>
 
</div>
 
</body>
</html>