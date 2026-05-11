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
$sql = 'SELECT * FROM productos WHERE id = ' . $id;
$prod = $pdo->query($sql)->fetch();
if (!$prod) {
    echo 'no existe';
    exit;
}
$cat = null;
if ($prod['categoria_id']) {
    $st = $pdo->prepare('SELECT nombre FROM categorias WHERE id = ?');
    $st->execute([(int) $prod['categoria_id']]);
    $cat = $st->fetch();
}
?>
<html><head><meta charset="utf-8"><title>Detalle</title></head><body>
<h1><?php echo htmlspecialchars($prod['nombre'], ENT_QUOTES, 'UTF-8'); ?></h1>
<a href="ver_productos.php">volver</a>
<p>ID: <?php echo (int) $prod['id']; ?></p>
<p>Stock: <?php echo (int) $prod['stock']; ?></p>
<p>Precio: <?php echo htmlspecialchars((string) $prod['precio'], ENT_QUOTES, 'UTF-8'); ?></p>
<p>Categoría: <?php echo $cat ? htmlspecialchars($cat['nombre'], ENT_QUOTES, 'UTF-8') : 'ninguna'; ?></p>
<p>Nota: <?php echo htmlspecialchars((string) $prod['nota'], ENT_QUOTES, 'UTF-8'); ?></p>
<form action="vender.php" method="get">
<input type="hidden" name="id" value="<?php echo (int) $prod['id']; ?>">
cant: <input name="cant" value="1" size="3">
<input type="submit" value="ir a vender">
</form>
</body></html>
