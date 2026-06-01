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
 
        <!-- Barra de búsqueda -->
        <div class="search-wrapper" id="searchWrapper">
            <form class="search-bar" action="buscar.php" method="get" id="searchForm">
                <input
                    type="text"
                    name="q"
                    id="searchInput"
                    placeholder="Buscar productos…"
                    autocomplete="off"
                >
                <button type="submit" class="search-submit" aria-label="Buscar">⌕</button>
            </form>
            <button class="search-toggle" id="searchToggle" aria-label="Abrir búsqueda" onclick="toggleSearch()">⌕</button>
        </div>
 
        <span>🛒</span>
        <a href="login.php" class="user-icon" title="Iniciar sesión">&#9711;</a>
    </div>
</header>
 
<script>
function toggleSearch() {
    const wrapper = document.getElementById('searchWrapper');
    const input   = document.getElementById('searchInput');
    const isOpen  = wrapper.classList.toggle('open');
    if (isOpen) {
        input.focus();
    } else {
        input.value = '';
    }
}
 
// Cerrar con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const wrapper = document.getElementById('searchWrapper');
        if (wrapper.classList.contains('open')) {
            wrapper.classList.remove('open');
            document.getElementById('searchInput').value = '';
        }
    }
});
 
// Cerrar al hacer click fuera
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('searchWrapper');
    if (wrapper.classList.contains('open') && !wrapper.contains(e.target)) {
        wrapper.classList.remove('open');
        document.getElementById('searchInput').value = '';
    }
});
</script>
 
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
 
  
 
</main> 
 
 
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
                    <div class="product-text">
                        <h4>Spray Multiusos</h4>
                        <span class="product-sub">Eco</span>
                    </div>
                    <span class="product-price">$4.90</span>
                </div>
            </div>
 
            <div class="product-card">
                <img src="img/p-cloth.jpg" alt="">
                <div class="product-info">
                    <div class="product-text">
                        <h4>Paño Microfibra</h4>
                        <span class="product-sub">Reutilizable</span>
                    </div>
                    <span class="product-price">$2.50</span>
                </div>
            </div>
 
            <div class="product-card">
                <img src="img/p-soap.jpg" alt="">
                <div class="product-info">
                    <div class="product-text">
                        <h4>Jabón Líquido</h4>
                        <span class="product-sub">Aroma cítrico</span>
                    </div>
                    <span class="product-price">$3.20</span>
                </div>
            </div>
 
            <div class="product-card">
                <img src="img/p-brush.jpg" alt="">
                <div class="product-info">
                    <div class="product-text">
                        <h4>Cepillo Bambú</h4>
                        <span class="product-sub">Natural</span>
                    </div>
                    <span class="product-price">$5.10</span>
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
                    <div class="product-text">
                        <h4>Cuaderno Lila</h4>
                        <span class="product-sub">A5 · Punteado</span>
                    </div>
                    <span class="product-price">$6.00</span>
                </div>
            </div>
 
            <div class="product-card">
                <img src="img/p-pens.jpg" alt="">
                <div class="product-info">
                    <div class="product-text">
                        <h4>Set de Bolígrafos</h4>
                        <span class="product-sub">Pack x5</span>
                    </div>
                    <span class="product-price">$8.40</span>
                </div>
            </div>
 
            <div class="product-card">
                <img src="img/p-markes.jpg" alt="">
                <div class="product-info">
                    <div class="product-text">
                        <h4>Marcadores Pastel</h4>
                        <span class="product-sub">12 colores</span>
                    </div>
                    <span class="product-price">$7.20</span>
                </div>
            </div>
 
            <div class="product-card">
                <img src="img/p-agenda.jpg" alt="">
                <div class="product-info">
                    <div class="product-text">
                        <h4>Agenda 2026</h4>
                        <span class="product-sub">Tapa dura</span>
                    </div>
                    <span class="product-price">$12.00</span>
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
                    <div class="product-text">
                        <h4>Auriculares Mini</h4>
                        <span class="product-sub">Bluetooth 5.3</span>
                    </div>
                    <span class="product-price">$39.00</span>
                </div>
            </div>
 
            <div class="product-card">
                <img src="img/p-keyboard.jpg" alt="">
                <div class="product-info">
                    <div class="product-text">
                        <h4>Teclado Compacto</h4>
                        <span class="product-sub">Mecánico</span>
                    </div>
                    <span class="product-price">$59.00</span>
                </div>
            </div>
 
            <div class="product-card">
                <img src="img/p-mouse.jpg" alt="">
                <div class="product-info">
                    <div class="product-text">
                        <h4>Mouse inalámbrico</h4>
                        <span class="product-sub">Silencioso</span>
                    </div>
                    <span class="product-price">$24.00</span>
                </div>
            </div>
 
            <div class="product-card">
                <img src="img/p-charger.jpg" alt="">
                <div class="product-info">
                    <div class="product-text">
                        <h4>Cargador 30W</h4>
                        <span class="product-sub">USB-C</span>
                    </div>
                    <span class="product-price">$18.00</span>
                </div>
            </div>
 
        </div>
    </div>
</section>
 
</body>
</html>