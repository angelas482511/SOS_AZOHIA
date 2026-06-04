<?php
require_once "conexion.php";
session_start();

// SEGURIDAD: Si no está logueado o no es admin, fuera.
if (!isset($_SESSION['logged']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Consultamos solo las noticias
$resultado = $conexion->query("SELECT * FROM noticias ORDER BY fecha DESC");
$noticias = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Noticias - SOS La Azohía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="administracion.php" class="btn btn-outline-secondary btn-sm mb-2">← Volver al Panel Principal</a>
                <h1>📰 Gestión de Noticias</h1>
            </div>
            <a href="nueva_noticia.php" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle"></i> Redactar Nueva Noticia
            </a>
        </div>

        <?php if(isset($_GET['msj']) && $_GET['msj'] == 'ok') { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Acción realizada con éxito.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 80px;">Imagen</th>
                            <th>Título</th>
                            <th>Fecha</th>
                            <th>Autor</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($noticias)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No hay noticias publicadas todavía.</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($noticias as $n) { ?>
                        <tr>
                            <td>
                                <?php 
                                    $rutaImg = !empty($n['imagen']) ? 'uploads/' . $n['imagen'] : 'uploads/default.jpg';
                                ?>
                                <img src="<?php echo $rutaImg; ?>" width="60" height="60" class="rounded shadow-sm" style="object-fit: cover;">
                            </td>
                            <td class="fw-bold"><?php echo $n['titulo']; ?></td>
                            <td class="text-secondary"><?php echo date("d/m/Y", strtotime($n['fecha'])); ?></td>
                            <td><span class="badge bg-light text-dark border"><?php echo $n['autor']; ?></span></td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <a href="modificar_noticia.php?id=<?php echo $n['id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <a href="eliminar_noticia.php?id=<?php echo $n['id']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('¿Estás seguro de que quieres eliminar esta noticia? Esta acción no se puede deshacer.')">
                                        <i class="bi bi-trash"></i> Borrar
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 text-center">
            <p class="text-muted small">SOS La Azohía - Sistema de Gestión Interna</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>