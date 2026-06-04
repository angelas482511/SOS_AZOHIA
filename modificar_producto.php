<?php
require_once "conexion.php";
session_start();

// 1. Seguridad: Solo el administrador entra
if (!isset($_SESSION['logged']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit();
}

// 2. Obtener los datos actuales del producto
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        die("Producto no encontrado.");
    }
}

// 3. Procesar el formulario de actualización
if (isset($_POST["nombre"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $categoria = $_POST["categoria"];
    $stock = $_POST["stock"]; 
    
    $nombre_imagen = $_POST["imagen_actual"]; // Mantenemos la actual por defecto

    // Si el usuario sube una nueva imagen
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["name"] != "") {
        $nombre_imagen = date("Y-m-d-H-i-s") . "-" . $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], "uploads/" . $nombre_imagen);
    }

    $sql = "UPDATE productos SET 
                nombre = :nombre, 
                descripcion = :descripcion, 
                precio = :precio, 
                imagen = :imagen, 
                categoria = :categoria, 
                stock = :stock 
            WHERE id = :id";
    
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(":nombre", $nombre);
    $consulta->bindParam(":descripcion", $descripcion);
    $consulta->bindParam(":precio", $precio);
    $consulta->bindParam(":imagen", $nombre_imagen);
    $consulta->bindParam(":categoria", $categoria);
    $consulta->bindParam(":stock", $stock);
    $consulta->bindParam(":id", $id);

    $consulta->execute();

    header("Location: administracion_tienda.php?msj=modificado");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto - SOS La Azohía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4 border-0">
            <h2 class="text-primary">Modificar Producto</h2>
            <hr>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                <input type="hidden" name="imagen_actual" value="<?php echo $producto['imagen']; ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre del Producto</label>
                    <input type="text" name="nombre" class="form-control" value="<?php echo $producto['nombre']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3" required><?php echo $producto['descripcion']; ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $producto['precio']; ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold text-success">Stock Disponible</label>
                        <input type="number" name="stock" class="form-control" value="<?php echo $producto['stock']; ?>" min="0" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Categoría</label>
                        <select name="categoria" class="form-select" required>
                            <option value="Ropa" <?php if($producto['categoria']=='Ropa') echo 'selected'; ?>>Ropa</option>
                            <option value="Accesorios" <?php if($producto['categoria']=='Accesorios') echo 'selected'; ?>>Accesorios</option>
                            <option value="Otros" <?php if($producto['categoria']=='Otros') echo 'selected'; ?>>Otros</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Imagen</label><br>
                    <img src="uploads/<?php echo $producto['imagen']; ?>" width="80" class="mb-2 rounded border">
                    <input type="file" name="imagen" class="form-control">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-5">Guardar Cambios</button>
                    <a href="administracion_tienda.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>