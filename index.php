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

<!-- ==============================
     NEWSLETTER
============================== -->
<section class="newsletter">
    <p class="newsletter-eyebrow">Mantenete al día</p>
    <h2 class="newsletter-title">Novedades, sin ruido.</h2>
    <p class="newsletter-sub">Un correo al mes con lanzamientos y descuentos.</p>
    <form class="newsletter-form" onsubmit="handleNewsletter(event)">
        <input type="email" name="email" placeholder="tu@correo.com" required>
        <button type="submit">Suscribirme</button>
    </form>
    <p class="newsletter-confirm" id="newsletterConfirm">¡Gracias! Te sumamos a la lista ✓</p>
</section>

<!-- ==============================
     FOOTER
============================== -->
<footer class="site-footer">
    <div class="footer-inner">

        <!-- Columna marca -->
        <div class="footer-brand">
            <span class="footer-logo">nuvo.</span>
            <p class="footer-tagline">Comercio minimalista para una vida más simple.</p>
            <div class="footer-social">
                <a href="#" aria-label="Instagram">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/>
                        <circle cx="17.5" cy="6.5" r=".8" fill="currentColor" stroke="none"/>
                    </svg>
                </a>
                <a href="#" aria-label="Twitter / X">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L2.25 2.25h6.865l4.26 5.632zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </a>
                <a href="#" aria-label="Facebook">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Columna Tienda -->
        <div class="footer-col">
            <h4>Tienda</h4>
            <a href="#limpieza">Limpieza</a>
            <a href="#papeleria">Papelería</a>
            <a href="#tecnologia">Tecnología</a>
        </div>

        <!-- Columna Ayuda -->
        <div class="footer-col">
            <h4>Ayuda</h4>
            <a href="#">Envíos</a>
            <a href="#">Devoluciones</a>
            <a href="#">Contacto</a>
        </div>

    </div>

    <div class="footer-bottom">
        <span>© 2026 Nuvo. Hecho con cuidado.</span>
    </div>
</footer>

<script>
function handleNewsletter(e) {
    e.preventDefault();
    document.getElementById('newsletterConfirm').style.display = 'block';
    e.target.reset();
}
</script>

</body>
</html>