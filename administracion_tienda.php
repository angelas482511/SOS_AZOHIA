<?php
require_once "conexion.php";
session_start();

// 1. SEGURIDAD: Solo el administrador puede entrar 
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php"); 
    exit();
}

// 2. OBTENER TODOS LOS PRODUCTOS
$resultado = $conexion->query("SELECT * FROM productos ORDER BY id DESC");
$lista_productos = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos - SOS La Azohía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de tienda solidaria</h1>
            <a href="nuevo_producto.php" class="btn btn-success"> + Añadir Producto</a>
        </div>

        <?php if (isset($_GET['msj'])) { ?>
            <div class="alert alert-success">Operación realizada con éxito.</div>
        <?php } ?>

        <div class="card shadow border-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Foto</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Estado / Stock</th> <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_productos as $producto) { ?>
                        <tr>
                            <td>
                                <img src="uploads/<?php echo $producto['imagen']; ?>" width="60" height="60" style="object-fit: cover;" class="rounded border">
                            </td>
                            <td>
                                <strong><?php echo $producto['nombre']; ?></strong><br>
                                <small class="text-muted"><?php echo substr($producto['descripcion'], 0, 50); ?>...</small>
                            </td>
                            <td><?php echo $producto['precio']; ?> €</td>
                            <td><?php echo $producto['categoria']; ?></td>
                            
                            <td>
                                <?php if ($producto['stock'] <= 0) { ?>
                                    <span class="badge bg-danger">Agotado</span>
                                <?php } else { ?>
                                    <span class="badge bg-success">Disponible</span>
                                    <div class="small fw-bold mt-1 text-dark">
                                        Quedan: <?php echo $producto['stock']; ?> uds.
                                    </div>
                                <?php } ?>
                            </td>

                            <td>
                                <a href="modificar_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="eliminar_producto.php?id=<?php echo $producto['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Seguro que quieres eliminar este producto?')">
                                    Borrar
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4 mb-5">
            <a href="administracion.php" class="btn btn-outline-secondary">Volver al Panel Principal</a>
        </div>
    </div>

</body>
</html>