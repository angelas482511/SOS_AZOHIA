<?php
require_once "conexion.php"; // Añadimos la conexión para verificar stock
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // OPCIONAL: Verificar si hay stock antes de añadir
    $res = $conexion->prepare("SELECT stock FROM productos WHERE id = :id");
    $res->execute([':id' => $id]);
    $prod = $res->fetch();

    if ($prod && $prod['stock'] > 0) {
        if (!isset($_SESSION['cesta'])) {
            $_SESSION['cesta'] = array();
        }
        $_SESSION['cesta'][] = $id;
        header("Location: tienda.php?msj=añadido");
    } else {
        // Si alguien intenta añadir un ID sin stock (por ejemplo escribiendo la URL a mano)
        header("Location: tienda.php?msj=sin_stock");
    }
} else {
    header("Location: tienda.php");
}
exit();