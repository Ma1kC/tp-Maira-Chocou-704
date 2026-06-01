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
 
$toast = null;
 
// Procesar venta
$id   = (int) (isset($_POST['id'])   ? $_POST['id']   : (isset($_GET['id'])   ? $_GET['id']   : 0));
$cant = (int) (isset($_POST['cant']) ? $_POST['cant'] : (isset($_GET['cant']) ? $_GET['cant'] : 1));
 
if ($id && $cant > 0) {
    $st = $pdo->prepare('SELECT nombre, stock FROM productos WHERE id = ?');
    $st->execute([$id]);
    $row = $st->fetch();
 
    if ($row) {
        if ($row['stock'] >= $cant) {
            $nuevo = $row['stock'] - $cant;
            $pdo->prepare('UPDATE productos SET stock = ? WHERE id = ?')->execute([$nuevo, $id]);
            $pdo->prepare("INSERT INTO movimientos (producto_id, tipo, cantidad, fecha) VALUES (?, 'venta', ?, NOW())")->execute([$id, $cant]);
            $toast = ['tipo' => 'success', 'icono' => '✅', 'texto' => 'Venta registrada: ' . $cant . ' × ' . htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8')];
        } else {
            $toast = ['tipo' => 'error', 'icono' => '⚠️', 'texto' => 'Stock insuficiente para "' . htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8') . '" (disponible: ' . (int) $row['stock'] . ')'];
        }
    } else {
        $toast = ['tipo' => 'error', 'icono' => '❌', 'texto' => 'Producto no encontrado.'];
    }
}
 
// Listar todos los productos
$productos = $pdo->query('SELECT id, nombre, stock FROM productos ORDER BY nombre')->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Venta rápida · nuvo.</title>
    <link rel="stylesheet" href="css/vender.css">
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
 
<div class="vender-wrapper">
 
    <div class="vender-header">
        <p class="label">Inventario</p>
        <h1>Venta <em>rápida</em></h1>
    </div>
 
    <?php if ($toast): ?>
        <div class="toast <?= $toast['tipo'] ?>">
            <span class="toast-icon"><?= $toast['icono'] ?></span>
            <span><?= $toast['texto'] ?></span>
        </div>
    <?php endif; ?>
 
    <div class="productos-card">
        <?php if (empty($productos)): ?>
            <div style="text-align:center;padding:48px 24px;color:#66758d;">
                <div style="font-size:36px;margin-bottom:12px;">📦</div>
                <p>No hay productos cargados.</p>
            </div>
        <?php else: ?>
            <?php foreach ($productos as $p):
                $sinStock = (int) $p['stock'] === 0;
                $stockLow = !$sinStock && (int) $p['stock'] <= 5;
            ?>
            <div class="prod-row">
                <div class="prod-info">
                    <div class="prod-nombre"><?= htmlspecialchars($p['nombre'], ENT_QUOTES, 'UTF-8') ?></div>
                    <div class="prod-stock <?= $sinStock ? 'sin-stock' : ($stockLow ? 'stock-low' : '') ?>">
                        <?php if ($sinStock): ?>
                            Sin stock
                        <?php elseif ($stockLow): ?>
                            ⚠ Solo <?= (int) $p['stock'] ?> unidades
                        <?php else: ?>
                            <?= (int) $p['stock'] ?> en stock
                        <?php endif; ?>
                    </div>
                </div>
                <form method="post" class="prod-form">
                    <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                    <input class="cant-input" type="number" name="cant" value="1" min="1"
                           max="<?= (int) $p['stock'] ?>" <?= $sinStock ? 'disabled' : '' ?>>
                    <button type="submit" class="btn-vender" <?= $sinStock ? 'disabled' : '' ?>>
                        💸 Vender
                    </button>
                </form>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
 
    <div class="vender-footer">
        <span><?= count($productos) ?> producto<?= count($productos) !== 1 ? 's' : '' ?></span>
        <a href="ver_productos.php">← Volver a productos</a>
    </div>
 
</div>
 
</body>
</html>