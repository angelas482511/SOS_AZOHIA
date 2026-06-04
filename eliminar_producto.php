<?php
require_once "conexion.php";
session_start();

// 1. Seguridad: Solo el administrador
if (!isset($_SESSION['logged']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit();
}

// 2. Verificar que recibimos un ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 3. Opcional: Borrar la imagen de la carpeta uploads para no llenar el servidor
    $stmtImg = $conexion->prepare("SELECT imagen FROM productos WHERE id = :id");
    $stmtImg->execute([':id' => $id]);
    $prod = $stmtImg->fetch();
    
    if ($prod && $prod['imagen'] != 'default.jpg') {
        unlink("uploads/" . $prod['imagen']);
    }

    // 4. Borrar de la base de datos
    $sql = "DELETE FROM productos WHERE id = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(":id", $id);
    
    if ($consulta->execute()) {
        header("Location: administracion_tienda.php?msj=eliminado");
    } else {
        echo "Error al eliminar el producto.";
    }
} else {
    header("Location: administracion_tienda.php");
}
exit();