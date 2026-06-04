<?php
session_start();
if (!isset($_SESSION['logged']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - SOS La Azohía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/icons/font/bootstrap-icons.css"> </head>
<body class="bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1>Bienvenido al Panel, <?php echo $_SESSION['nombreUsuario']; ?></h1>
            <p class="lead">¿Qué deseas gestionar hoy?</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-5">
                <div class="card h-100 shadow border-0 text-center p-4">
                    <div class="card-body">
                        <div class="display-1 mb-3 text-primary">📰</div>
                        <h2 class="card-title">Noticias</h2>
                        <p class="text-muted">Publica, edita o elimina artículos del blog de La Azohía.</p>
                        <a href="administracion_noticias.php" class="btn btn-primary btn-lg w-100">Entrar a Noticias</a>
                    </div>
                </div>
            </div>
        

            <div class="col-md-5">
                <div class="card h-100 shadow border-0 text-center p-4">
                    <div class="card-body">
                        <div class="display-1 mb-3 text-success">🛍️</div>
                        <h2 class="card-title">Tienda Solidaria</h2>
                        <p class="text-muted">Gestiona el inventario de productos y ventas solidarias.</p>
                        <a href="administracion_tienda.php" class="btn btn-success btn-lg w-100">Entrar a Tienda</a>
                    </div>
                </div>
            </div>
        </div>

        <!------------------------------------ boton quienes somos ----------------------------------------------- -->
            <div class="mt-4 p-4 bg-white shadow-sm rounded border">
    <h3>Contenido de la Web</h3>
    <p class="text-muted">Administración de la página "Quiénes Somos".</p>
    <a href="editar_informacion.php" class="btn btn-info text-white">
        Editar Quiénes Somos
    </a>
</div>

        <div class="text-center mt-5">
            <a href="index.php" class="btn btn-outline-secondary">Volver a la Web Pública</a>
            <a href="cierre_sesion.php" class="btn btn-danger ms-3">Cerrar Sesión</a>
        </div>
    </div>

     
</body>
</html>