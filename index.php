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
        <a href="#limpieza">Limpieza</a>
        <a href="#papeleria">Papelería</a>
        <a href="#tecnologia">Tecnología</a>
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

```html
<section class="catalog-section cleaning" id="limpieza">

    <div class="category-image">
        <span class="badge">✦ CUIDAR EL ESPACIO</span>
        <img src="img/cat-cleaning.jpg" alt="">
    </div>

    <div class="category-products">

        <h2>Limpieza</h2>

        <p>
            Selección curada de productos pensados para tu día a día.
            Calidad y diseño en cada detalle.
        </p>

        <div class="product-grid">

            <div class="product-card">
                <img src="img/p-spray.jpg" alt="">
                <div class="product-info">
                    <div>
                        <h4>Spray Multiusos</h4>
                        <span>Eco</span>
                    </div>
                    <strong>$4.90</strong>
                </div>
            </div>

            <div class="product-card">
                <img src="img/p-cloth.jpg" alt="">
                <div class="product-info">
                    <div>
                        <h4>Paño Microfibra</h4>
                        <span>Reutilizable</span>
                    </div>
                    <strong>$2.50</strong>
                </div>
            </div>

            <div class="product-card">
                <img src="img/p-soap.jpg" alt="">
                <div class="product-info">
                    <div>
                        <h4>Jabón Líquido</h4>
                        <span>Aroma cítrico</span>
                    </div>
                    <strong>$3.20</strong>
                </div>
            </div>

            <div class="product-card">
                <img src="img/p-brush.jpg" alt="">
                <div class="product-info">
                    <div>
                        <h4>Cepillo Bambú</h4>
                        <span>Natural</span>
                    </div>
                    <strong>$5.10</strong>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="catalog-section stationery" id="papeleria">

    <div class="category-products">

        <h2>Papelería</h2>

        <p>
            Selección curada de productos pensados para tu día a día.
            Calidad y diseño en cada detalle.
        </p>

        <div class="product-grid">

            <div class="product-card">
                <img src="img/p-notebook.jpg" alt="">
                <div class="product-info">
                    <div>
                        <h4>Cuaderno Lila</h4>
                        <span>A5 · Punteado</span>
                    </div>
                    <strong>$6.00</strong>
                </div>
            </div>

            <div class="product-card">
                <img src="img/p-pens.jpg" alt="">
                <div class="product-info">
                    <div>
                        <h4>Set de Bolígrafos</h4>
                        <span>Pack x5</span>
                    </div>
                    <strong>$8.40</strong>
                </div>
            </div>

            <div class="product-card">
                <img src="img/p-markers.jpg" alt="">
                <div class="product-info">
                    <div>
                        <h4>Marcadores Pastel</h4>
                        <span>12 colores</span>
                    </div>
                    <strong>$7.20</strong>
                </div>
            </div>

            <div class="product-card">
                <img src="img/p-agenda.jpg" alt="">
                <div class="product-info">
                    <div>
                        <h4>Agenda 2026</h4>
                        <span>Tapa dura</span>
                    </div>
                    <strong>$12.00</strong>
                </div>
            </div>

        </div>
    </div>

    <div class="category-image">
        <span class="badge">✎ ESCRIBIR, ANOTAR, CREAR</span>
        <img src="img/cat-stationery.jpg" alt="">
    </div>

</section>


<section class="catalog-section tech" id="tecnologia">

    <div class="category-image">
        <span class="badge">⚙ HERRAMIENTAS DEL DÍA A DÍA</span>
        <img src="img/cat-tech.jpg" alt="">
    </div>

    <div class="category-products">

        <h2>Tecnología</h2>

        <p>
            Selección curada de productos pensados para tu día a día.
            Calidad y diseño en cada detalle.
        </p>

        <div class="product-grid">

            <div class="product-card">
                <img src="img/p-earbuds.jpg" alt="">
                <div class="product-info">
                    <div>
                        <h4>Auriculares Mini</h4>
                        <span>Bluetooth 5.3</span>
                    </div>
                    <strong>$39.00</strong>
                </div>
            </div>

            <div class="product-card">
                <img src="img/p-keyboard.jpg" alt="">
                <div class="product-info">
                    <div>
                        <h4>Teclado Compacto</h4>
                        <span>Mecánico</span>
                    </div>
                    <strong>$59.00</strong>
                </div>
            </div>

            <div class="product-card">
                <img src="img/p-mouse.jpg" alt="">
                <div class="product-info">
                    <div>
                        <h4>Mouse inalámbrico</h4>
                        <span>Silencioso</span>
                    </div>
                    <strong>$24.00</strong>
                </div>
            </div>

            <div class="product-card">
                <img src="img/p-charger.jpg" alt="">
                <div class="product-info">
                    <div>
                        <h4>Cargador 30W</h4>
                        <span>USB-C</span>
                    </div>
                    <strong>$18.00</strong>
                </div>
            </div>

        </div>
    </div>
</section>

</body>
</html>