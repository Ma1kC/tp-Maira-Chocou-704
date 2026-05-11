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
$term = isset($_GET['q']) ? $_GET['q'] : '';
$res = null;
if ($term !== '') {
    $like = '%' . $term . '%';
    $st = $pdo->prepare('SELECT id, nombre, stock, precio FROM productos WHERE nombre LIKE ? OR nota LIKE ?');
    $st->execute([$like, $like]);
    $res = $st;
}
?>
<html><head><meta charset="utf-8"><title>Buscar</title></head><body>
<h1>Buscar</h1>
<form method="get"><input name="q" value="<?php echo htmlspecialchars($term, ENT_QUOTES, 'UTF-8'); ?>"> <input type="submit" value="buscar"></form>
<?php
if ($res) {
    echo '<table border=1><tr><th>id</th><th>nombre</th><th>stock</th></tr>';
    while ($row = $res->fetch()) {
        echo '<tr><td>' . (int) $row['id'] . '</td><td><a href=detalles.php?id=' . (int) $row['id'] . '>'
            . htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8') . '</a></td><td>' . (int) $row['stock'] . '</td></tr>';
    }
    echo '</table>';
}
?>
<a href="index.php">inicio</a>
</body></html>
