<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once "conexion.php";

session_start();

// 1. Seguridad: Solo el admin entra
if (!isset($_SESSION['logged']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit();
}

// 2. Procesar el formulario cuando se pulsa "Enviar"
if (isset($_POST["titulo"])) {
    
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    $autor = $_SESSION["nombreUsuario"];
    $nombre_imagen = ""; // Variable vacía por si no suben foto

    // --- LÓGICA DE LA IMAGEN ---
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["name"] != "") {
        // Creamos un nombre único con la fecha para que no se sobrescriban
        $nombre_imagen = date("Y-m-d-H-i-s") . "-" . $_FILES['imagen']['name'];
        $archivo_temporal = $_FILES['imagen']['tmp_name'];
        
        // Movemos el archivo a la carpeta uploads
        move_uploaded_file($archivo_temporal, "uploads/" . $nombre_imagen);
    }

    // --- CONSULTA CON PDO ---
    $sql = "INSERT INTO noticias (titulo, contenido, autor, imagen) VALUES (:titulo, :contenido, :autor, :imagen)";
    $consulta = $conexion->prepare($sql);

    // Vinculamos parámetros como en el ejemplo del profesor
    $consulta->bindParam(":titulo", $titulo);
    $consulta->bindParam(":contenido", $contenido);
    $consulta->bindParam(":autor", $autor);
    $consulta->bindParam(":imagen", $nombre_imagen);

    $consulta->execute();

    header("Location: administracion_noticias.php?msj=insertado");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Noticia - SOS La Azohía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2>Nueva Noticia</h2>
        <hr>
        
        <form action="" method="post" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contenido</label>
                <textarea name="contenido" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagen de la noticia</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
                <small class="text-muted">La imagen se guardará en la carpeta /uploads</small>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Publicar Noticia</button>
                <a href="administracion_noticias.php" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>

</body>
</html>