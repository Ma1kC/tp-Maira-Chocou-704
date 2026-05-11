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
$pag = isset($_GET['p']) ? (int) $_GET['p'] : 0;
$off = $pag * 20;
$sql = 'SELECT m.*, p.nombre AS nomprod FROM movimientos m JOIN productos p ON p.id = m.producto_id ORDER BY m.id DESC LIMIT 20 OFFSET ' . (int) $off;
$r = $pdo->query($sql);
?>
<html><head><meta charset="utf-8"><title>Movs</title></head><body>
<h1>Historial movimientos</h1>
<table border="1">
<tr><th>id</th><th>prod</th><th>tipo</th><th>cant</th><th>fecha</th></tr>
<?php
while ($m = $r->fetch()) {
    echo '<tr><td>' . (int) $m['id'] . '</td><td>' . htmlspecialchars($m['nomprod'], ENT_QUOTES, 'UTF-8') . '</td><td>'
        . htmlspecialchars($m['tipo'], ENT_QUOTES, 'UTF-8') . '</td><td>' . (int) $m['cantidad'] . '</td><td>'
        . htmlspecialchars((string) $m['fecha'], ENT_QUOTES, 'UTF-8') . '</td></tr>';
}
?>
</table>
<?php if ($pag > 0) {
    echo "<a href='?p=" . ($pag - 1) . "'>anterior</a> ";
} ?>
<a href="?p=<?php echo $pag + 1; ?>">siguiente</a>
<br><a href="index.php">inicio</a>
</body></html>
