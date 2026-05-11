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
if (isset($_POST['nueva_cat']) && $_POST['nueva_cat'] !== '') {
    $pdo->exec('INSERT INTO categorias (nombre) VALUES (' . $pdo->quote($_POST['nueva_cat']) . ')');
}
$r = $pdo->query('SELECT c.id, c.nombre, COUNT(p.id) AS cnt FROM categorias c LEFT JOIN productos p ON p.categoria_id = c.id GROUP BY c.id, c.nombre');
?>
<html><head><meta charset="utf-8"><title>Cats</title></head><body>
<h1>Categorías</h1>
<form method="post">
<input name="nueva_cat" placeholder="nombre categoria">
<input type="submit" value="crear">
</form>
<table border="1">
<?php
while ($c = $r->fetch()) {
    echo '<tr><td>' . (int) $c['id'] . '</td><td>' . htmlspecialchars($c['nombre'], ENT_QUOTES, 'UTF-8') . '</td><td>' . (int) $c['cnt'] . ' prods</td></tr>';
}
?>
</table>
<a href="agregar_producto.php">productos</a> | <a href="index.php">inicio</a>
</body></html>
