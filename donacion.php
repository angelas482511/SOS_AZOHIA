<?php
require_once "conexion.php";
include_once "funciones.php";
session_start();

$total_donacion = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Aportación - SOS La Azohía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="bg-light">
    <header>
        <?php cabecera(); ?>
    </header>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4 text-center">Resumen de tu colaboración</h2>
                
                <div class="card shadow p-4">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Detalle de agradecimiento</th>
                                <th class="text-end">Aportación mínima</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // 1. Comprobamos si hay algo en la cesta
                            if (isset($_SESSION['cesta']) && count($_SESSION['cesta']) > 0) {
                                
                                // 2. Recorremos los IDs que hay guardados en la sesión (con su índice)
                                foreach ($_SESSION['cesta'] as $index => $id_producto) {
                                    
                                    // 3. Buscamos la info de ese producto en la base de datos
                                    $sql = "SELECT * FROM productos WHERE id = :id";
                                    $stmt = $conexion->prepare($sql);
                                    $stmt->bindParam(":id", $id_producto);
                                    $stmt->execute();
                                    $producto_fila = $stmt->fetch(PDO::FETCH_ASSOC);
                                    
                                    if ($producto_fila) {
                                        echo "<tr>";
                                        echo "  <td>" . htmlspecialchars($producto_fila['nombre']) . "</td>";
                                        echo "  <td class='text-end'>" . $producto_fila['precio'] . " €</td>";
                                        echo "  <td class='text-end'><a href='eliminar_donacion_item.php?index=" . $index . "' class='btn btn-sm btn-outline-danger' title='Eliminar'>🗑️</a></td>";
                                        echo "</tr>";
                                        
                                        // 4. Vamos sumando el precio al total
                                        $total_donacion = $total_donacion + $producto_fila['precio'];
                                    }
                                }
                            } else {
                                // Si la cesta está vacía
                                echo "<tr><td colspan='3' class='text-center py-4 text-muted'>Aún no has seleccionado ningún detalle de agradecimiento.</td></tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot class="table-group-divider">
                            <tr>
                                <th class="fs-4 text-dark">Total de tu aportación:</th>
                                <th class="fs-4 text-end text-primary"><?php echo $total_donacion; ?> €</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>

                    <?php if ($total_donacion > 0) { ?>
                        <div class="alert alert-info mt-4">
                            <p class="mb-0 small"><strong>¿Cómo funciona?</strong> Al confirmar, nos pondremos en contacto contigo para indicarte cómo realizar la donación y entregarte tus detalles.</p>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-success btn-lg">Confirmar y Ayudar</button>
                            <a href="tienda.php" class="btn btn-outline-secondary">Elegir algo más</a>
                        </div>
                    <?php } else { ?>
                        <a href="tienda.php" class="btn btn-primary w-100">Ir a la tienda de donaciones</a>
                    <?php } ?>
                </div>
                
                <div class="text-center mt-3">
                    <a href="vaciar_donacion.php" class="text-danger small">Limpiar mi lista y empezar de nuevo</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>