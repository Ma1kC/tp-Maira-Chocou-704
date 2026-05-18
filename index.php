<?php
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=inventario;charset=utf8mb4',
        'root',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die('No conecta');
}

$row = $pdo->query('SELECT COUNT(*) AS c FROM productos')->fetch();
$total = $row['c'];

$r2 = $pdo->query('SELECT SUM(stock) AS s FROM productos')->fetch();
$s = $r2['s'] ? $r2['s'] : 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Inventario</title>

    <link rel="stylesheet" href="css/style.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@1,700&display=swap" rel="stylesheet">
</head>

<body>

    <header class="navbar">
        <div class="logo">nuvo.</div>

        <nav>
            <a href="#">Limpieza</a>
            <a href="#">Papelería</a>
            <a href="#">Tecnología</a>
            <a href="#">Sobre nosotros</a>
        </nav>

        <div class="icons">
            <span>⌕</span>
            <span>🛒</span>
        </div>
    </header>

    <main class="hero">

        <p class="collection">COLECCIÓN 2026</p>

        <h1>
            Lo esencial,<br>
            <span>bien pensado.</span>
        </h1>

        <p class="description">
            Una selección curada de productos de limpieza,
            papelería y tecnología. Diseño honesto,
            materiales nobles, precios justos.
        </p>

        <div class="buttons">
            <a href="ver_productos.php" class="btn-primary">
                Explorar productos
            </a>

            <a href="#" class="btn-secondary">
                Cómo compramos →
            </a>
        </div>

        <div class="stats">
            <div class="card">
                <h3><?php echo $total; ?></h3>
                <p>Productos</p>
            </div>

            <div class="card">
                <h3><?php echo $s; ?></h3>
                <p>Stock total</p>
            </div>
        </div>

    </main>

</body>
</html>