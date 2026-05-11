<?php
// Formulario de acceso. Los datos reales en BD están en columnas: correo, hash_pass, nombre_visible
session_start();
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Login inventario</title></head><body>
<h1>Ingresar</h1>
<?php if (!empty($_GET['err'])) { echo "<p style='color:#b00'>No se pudo iniciar sesión.</p>"; } ?>
<?php if (!empty($_GET['out'])) { echo "<p>Sesión cerrada.</p>"; } ?>
<form action="procesar_login.php" method="post" autocomplete="on">
  <label>Correo<br><input type="email" name="correo" required></label><br><br>
  <label>Contraseña<br><input type="password" name="clave" required></label><br><br>
  <button type="submit">Entrar</button>
</form>
<p><a href="index.php">Volver al inicio</a></p>
<p><small>Prueba en BD: <code>admin@test.com</code> / <code>demo123</code> — aun así este flujo no deja entrar por el desajuste de nombres en el código PHP.</small></p>
</body></html>
