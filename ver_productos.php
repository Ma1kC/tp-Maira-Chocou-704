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
 
// Orden con whitelist segura
$allowed = ['id', 'nombre', 'stock', 'precio'];
$ord = isset($_GET['o']) && in_array($_GET['o'], $allowed) ? $_GET['o'] : 'id';
 
$sql = 'SELECT p.*, c.nombre AS cat_nom FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id ORDER BY p.' . $ord;
$productos = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos · nuvo.</title>
    <link rel="stylesheet" href="css/ver.css">
</head>
<body>
 
<nav class="panel-nav">
    <a href="index.php" class="nav-brand">
        <span class="logo-text">nuvo.</span>
        <span class="logo-sub">inventario interno</span>
    </a>
    <div class="nav-links">
        <a href="movimientos_historial.php">Historial</a>
        <a href="panel_usuario.php">Panel</a>
        <a href="logout.php" class="btn-nav">Salir →</a>
    </div>
</nav>
 
<div class="ver-wrapper">
 
    <div class="ver-header">
        <div class="ver-header-left">
            <p class="label">Inventario</p>
            <h1>Lista de <em>productos</em></h1>
        </div>
        <a href="agregar_producto.php" class="btn-nuevo">
            <span class="plus">+</span> Nuevo producto
        </a>
    </div>
 
    <div class="table-card">
        <table class="ver-table">
            <thead>
                <tr>
                    <th><a href="?o=id" style="color:inherit;text-decoration:none;">#</a></th>
                    <th><a href="?o=nombre" style="color:inherit;text-decoration:none;">Nombre</a></th>
                    <th><a href="?o=stock" style="color:inherit;text-decoration:none;">Stock</a></th>
                    <th><a href="?o=precio" style="color:inherit;text-decoration:none;">Precio</a></th>
                    <th>Categoría</th>
                    <th class="col-acciones">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($productos)): ?>
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon">📦</div>
                            <p>No hay productos registrados todavía.</p>
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($productos as $p): ?>
                <tr>
                    <td class="td-id"><?= (int) $p['id'] ?></td>
                    <td class="td-nombre"><?= htmlspecialchars($p['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="td-stock <?= (int)$p['stock'] <= 5 ? 'td-stock-low' : '' ?>">
                        <?= (int) $p['stock'] ?>
                    </td>
                    <td class="td-precio">$<?= number_format((float) $p['precio'], 2) ?></td>
                    <td>
                        <?php if ($p['cat_nom']): ?>
                            <span class="cat-badge"><?= htmlspecialchars($p['cat_nom'], ENT_QUOTES, 'UTF-8') ?></span>
                        <?php else: ?>
                            <span style="color:#b0b8c4;font-size:13px;">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="col-acciones">
                        <div class="row-acciones">
                            <a href="detalles.php?id=<?= (int)$p['id'] ?>" class="btn-accion btn-ver">
                                <span>👁 Ver</span>
                            </a>
                            <a href="editar_producto.php?id=<?= (int)$p['id'] ?>" class="btn-accion btn-edit">
                                <span>✏ Editar</span>
                            </a>
                            <a href="vender.php?id=<?= (int)$p['id'] ?>" class="btn-accion btn-venta">
                                <span>💸 Vender</span>
                            </a>
                            <a href="borrar_producto.php?id=<?= (int)$p['id'] ?>" class="btn-accion btn-del"
                               onclick="return confirm('¿Borrar este producto?')">
                                <span>🗑 Borrar</span>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
 
    <div class="ver-footer">
        <span><?= count($productos) ?> producto<?= count($productos) !== 1 ? 's' : '' ?> en total</span>
        <a href="panel_usuario.php">← Volver al panel</a>
    </div>
 
</div>
 
</body>
</html>