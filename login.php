<?php
// Formulario de acceso. Los datos reales en BD están en columnas: correo, hash_pass, nombre_visible
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingresar · nuvo.</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
 
<div class="login-wrapper">
 
    <!-- Marca -->
    <div class="login-brand">
        <a href="index.php">
            <span class="logo-text">nuvo.</span>
            <span class="logo-sub">inventario interno</span>
        </a>
    </div>
 
    <!-- Card -->
    <div class="login-card" style="position:relative; overflow:hidden;">
 
        <!-- Círculos decorativos -->
        <div class="deco-circle"></div>
        <div class="deco-circle-2"></div>
 
        <!-- Encabezado -->
        <div class="login-header">
            <h1>Bienvenido <em>de nuevo.</em></h1>
            <p>Ingresá tus credenciales para acceder al panel.</p>
        </div>
 
        <!-- Mensajes de error / cierre de sesión -->
        <?php if (!empty($_GET['err'])): ?>
        <div class="login-msg error">
            <span class="msg-icon">✕</span>
            <span>El correo o la contraseña no son correctos.</span>
        </div>
        <?php endif; ?>
 
        <?php if (!empty($_GET['out'])): ?>
        <div class="login-msg success">
            <span class="msg-icon">✓</span>
            <span>Sesión cerrada correctamente.</span>
        </div>
        <?php endif; ?>
 
        <!-- Formulario -->
        <form class="login-form" action="procesar_login.php" method="post" autocomplete="on">
 
            <div class="field">
                <label for="correo">Correo electrónico</label>
                <input
                    type="email"
                    id="correo"
                    name="correo"
                    placeholder="admin@test.com"
                    required
                    autofocus
                >
            </div>
 
            <div class="field">
                <label for="clave">Contraseña</label>
                <input
                    type="password"
                    id="clave"
                    name="clave"
                    placeholder="••••••••"
                    required
                >
            </div>
 
            <button type="submit" class="btn-login">Ingresar →</button>
 
        </form>
 
        <!-- Pie -->
        <div class="login-footer">
            <a href="index.php">
                <span class="arrow">←</span> Volver al inicio
            </a>
            <span style="font-size:12px; color:#b0b8c4;">admin@test.com / demo123</span>
        </div>
 
    </div>
</div>
 
</body>
</html>
