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
 
// Guardar cambios
$msg = '';
if (isset($_POST['ok'])) {
    $n   = trim($_POST['nombre'] ?? '');
    $s   = (int)   ($_POST['stock']       ?? 0);
    $pr  = (float) ($_POST['precio']      ?? 0);
    $cid = (int)   ($_POST['categoria_id'] ?? 0);
 
    if ($n === '') {
        $msg = '<div class="form-msg error">El nombre no puede estar vacío.</div>';
    } else {
        $st = $pdo->prepare('UPDATE productos SET nombre=?, stock=?, precio=?, categoria_id=? WHERE id=?');
        $st->execute([$n, $s, $pr, $cid ?: null, $id]);
        header('Location: detalles.php?id=' . $id);
        exit;
    }
}
 
// Cargar producto
$st = $pdo->prepare('SELECT * FROM productos WHERE id = ?');
$st->execute([$id]);
$p = $st->fetch();
 
if (!$p) {
    header('Location: ver_productos.php');
    exit;
}
 
$cats = $pdo->query('SELECT id, nombre FROM categorias ORDER BY nombre')->fetchAll();
$nombre = htmlspecialchars($p['nombre'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar · <?= $nombre ?> · nuvo.</title>
    <link rel="stylesheet" href="css/editar.css">
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
 
<div class="edit-wrapper">
 
    <div class="breadcrumb">
        <a href="ver_productos.php">Productos</a>
        <span class="sep">›</span>
        <a href="detalles.php?id=<?= $id ?>"><?= $nombre ?></a>
        <span class="sep">›</span>
        <span>Editar</span>
    </div>
 
    <div class="edit-card">
 
        <div class="edit-header">
            <p class="label">Editando producto #<?= $id ?></p>
            <h1>Modificar <em><?= $nombre ?></em></h1>
        </div>
 
        <?= $msg ?>
 
        <form method="post" class="form-grid">
 
            <div class="field">
                <label for="nombre">Nombre</label>
                <input id="nombre" name="nombre" type="text"
                       value="<?= $nombre ?>" autocomplete="off">
            </div>
 
            <div class="row-2">
                <div class="field">
                    <label for="stock">Stock</label>
                    <input id="stock" name="stock" type="number" min="0"
                           value="<?= (int) $p['stock'] ?>">
                </div>
                <div class="field">
                    <label for="precio">Precio ($)</label>
                    <input id="precio" name="precio" type="number" step="0.01" min="0"
                           value="<?= number_format((float) $p['precio'], 2, '.', '') ?>">
                </div>
            </div>
 
            <div class="field">
                <label for="categoria_id">Categoría</label>
                <select id="categoria_id" name="categoria_id">
                    <option value="">— Sin categoría —</option>
                    <?php foreach ($cats as $c): ?>
                        <option value="<?= (int) $c['id'] ?>"
                            <?= (isset($p['categoria_id']) && $p['categoria_id'] == $c['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['nombre'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
 
            <div class="form-divider"></div>
 
            <div class="form-actions">
                <a href="detalles.php?id=<?= $id ?>" class="btn-cancelar">Cancelar</a>
                <button type="submit" name="ok" class="btn-guardar">Guardar cambios</button>
            </div>
 
        </form>
    </div>
 
</div>
 
</body>
</html>