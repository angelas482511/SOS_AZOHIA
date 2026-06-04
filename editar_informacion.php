<?php
require_once "conexion.php";
session_start();

// 1. Seguridad: Solo el administrador Carlos puede entrar
if (!isset($_SESSION['logged']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit();
}

// 2. Intentamos buscar si ya existe la información
$stmt = $conexion->query("SELECT * FROM informacion WHERE id = 1");
$datos = $stmt->fetch();

// 3. Cuando el administrador pulsa "Guardar"
if ($_POST) {
    $titulo   = $_POST['titulo'];
    $nosotros = $_POST['nosotros'];
    $problema = $_POST['problema'];
    $video    = $_POST['video'];
    
    // Gestión de la imagen (mismo sistema que tus noticias)
    $nombre_img = $datos ? $datos['imagen'] : 'defecto.jpg'; 
    if (isset($_FILES['foto']) && $_FILES['foto']['name'] != "") {
        $nombre_img = date("YmdHis") . "-" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $nombre_img);
    }

    if (!$datos) {
        // PRIMERA VEZ: Insertamos
        $sql = "INSERT INTO informacion (id, titulo, nosotros, problema, video, imagen) 
                VALUES (1, :t, :n, :p, :v, :i)";
    } else {
        // SIGUIENTES VECES: Actualizamos
        $sql = "UPDATE informacion SET titulo=:t, nosotros=:n, problema=:p, video=:v, imagen=:i WHERE id=1";
    }

    $stmtAccion = $conexion->prepare($sql);
    $stmtAccion->execute([
        ':t' => $titulo,
        ':n' => $nosotros,
        ':p' => $problema,
        ':v' => $video,
        ':i' => $nombre_img
    ]);

    header("Location: administracion.php?msj=actualizado");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Información Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm border-0 p-4">
            <h2 class="mb-4 text-primary">Gestionar "Quiénes Somos"</h2>
            
            <form action="" method="post" enctype="multipart/form-data">
                
                <div class="mb-4 p-3 bg-white border rounded">
                    <h5>Portada Principal</h5>
                    <label class="form-label">Título del Hero (Bienvenidos...)</label>
                    <input type="text" name="titulo" class="form-control" value="<?= $datos ? $datos['titulo'] : '' ?>" required>
                    
                    <label class="form-label mt-2">Imagen de fondo</label>
                    <input type="file" name="foto" class="form-control">
                    <?php if($datos): ?>
                        <small>Imagen actual: <?= $datos['imagen'] ?></small>
                    <?php endif; ?>
                </div>

                <div class="mb-4 p-3 bg-white border rounded">
                    <h5>Textos Explicativos</h5>
                    <label class="form-label">Sobre Nosotros (Historia)</label>
                    <textarea name="nosotros" class="form-control mb-2" rows="5"><?= $datos ? $datos['nosotros'] : '' ?></textarea>
                    
                    <label class="form-label">El Problema Ambiental</label>
                    <textarea name="problema" class="form-control" rows="5"><?= $datos ? $datos['problema'] : '' ?></textarea>
                </div>

                <div class="mb-4 p-3 bg-white border rounded">
                    <h5>Multimedia</h5>
                    <label class="form-label">Enlace de Vídeo (YouTube)</label>
                    <input type="text" name="video" class="form-control" placeholder="https://www.youtube.com/watch?v=..." value="<?= $datos ? $datos['video'] : '' ?>">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg px-5">Guardar Cambios</button>
                    <a href="administracion.php" class="btn btn-outline-secondary btn-lg">Volver</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>