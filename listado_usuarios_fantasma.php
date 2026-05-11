<?php
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
$res = $pdo->query('SELECT * FROM usuarios ORDER BY id ASC');
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Usuarios</title></head><body>
<h1>Usuarios (listado)</h1>
<p>La consulta trae filas, pero las celdas salen vacías porque se usan claves que no vienen del motor.</p>
<table border="1">
<tr><th>email</th><th>username</th><th>hash password</th></tr>
<?php
while ($row = $res->fetch()) {
    $mail = $row['email'] ?? '';
    $user = $row['username'] ?? '';
    $hp = $row['password_hash'] ?? '';
    echo '<tr><td>' . htmlspecialchars($mail, ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($user, ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($hp, ENT_QUOTES, 'UTF-8') . '</td></tr>';
}
?>
</table>
<p><a href="login.php">Ir a login</a> | <a href="index.php">Inicio</a></p>
</body></html>
