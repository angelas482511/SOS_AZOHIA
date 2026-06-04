<?php
require_once "conexion.php";
session_start();

// 1. Seguridad: Solo el administrador puede estar aquí
if (!isset($_SESSION['logged']) || $_SESSION['rol'] != 'admin') {
    header("location:login.php?msj=vender");
    exit;
}

// 2. Cargar los datos de la noticia según el ID recibido por la URL (GET)
if (isset($_GET["id"])) {
    $idNoticia = $_GET["id"];

    // Consulta con PDO para traer los datos actuales
    $sql = "SELECT * FROM noticias WHERE id = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":id", $idNoticia);
    $stmt->execute();

    $noticia = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si no existe la noticia, volvemos al panel
    if (!$noticia) {
        header("location:administracion_noticias.php");
        exit;
    }

    $titulo = $noticia["titulo"];
    $contenido = $noticia["contenido"];
    $imagen = $noticia["imagen"];
}

// 3. Procesar el formulario cuando se pulsa "Enviar" (POST)
if(isset($_POST["titulo"])) {
    $idNoticia = $_POST["idNoticia"];
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    $imagen = $_POST["imagenActual"]; // Por defecto, mantenemos la que ya tiene

    // Si el usuario ha seleccionado un archivo nuevo
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["name"] != "") {
        // Nombre único con fecha como en tu ejemplo
        $imagen = date("Y-m-d-H-i-s") . "-" . $_FILES['imagen']['name'];
        $file_loc = $_FILES['imagen']['tmp_name'];
        move_uploaded_file($file_loc, "uploads/" . $imagen);
    }

    // Actualización con PDO y bindParam
    $sql = "UPDATE noticias SET titulo=:titulo, contenido=:contenido, imagen=:imagen WHERE id=:id";
    $stmt = $conexion->prepare($sql);
    
    $stmt->bindParam(":titulo", $titulo);
    $stmt->bindParam(":contenido", $contenido);
    $stmt->bindParam(":imagen", $imagen);
    $stmt->bindParam(":id", $idNoticia);
    
    $stmt->execute();

    header("location:administracion_noticias.php?msj=modificado");
    exit;
}
?>

<!doctype html>
<html lang="es">
<head>
    <title>Modificar noticia: <?php echo $titulo; ?></title>
    <meta charset="utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<main class="container mt-5">
    <div class="card shadow p-4">
        <h1>Modificar Noticia</h1>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idNoticia" value="<?php echo $idNoticia; ?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo $titulo; ?>" required>
            </div>

            <div class="mb-3">
                <label for="contenido" class="form-label">Contenido</label>
                <textarea name="contenido" id="contenido" class="form-control" rows="5" required><?php echo $contenido; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen actual</label><br>
                <img src="uploads/<?php echo $imagen; ?>" class="img-thumbnail mb-2" style="width:100px">
                
                <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
                <input type="hidden" name="imagenActual" value="<?php echo $imagen; ?>">
                <small class="text-muted">Deja este campo vacío si no quieres cambiar la imagen.</small>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="administracion_noticias.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>