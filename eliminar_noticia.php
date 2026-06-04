<?php
require_once "conexion.php";
session_start();

// sólo permite que entre el administrador 
if (!isset($_SESSION['logged']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    //  Borrar la imagen de la carpeta uploads 
    $stmt_img = $conexion->prepare("SELECT imagen FROM noticias WHERE id = :id");
    $stmt_img->execute([':id' => $id]);
    $noticia = $stmt_img->fetch();
    
    if ($noticia && !empty($noticia['imagen'])) {
        unlink("uploads/" . $noticia['imagen']); 
    }

    // 2. Borrar el registro de la base de datos
    $sql = "DELETE FROM noticias WHERE id = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->execute([':id' => $id]);
}

header("Location: administracion_noticias.php?msj=borrado");
exit();