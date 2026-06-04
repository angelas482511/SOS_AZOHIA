<?php
require_once "conexion.php";
include_once "funciones.php";
session_start();

$mensaje_exito = "";
if (isset($_GET['msj']) && $_GET['msj'] == "añadido") {
    $mensaje_exito = "¡Añadido a tu lista de donación correctamente!";
}
?>

<!doctype html>
<html lang="es">
<head>
    <title>SOS La Azohía - Donaciones</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <header>
        <?php cabecera(); ?>
    </header>

    <main class="container my-5">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Colabora con Nosotros</h1>
            <p class="lead text-secondary">Por cada donación que realices, puedes elegir uno de estos detalles de agradecimiento.</p>
            
            <?php if ($mensaje_exito != "") { ?>
                <div class="alert alert-success mt-3 shadow-sm border-0">
                    <?php echo $mensaje_exito; ?> 
                    <a href="donacion.php" class="fw-bold text-success ms-2">Ver mi aportación →</a>
                </div>
            <?php } ?>
        </div>

        <div class="row">
            <?php
            // CAMBIO CLAVE: Ahora seleccionamos productos que tengan STOCK mayor que 0
            $consulta = $conexion->query("SELECT * FROM productos WHERE stock > 0 ORDER BY precio ASC");

            while ($producto = $consulta->fetch(PDO::FETCH_ASSOC)) {
                
                $imagen_producto = !empty($producto['imagen']) ? 'uploads/' . $producto['imagen'] : 'uploads/default.jpg';
            ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 overflow-hidden">
                        <div class="position-absolute p-2">
                            <span class="badge bg-primary fs-6 shadow">Donación: <?php echo $producto['precio']; ?>€</span>
                        </div>

                        <img src="<?php echo $imagen_producto; ?>" 
                             class="card-img-top" 
                             alt="<?php echo $producto['nombre']; ?>" 
                             style="height: 250px; object-fit: cover;">

                        <div class="card-body d-flex flex-column text-center">
                            <h5 class="card-title fw-bold text-dark"><?php echo $producto['nombre']; ?></h5>
                            <p class="card-text text-muted small">
                                <?php echo $producto['descripcion']; ?>
                            </p>
                            
                            <div class="mb-3">
                                <span class="badge bg-light text-dark border">
                                    Disponibles: <?php echo $producto['stock']; ?> uds.
                                </span>
                            </div>

                            <div class="mt-auto pt-3">
                                <a href="añadir_donacion.php?id=<?php echo $producto['id']; ?>" 
                                   class="btn btn-dark w-100 py-2 rounded-pill fw-bold shadow-sm">
                                    Añadir a mi donación
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
            } // Fin del bucle 
            ?>
        </div>
    </main>

    <footer class="py-5 bg-dark text-white text-center mt-5">
        <div class="container">
            <p class="mb-1 fw-bold">SOS La Azohía</p>
            <p class="small text-secondary mb-0">&copy; 2025 - Gestión de donaciones voluntarias para la protección del litoral.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>