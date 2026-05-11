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
if (isset($_POST['guardar'])) {
    $n = $_POST['nombre'];
    $s = $_POST['stock'];
    $pr = $_POST['precio'];
    $cid = $_POST['categoria_id'];
    $nota = $_POST['nota'];
    $sql = 'INSERT INTO productos (nombre, stock, precio, categoria_id, nota) VALUES ('
        . $pdo->quote($n) . ', '
        . $pdo->quote($s) . ', '
        . $pdo->quote($pr) . ', '
        . ($cid ? (int) $cid : 'NULL') . ', '
        . $pdo->quote($nota)
        . ')';
    $pdo->exec($sql);
    header('Location: ver_productos.php');
    exit;
}
$cats = $pdo->query('SELECT id, nombre FROM categorias');
?>
<html><head><meta charset="utf-8"><title>Nuevo</title></head><body>
<h1>Nuevo producto</h1>
<form method="post">
nombre: <input name="nombre"><br>
stock: <input name="stock" value="0"><br>
precio: <input name="precio" value="0"><br>
cat: <select name="categoria_id"><option value="">--</option>
<?php while ($c = $cats->fetch()) {
    echo '<option value=' . (int) $c['id'] . '>' . htmlspecialchars($c['nombre'], ENT_QUOTES, 'UTF-8') . '</option>';
} ?>
</select><br>
nota: <textarea name="nota"></textarea><br>
<input type="submit" name="guardar" value="guardar">
</form>
<a href="index.php">inicio</a>
</body></html>
