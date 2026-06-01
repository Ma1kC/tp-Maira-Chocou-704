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
 
$pag = isset($_GET['p']) ? max(0, (int) $_GET['p']) : 0;
$off = $pag * 20;
$sql = 'SELECT m.*, p.nombre AS nomprod FROM movimientos m JOIN productos p ON p.id = m.producto_id ORDER BY m.id DESC LIMIT 20 OFFSET ' . $off;
$rows = $pdo->query($sql)->fetchAll();
 
// Badge por tipo
function badge(string $tipo): string {
    $tipo = strtolower(trim($tipo));
    $map = [
        'alta'  => ['label' => 'Alta',  'class' => 'badge-alta'],
        'venta' => ['label' => 'Venta', 'class' => 'badge-venta'],
        'baja'  => ['label' => 'Baja',  'class' => 'badge-baja'],
    ];
    $b = $map[$tipo] ?? ['label' => ucfirst($tipo), 'class' => 'badge-alta'];
    return '<span class="badge ' . $b['class'] . '">' . $b['label'] . '</span>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial · nuvo.</title>
    <link rel="stylesheet" href="css/movs.css">
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
 
<div class="movs-wrapper">
 
    <div class="movs-header">
        <p class="label">Inventario</p>
        <h1>Historial de <em>movimientos</em></h1>
    </div>
 
    <div class="table-card">
        <table class="movs-table">
            <thead>
                <tr>
                    <th class="col-id">#</th>
                    <th>Producto</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($rows)): ?>
                <tr><td colspan="5" style="text-align:center;padding:40px;color:#66758d;">Sin movimientos registrados.</td></tr>
            <?php else: ?>
                <?php foreach ($rows as $m): ?>
                <tr>
                    <td class="td-id col-id"><?= (int) $m['id'] ?></td>
                    <td class="td-prod"><?= htmlspecialchars($m['nomprod'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= badge($m['tipo']) ?></td>
                    <td class="td-cant"><?= (int) $m['cantidad'] ?></td>
                    <td class="td-fecha"><?= htmlspecialchars((string) $m['fecha'], ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
 
    <!-- Paginación -->
    <div class="pagination">
        <?php if ($pag > 0): ?>
            <a href="?p=<?= $pag - 1 ?>">← Anterior</a>
        <?php else: ?>
            <span></span>
        <?php endif; ?>
 
        <span class="spacer"></span>
 
        <?php if (count($rows) === 20): ?>
            <a href="?p=<?= $pag + 1 ?>" class="btn-primary">Siguiente →</a>
        <?php endif; ?>
    </div>
 
    <div class="movs-footer">
        <span>nuvo. inventario interno</span>
        <a href="panel_usuario.php">← Volver al panel</a>
    </div>
 
</div>
 
</body>
</html>