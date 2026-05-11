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
if (isset($_GET['si']) && $_GET['si'] == '1' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $pdo->exec('DELETE FROM movimientos WHERE producto_id=' . $id);
    $pdo->exec('DELETE FROM productos WHERE id=' . $id);
    header('Location: ver_productos.php');
    exit;
}
$id = (int) ($_GET['id'] ?? 0);
$x = $pdo->query('SELECT nombre FROM productos WHERE id=' . $id)->fetch();
$nom = $x ? $x['nombre'] : '';
?>
<html><head><meta charset="utf-8"><title>Borrar</title></head><body>
<h1>Borrar producto</h1>
<p>Seguro: <?php echo htmlspecialchars($nom, ENT_QUOTES, 'UTF-8'); ?> (id <?php echo $id; ?>)</p>
<a href="ver_productos.php">cancelar</a> |
<a href="borrar_producto.php?id=<?php echo $id; ?>&si=1">SI BORRAR</a>
</body></html>
