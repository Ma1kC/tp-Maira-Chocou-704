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
if (isset($_POST['ok'])) {
    $n = $_POST['nombre'];
    $s = $_POST['stock'];
    $pr = $_POST['precio'];
    $cid = $_POST['categoria_id'];
    $sql = 'UPDATE productos SET nombre=' . $pdo->quote($n) . ', stock=' . (int) $s . ', precio=' . (float) $pr
        . ', categoria_id=' . ($cid ? (int) $cid : 'NULL') . ' WHERE id=' . $id;
    $pdo->exec($sql);
    header('Location: detalles.php?id=' . $id);
    exit;
}
$p = $pdo->query('SELECT * FROM productos WHERE id=' . $id)->fetch();
if (!$p) {
    die('no existe');
}
$cats = $pdo->query('SELECT id, nombre FROM categorias');
?>
<html><head><meta charset="utf-8"><title>Editar</title></head><body>
<h1>Editar #<?php echo $id; ?></h1>
<form method="post">
<input type="hidden" name="x" value="1">
nombre <input name="nombre" value="<?php echo htmlspecialchars($p['nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"><br>
stock <input name="stock" value="<?php echo htmlspecialchars((string) ($p['stock'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"><br>
precio <input name="precio" value="<?php echo htmlspecialchars((string) ($p['precio'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"><br>
<select name="categoria_id">
<?php
while ($c = $cats->fetch()) {
    $sel = (isset($p['categoria_id']) && $p['categoria_id'] == $c['id']) ? ' selected' : '';
    echo '<option value=' . (int) $c['id'] . $sel . '>' . htmlspecialchars($c['nombre'], ENT_QUOTES, 'UTF-8') . '</option>';
}
?>
</select><br>
<input type="submit" name="ok" value="Guardar">
</form>
<a href="ver_productos.php">volver</a>
</body></html>
