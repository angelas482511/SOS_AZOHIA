<?php
require_once "conexion.php";       
include_once "funciones.php";      
?>

<!doctype html>
<html lang="es">
    <head>
        <title>SOS La Azohía - Noticias</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"

        />
        
        <link rel="stylesheet" href="css/estilos.css">
    </head>

    <body>
        <header>
            <?php cabecera(); ?>
        </header>

        <main class="container my-5">
            <h2 class="mb-4 text-center">Últimas Noticias</h2>
            <div class="row">
                <?php
                // Ejecutamos la consulta con PDO
                $resultadoNoticias = $conexion->query("SELECT * FROM noticias ORDER BY fecha DESC");

                // En PDO usamos fetch(PDO::FETCH_ASSOC)
                while($noticia = $resultadoNoticias->fetch(PDO::FETCH_ASSOC)){
                    
                    // Asignamos imagen o una por defecto

                   
    $imagen = !empty($noticia['imagen']) ? 'uploads/' . $noticia['imagen'] : 'uploads/default.jpg';
                    
                    // Cortamos la noticia a 150 caracteres para que las cards se vean uniformes
                    $noticiaCortada = (strlen($noticia['contenido']) > 150) 
                        ? substr($noticia['contenido'], 0, 150) . "..." 
                        : $noticia['contenido'];

                    echo "<div class='col-md-6 col-lg-4 mb-4'>";
                    echo "  <div class='card h-100 shadow-sm'>";
                    echo "    <img src='{$imagen}' class='card-img-top' alt='{$noticia['titulo']}' style='height: 200px; object-fit: cover;'>";
                    echo "    <div class='card-body d-flex flex-column'>";
                    echo "      <h5 class='card-title'>{$noticia['titulo']}</h5>";
                    echo "      <p class='card-text text-secondary'>{$noticiaCortada}</p>";
                    echo "      <div class='mt-auto'>";
                    echo "        <hr>";
                    echo "        <p class='text-muted small mb-0'>👤 {$noticia['autor']}</p>";
                    echo "        <p class='text-muted small'>📅 {$noticia['fecha']}</p>";
                    echo "      </div>";
                    echo "    </div>";
                    echo "  </div>";
                    echo "</div>";
                }
                ?>
            </div> </main>

        <footer class="py-4 bg-light text-center border-top">
            <p class="mb-0">&copy; 2025 SOS La Azohía - Todos los derechos reservados</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    </body>
</html>