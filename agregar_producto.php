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
 
$msg = '';
if (isset($_POST['guardar'])) {
    $n    = trim($_POST['nombre'] ?? '');
    $s    = (int)   ($_POST['stock']        ?? 0);
    $pr   = (float) ($_POST['precio']       ?? 0);
    $cid  = (int)   ($_POST['categoria_id'] ?? 0);
    $nota = trim($_POST['nota'] ?? '');
 
    if ($n === '') {
        $msg = '<div class="form-msg error">El nombre del producto es obligatorio.</div>';
    } else {
        $st = $pdo->prepare('INSERT INTO productos (nombre, stock, precio, categoria_id, nota) VALUES (?, ?, ?, ?, ?)');
        $st->execute([$n, $s, $pr, $cid ?: null, $nota ?: null]);
        header('Location: ver_productos.php');
        exit;
    }
}
 
$cats = $pdo->query('SELECT id, nombre FROM categorias ORDER BY nombre')->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo producto · nuvo.</title>
    <link rel="stylesheet" href="css/agregar.css">
</head>
<body>
 
<nav class="panel-nav">
    <a href="index.html" class="nav-brand">
        <span class="logo-text">nuvo.</span>
        <span class="logo-sub">inventario interno</span>
    </a>
    <div class="nav-links">
        <a href="ver_productos.php">Productos</a>
        <a href="panel_usuario.php">Panel</a>
        <a href="logout.php" class="btn-nav">Salir →</a>
    </div>
</nav>
 
<div class="agregar-wrapper">
    <div class="form-card">
 
        <div class="form-header">
            <p class="label">Inventario</p>
            <h1>Nuevo <em>producto</em></h1>
        </div>
 
        <?= $msg ?>
 
        <form method="post" class="form-grid">
 
            <div class="field">
                <label for="nombre">Nombre</label>
                <input id="nombre" name="nombre" type="text" placeholder="Ej: Cable USB-C 1m" autocomplete="off">
            </div>
 
            <div class="row-2">
                <div class="field">
                    <label for="stock">Stock inicial</label>
                    <input id="stock" name="stock" type="number" value="0" min="0">
                </div>
                <div class="field">
                    <label for="precio">Precio ($)</label>
                    <input id="precio" name="precio" type="number" step="0.01" value="0.00" min="0">
                </div>
            </div>
 
            <div class="field">
                <label for="categoria_id">Categoría</label>
                <select id="categoria_id" name="categoria_id">
                    <option value="">— Sin categoría —</option>
                    <?php foreach ($cats as $c): ?>
                        <option value="<?= (int) $c['id'] ?>"><?= htmlspecialchars($c['nombre'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
 
            <div class="field">
                <label for="nota">Nota <span style="font-weight:400;color:#66758d">(opcional)</span></label>
                <textarea id="nota" name="nota" placeholder="Ej: Oferta especial, requiere frío..."></textarea>
            </div>
 
            <button type="submit" name="guardar" class="btn-guardar">Guardar producto</button>
 
        </form>
 
        <div class="form-footer">
            <a href="ver_productos.php">← Ver productos</a>
            <a href="panel_usuario.php">Panel</a>
        </div>
 
    </div>
</div>
 
</body>
</html>
