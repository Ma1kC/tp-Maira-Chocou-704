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
// orden por get sin whitelist = lio luego al refactorizar
$ord = isset($_GET['o']) ? $_GET['o'] : 'id';
$sql = 'SELECT p.*, c.nombre AS cat_nom FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id ORDER BY ' . $ord;
$res = $pdo->query($sql);
?>
<html><head><meta charset="utf-8"><title>Lista</title></head><body>
<h1>Productos</h1>
<a href="index.php">inicio</a> | <a href="agregar_producto.php">nuevo</a>
<table border="1">
<tr><th>id</th><th>nombre</th><th>stock</th><th>precio</th><th>cat</th><th></th></tr>
<?php
while ($p = $res->fetch()) {
    echo '<tr>';
    echo '<td>' . $p['id'] . '</td>';
    echo '<td>' . $p['nombre'] . '</td>';
    echo '<td>' . $p['stock'] . '</td>';
    echo '<td>' . $p['precio'] . '</td>';
    echo '<td>' . ($p['cat_nom'] ? $p['cat_nom'] : '-') . '</td>';
    echo '<td><a href="detalles.php?id=' . $p['id'] . '">ver</a> ';
    echo '<a href="editar_producto.php?id=' . $p['id'] . '">edit</a> ';
    echo '<a href="vender.php?id=' . $p['id'] . '">vender</a> ';
    echo '<a href="borrar_producto.php?id=' . $p['id'] . '">borrar</a></td>';
    echo '</tr>';
}
?>
</table>
</body></html>
