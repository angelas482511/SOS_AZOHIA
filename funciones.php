<?php
// funciones.php

function mostrar_notificaciones() {
    $mensaje = "";
    $tipo = "success";
    
    if (isset($_GET['msj'])) {
        switch($_GET['msj']) {
            case 'insertado': $mensaje = "Elemento añadido correctamente."; break;
            case 'modificado': $mensaje = "Cambios guardados con éxito."; break;
            case 'borrado': 
            case 'eliminado': $mensaje = "Elemento eliminado."; $tipo = "warning"; break;
            case 'añadido': $mensaje = "Producto añadido a tu aportación."; break;
            case 'sin_stock': $mensaje = "Lo sentimos, no hay stock suficiente."; $tipo = "danger"; break;
            case 'actualizado': $mensaje = "Información actualizada."; break;
            case 'eliminado_item': $mensaje = "Producto retirado de la aportación."; $tipo = "warning"; break;
            case 'vender': $mensaje = "Debes iniciar sesión como administrador."; $tipo = "warning"; break;
            default: $mensaje = "Acción realizada con éxito."; break;
        }
    }
    
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        $mensaje = "Credenciales incorrectas.";
        $tipo = "danger";
    }

    if ($mensaje != "") {
        // Bootstrap Toast
        echo '
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
            <div id="liveToast" class="toast align-items-center text-bg-' . $tipo . ' border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-bold">
                        ' . $mensaje . '
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var toastElList = [].slice.call(document.querySelectorAll(".toast"));
                var toastList = toastElList.map(function(toastEl) {
                    return new bootstrap.Toast(toastEl, { delay: 4000 });
                });
                toastList.forEach(toast => toast.show());
                
                // Limpiar la URL para que no vuelva a salir al recargar
                if (window.history.replaceState) {
                    const url = new URL(window.location.href);
                    url.searchParams.delete("msj");
                    url.searchParams.delete("error");
                    window.history.replaceState({path:url.href}, "", url.href);
                }
            });
        </script>';
    }
}

function cabecera() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="uploads/logo.jpg" alt="Logo SOS La Azohía" style="width: 45px;">
                <span class="ms-2 fw-bold text-primary">SOS La Azohía</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="index.php">Noticias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="quienes_somos.php">Quiénes Somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="tienda.php">Colaborar</a>
                    </li>
                    
                    <li class="nav-item ms-lg-3">
                        <a href="donacion.php" class="btn btn-outline-primary rounded-pill position-relative">
                            ❤️ Mi Aportación
                            <?php if (isset($_SESSION['cesta']) && count($_SESSION['cesta']) > 0) { ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?php echo count($_SESSION['cesta']); ?>
                                </span>
                            <?php } ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="bg-light border-bottom py-1">
        <div class="container d-flex justify-content-end">
            <?php if (isset($_SESSION['logged']) && $_SESSION['rol'] == 'admin') { ?>
                <div class="small">
                    <span class="text-muted me-2">Modo Editor:</span>
                    <a href="administracion.php" class="text-decoration-none text-dark me-3">🔑 Administración</a>
                    <a href="logout.php" class="text-danger text-decoration-none">Cerrar Sesión</a>
                </div>
            <?php } else { ?>
                <a href="login.php" class="text-decoration-none text-muted small">🔑 Administración</a>
            <?php } ?>
        </div>
    </div>
<?php
    mostrar_notificaciones();
}
?>