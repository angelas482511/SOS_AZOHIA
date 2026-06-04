<?php
session_start();

if (isset($_GET['index']) && isset($_SESSION['cesta'])) {
    $index = $_GET['index'];
    
    // Check if the index exists in the array before unsetting
    if (isset($_SESSION['cesta'][$index])) {
        unset($_SESSION['cesta'][$index]);
        // Re-index array so we don't have gaps
        $_SESSION['cesta'] = array_values($_SESSION['cesta']);
    }
}

header("Location: donacion.php?msj=eliminado_item");
exit();
?>
