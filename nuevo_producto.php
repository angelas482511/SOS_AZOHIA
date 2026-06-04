<?php
require_once "conexion.php";
session_start();

// 1. Seguridad: Solo el administrador entra
if (!isset($_SESSION['logged']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit();
}

// 2. Procesar el formulario cuando se pulsa "Subir Producto"
if (isset($_POST["nombre"])) {
    
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $categoria = $_POST["categoria"];
    $stock = $_POST["stock"]; // <--- NUEVO: Recogemos la cantidad
    $vendedor = $_SESSION["idUsuario"]; 
    $nombre_imagen = "default.jpg"; 

    // --- LÓGICA DE LA IMAGEN ---
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["name"] != "") {
        $nombre_imagen = date("Y-m-d-H-i-s") . "-" . $_FILES['imagen']['name'];
        $archivo_temporal = $_FILES['imagen']['tmp_name'];
        move_uploaded_file($archivo_temporal, "uploads/" . $nombre_imagen);
    }

    // --- CONSULTA ACTUALIZADA (Cambiamos 'vendido' por 'stock') ---
    $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen, vendedor, categoria, stock) 
            VALUES (:nombre, :descripcion, :precio, :imagen, :vendedor, :categoria, :stock)";
    
    $consulta = $conexion->prepare($sql);

    // Vinculamos los parámetros con bindParam
    $consulta->bindParam(":nombre", $nombre);
    $consulta->bindParam(":descripcion", $descripcion);
    $consulta->bindParam(":precio", $precio);
    $consulta->bindParam(":imagen", $nombre_imagen);
    $consulta->bindParam(":vendedor", $vendedor);
    $consulta->bindParam(":categoria", $categoria);
    $consulta->bindParam(":stock", $stock); 

    $consulta->execute();

    header("Location: administracion_tienda.php?msj=insertado");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto - SOS La Azohía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2>Añadir Producto al Mercadillo</h2>
        <p class="text-muted">Indica cuántas unidades tienes disponibles para la venta.</p>
        <hr>
        
        <form action="" method="post" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label class="form-label fw-bold">Nombre del Producto</label>
                <input type="text" name="nombre" class="form-control" placeholder="Ej: Camiseta SOS La Azohía" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" placeholder="Detalles, materiales, tallas disponibles..." required></textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Precio (€)</label>
                    <input type="number" step="0.01" name="precio" class="form-control" placeholder="0.00" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Unidades disponibles</label>
                    <input type="number" name="stock" class="form-control" value="1" min="0" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Categoría</label>
                    <select name="categoria" class="form-select" required>
                        <option value="Ropa">Ropa</option>
                        <option value="Accesorios">Accesorios</option>
                        <option value="Otros">Otros</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Foto del Producto</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success px-4">Subir Producto</button>
                <a href="administracion_tienda.php" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>

</body>
</html>