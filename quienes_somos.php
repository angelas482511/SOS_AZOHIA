<?php
require_once "conexion.php";
include_once "funciones.php";
// 1. hacemos consulata a la BBDD con id 1
$res = $conexion->query("SELECT * FROM informacion WHERE id = 1");
$info = $res->fetch();

// si no se muestra ningun cambio muestra datos por defecto
if (!$info) {
    $info = [
        'titulo' => 'SOS La Azohía',
        'nosotros' => 'Estamos preparando nuestro contenido...',
        'problema' => 'La Azohía necesita nuestra protección.',
        'imagen' => 'default.jpg',
        'video' => ''
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Quiénes Somos - SOS La Azohía</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* diseño de la seccion de Hero */
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('uploads/<?php echo $info['imagen']; ?>');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }
        .texto-justificado {
            text-align: justify;
        }
    </style>
</head>
<body>
    <header><?php cabecera(); ?></header>

    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-2 fw-bold"><?php echo $info['titulo']; ?></h1>
            <p class="fs-4">Protegiendo el litoral de La Azohía</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-10 mx-auto text-center">
                    <h2 class="display-5 mb-4 text-primary">Nuestra Historia</h2>
                    <p class="lead texto-justificado">
                        <?php echo nl2br($info['nosotros']); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="display-5 mb-4 text-danger">El Problema Real</h2>
                    <p class="fs-5 texto-justificado">
                        <?php echo nl2br($info['problema']); ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <?php if(!empty($info['video'])) { 
                        // Convertimos diferentes formatos de YouTube a enlace de "incrustar" (embed)
                        $url_video = $info['video'];
                        if (strpos($url_video, 'watch?v=') !== false) {
                            $url_video = str_replace('watch?v=', 'embed/', $url_video);
                        } elseif (strpos($url_video, 'youtu.be/') !== false) {
                            $url_video = str_replace('youtu.be/', 'youtube.com/embed/', $url_video);
                        }
                        // Quitamos parámetros extra que no sirven para el embed (como ?si=...)
                        $url_video = preg_replace('/(\?|&)(si|t)=.*/', '', $url_video);

                    ?>
                        <div class="ratio ratio-16x9 shadow rounded overflow-hidden">
                            <iframe src="<?php echo $url_video; ?>" title="YouTube video" allowfullscreen></iframe>
                        </div>
                    <?php } else { ?>
                        <div class="p-5 bg-white text-center rounded shadow-sm">
                            <p class="text-muted">No hay video disponible en este momento.</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 text-center border-top mt-5">
        <p class="text-muted">&copy; 2025 SOS La Azohía - Unidos por el Mar</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>