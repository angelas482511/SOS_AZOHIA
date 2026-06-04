<?php
// Primero ponemos la conexion y tambien iniciamos sesion 
require_once("conexion.php"); 
session_start();

if (isset($_POST["nombre"])) {
    $identificador = $_POST["nombre"]; 
    $password_candidata = $_POST["password"];

    // 1. Buscamos al administrador en la tabla users
    $stmt = $conexion->prepare("SELECT * FROM users WHERE email = :id OR nombre = :id LIMIT 1");
    $stmt->execute([':id' => $identificador]);
    $usuario = $stmt->fetch(); 

    // 2. Verificamos si existe y si es ADMIN
    if ($usuario && password_verify($password_candidata, $usuario['password'])) {
        
        // Creamos la sesión con sus datos
        $_SESSION["idUsuario"] = $usuario["id"];
        $_SESSION["nombreUsuario"] = $usuario["nombre"];
        $_SESSION["rol"] = $usuario["rol"];
        $_SESSION["logged"] = true;
        
        // Lo mandamos directamente al PANEL DE CONTROL (admin.php)
        header("location:administracion.php");
        exit();
    } else {
        // Si falla, vuelve al login con error
        header("location:login.php?error=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administración - SOS La Azohía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Administración</h2>

                        <?php
                            // Solo dejamos el mensaje de error y el de aviso para publicar
                            if(isset($_GET["msj"]) && $_GET["msj"]=="vender"){
                                echo '<div class="alert alert-warning text-center">Debes identificarte como administrador para gestionar el contenido.</div>';
                            }

                            if(isset($_GET["error"]) && $_GET["error"]==1){
                                echo '<div class="alert alert-danger text-center">Acceso denegado.</div>';
                            }
                        ?>

                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Email de Administrador</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="ejemplo@correo.com" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-2">
                                Entrar al Panel
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="index.php" class="text-muted text-decoration-none small">← Volver a la web pública</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>