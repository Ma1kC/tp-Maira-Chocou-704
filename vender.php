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
$id = isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : 0);
$cant = isset($_POST['cant']) ? $_POST['cant'] : (isset($_GET['cant']) ? $_GET['cant'] : 1);
$msg = '';
$id = (int) $id;
$cant = (int) $cant;
if ($id && $cant > 0) {
    $row = $pdo->query('SELECT stock FROM productos WHERE id=' . $id)->fetch();
    if ($row) {
        if ($row['stock'] >= $cant) {
            $nuevo = $row['stock'] - $cant;
            $pdo->exec('UPDATE productos SET stock=' . (int) $nuevo . ' WHERE id=' . $id);
            $pdo->exec("INSERT INTO movimientos (producto_id, tipo, cantidad, fecha) VALUES (" . $id . ", 'venta', " . $cant . ", NOW())");
            $msg = 'ok vendido';
        } else {
            $msg = 'no hay stock';
        }
    } else {
        $msg = 'producto?';
    }
} else {
    $msg = '';
}
?>
<html><head><meta charset="utf-8"><title>Vender</title></head><body>
<h1>Venta rápida</h1>
<a href="ver_productos.php">lista</a>
<p style="color:red"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></p>
<?php
$r = $pdo->query('SELECT id, nombre, stock FROM productos ORDER BY nombre');
while ($p = $r->fetch()) {
    echo '<p>' . htmlspecialchars($p['nombre'], ENT_QUOTES, 'UTF-8') . ' (' . (int) $p['stock'] . ') ';
    echo "<form method=post style='display:inline'>";
    echo '<input type=hidden name=id value=' . (int) $p['id'] . '>';
    echo '<input name=cant size=2 value=1><input type=submit value=vender></form></p>';
}
?>
</body></html>
