<?php
// sistema inventario - inicio (todo en un archivo como manda el caos)
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=inventario;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die('no conecta');
}
$row = $pdo->query('SELECT COUNT(*) AS c FROM productos')->fetch();
$total = $row['c'];
$r2 = $pdo->query('SELECT SUM(stock) AS s FROM productos')->fetch();
$s = $r2['s'] ? $r2['s'] : 0;
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Inventario</title></head><body>
<h1>Inventario v1</h1>
<p>Productos: <?php echo $total; ?> | Stock total aprox: <?php echo $s; ?></p>
<ul>
<li><a href="login.php">Login (ejercicio campos / sesión)</a></li>
<li><a href="listado_usuarios_fantasma.php">Listado usuarios (celdas vacías)</a></li>
<li><a href="ver_productos.php">Ver productos</a></li>
<li><a href="buscar.php">Buscar</a></li>
<li><a href="agregar_producto.php">Agregar</a></li>
<li><a href="movimientos_historial.php">Movimientos</a></li>
<li><a href="categorias_listado.php">Categorías</a></li>
</ul>
</body></html>
