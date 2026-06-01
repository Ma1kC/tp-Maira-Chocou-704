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
 
$term = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];
 
if ($term !== '') {
    $like = '%' . $term . '%';
    $st = $pdo->prepare('SELECT id, nombre, stock, precio, nota FROM productos WHERE nombre LIKE ? OR nota LIKE ?');
    $st->execute([$like, $like]);
    $results = $st->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar · nuvo.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* ── Página de búsqueda ── */
 
        .search-page {
            min-height: 100vh;
            padding: 110px 80px 80px;
            max-width: 1100px;
            margin: 0 auto;
        }
 
        /* Encabezado */
        .search-page-header {
            margin-bottom: 48px;
        }
 
        .search-page-header .eyebrow {
            font-size: 12px;
            letter-spacing: 4px;
            color: #8a9bb0;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
 
        .search-page-header h1 {
            font-size: 52px;
            font-weight: 300;
            line-height: 1.1;
            margin-bottom: 32px;
        }
 
        .search-page-header h1 em {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-weight: 700;
        }
 
        /* Barra de búsqueda grande */
        .search-form-large {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 999px;
            overflow: hidden;
            max-width: 640px;
            box-shadow: 0 2px 8px rgba(7,22,58,.06), 0 8px 32px rgba(7,22,58,.08);
            transition: box-shadow .2s;
        }
 
        .search-form-large:focus-within {
            box-shadow: 0 4px 16px rgba(7,22,58,.10), 0 16px 48px rgba(7,22,58,.10);
        }
 
        .search-form-large input {
            flex: 1;
            border: none;
            outline: none;
            padding: 18px 28px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            color: #0a1020;
            background: transparent;
        }
 
        .search-form-large input::placeholder {
            color: #b0bbc8;
        }
 
        .search-form-large button {
            background: #07163a;
            border: none;
            color: #fff;
            padding: 14px 24px;
            margin: 6px;
            border-radius: 999px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            letter-spacing: .3px;
            transition: background .2s;
            white-space: nowrap;
        }
 
        .search-form-large button:hover {
            background: #0d2254;
        }
 
        /* Resultados */
        .results-meta {
            margin: 40px 0 24px;
            font-size: 14px;
            color: #8a9bb0;
        }
 
        .results-meta strong {
            color: #0a1020;
            font-weight: 600;
        }
 
        /* Grid de resultados */
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            animation: fadeUp .4s ease both;
        }
 
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
 
        /* Card resultado */
        .result-card {
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.06);
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: transform .2s, box-shadow .2s;
        }
 
        .result-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,.06), 0 12px 32px rgba(0,0,0,.10);
        }
 
        /* Placeholder imagen */
        .result-card .result-img {
            width: 100%;
            aspect-ratio: 1 / 1;
            background: #f0f4f8;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: #c5d0dc;
        }
 
        .result-card .result-body {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 8px;
        }
 
        .result-card .result-name {
            font-size: 15px;
            font-weight: 500;
            color: #0a1020;
            line-height: 1.3;
        }
 
        .result-card .result-sub {
            font-size: 13px;
            color: #8a9bb0;
            margin-top: 3px;
        }
 
        .result-card .result-price {
            font-size: 16px;
            font-weight: 600;
            color: #07163a;
            white-space: nowrap;
            flex-shrink: 0;
        }
 
        /* Stock badge */
        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 999px;
            font-weight: 500;
        }
 
        .stock-badge.in  { background: rgba(45,106,79,.10); color: #2d6a4f; }
        .stock-badge.low { background: rgba(192,133,43,.10); color: #a0721e; }
        .stock-badge.out { background: rgba(192,57,43,.08);  color: #c0392b; }
 
        /* Estado vacío */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            animation: fadeUp .4s ease both;
        }
 
        .empty-state .empty-icon {
            font-size: 56px;
            margin-bottom: 20px;
            opacity: .3;
        }
 
        .empty-state h3 {
            font-size: 22px;
            font-weight: 300;
            margin-bottom: 10px;
            color: #0a1020;
        }
 
        .empty-state p {
            font-size: 15px;
            color: #8a9bb0;
            line-height: 1.6;
        }
 
        /* Volver */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 48px;
            font-size: 14px;
            color: #8a9bb0;
            text-decoration: none;
            transition: color .2s;
        }
 
        .back-link:hover { color: #0a1020; }
 
        @media (max-width: 768px) {
            .search-page { padding: 100px 24px 60px; }
            .search-page-header h1 { font-size: 36px; }
        }
    </style>
</head>
<body>
 
    <!-- Navbar -->
    <header class="navbar">
        <div class="logo"><a href="index.php" style="text-decoration:none;color:inherit;">nuvo.</a></div>
 
        <nav>
            <a href="index.php#limpieza">Limpieza</a>
            <a href="index.php#papeleria">Papelería</a>
            <a href="index.php#tecnologia">Tecnología</a>
            <a href="#">Sobre nosotros</a>
        </nav>
 
        <div class="icons">
            <span style="font-size:21px;cursor:default;">⌕</span>
            <span>🛒</span>
            <a href="login.php" class="user-icon" title="Iniciar sesión">&#9711;</a>
        </div>
    </header>
 
    <div class="search-page">
 
        <!-- Encabezado -->
        <div class="search-page-header">
            <p class="eyebrow">Tienda</p>
            <h1>
                <?php if ($term !== ''): ?>
                    Resultados para <em>"<?php echo htmlspecialchars($term, ENT_QUOTES, 'UTF-8'); ?>"</em>
                <?php else: ?>
                    ¿Qué estás <em>buscando?</em>
                <?php endif; ?>
            </h1>
 
            <!-- Barra de búsqueda -->
            <form class="search-form-large" method="get" action="buscar.php">
                <input
                    type="text"
                    name="q"
                    value="<?php echo htmlspecialchars($term, ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="Buscar productos…"
                    autofocus
                    autocomplete="off"
                >
                <button type="submit">Buscar →</button>
            </form>
        </div>
 
        <?php if ($term !== ''): ?>
 
            <!-- Meta de resultados -->
            <p class="results-meta">
                <?php if (count($results) > 0): ?>
                    Se encontraron <strong><?php echo count($results); ?></strong>
                    <?php echo count($results) === 1 ? 'producto' : 'productos'; ?>
                <?php else: ?>
                    Sin resultados
                <?php endif; ?>
            </p>
 
            <?php if (count($results) > 0): ?>
 
                <div class="results-grid">
                    <?php foreach ($results as $row): ?>
 
                        <?php
                            $stock = (int) $row['stock'];
                            if ($stock === 0) {
                                $badgeClass = 'out'; $badgeText = 'Sin stock';
                            } elseif ($stock <= 10) {
                                $badgeClass = 'low'; $badgeText = 'Últimas unidades';
                            } else {
                                $badgeClass = 'in'; $badgeText = 'En stock';
                            }
                            $precio = isset($row['precio']) ? '$' . number_format((float)$row['precio'], 2) : '—';
                        ?>
 
                        <a href="detalles.php?id=<?php echo (int)$row['id']; ?>" class="result-card">
 
                            <div class="result-img">◫</div>
 
                            <div class="result-body">
                                <div>
                                    <div class="result-name"><?php echo htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    <?php if (!empty($row['nota'])): ?>
                                        <div class="result-sub"><?php echo htmlspecialchars($row['nota'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    <?php endif; ?>
                                </div>
                                <span class="result-price"><?php echo $precio; ?></span>
                            </div>
 
                            <span class="stock-badge <?php echo $badgeClass; ?>">
                                <?php echo $badgeText; ?>
                            </span>
 
                        </a>
 
                    <?php endforeach; ?>
                </div>
 
            <?php else: ?>
 
                <div class="empty-state">
                    <div class="empty-icon">⌕</div>
                    <h3>No encontramos nada para "<?php echo htmlspecialchars($term, ENT_QUOTES, 'UTF-8'); ?>"</h3>
                    <p>Intentá con otro término o revisá la ortografía.</p>
                </div>
 
            <?php endif; ?>
 
        <?php endif; ?>
 
        <a href="index.php" class="back-link">← Volver al inicio</a>
 
    </div>
 
</body>
</html>