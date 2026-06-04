<?php
session_start();
// Borramos solo la parte de la cesta de la sesión
unset($_SESSION['cesta']);
// Redirigimos a la tienda
header("Location: tienda.php");
exit();