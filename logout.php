<?php
// Intenta limpiar claves de sesión que no son las que se usaron al loguear (si algún día funcionara).
session_start();
unset($_SESSION['usuario_id'], $_SESSION['nombre_completo'], $_SESSION['email']);
// Quedan user_id / nombre_pantalla si se hubieran seteado — otro desajuste para refactorizar
header("Location: login.php?out=1");
exit;
