<?php
$basededatos = "proyecto2025";
$host = "localhost";
$usuariobd = "root";
$password = "";

try {
    // 1. Conexión con PDO
    $dsn = "mysql:host=$host;dbname=$basededatos;charset=utf8mb4";
    $conexion = new PDO($dsn, $usuariobd, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    // (FETCH_ASSOC para que los resultados sean en array asociativo, ejemplo: $usuario['nombre'])

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}





// Tabla Usuarios
$sqlUsuarios = "CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) DEFAULT 'admin' 
)";
$conexion->exec($sqlUsuarios);


// 2. Tabla Noticias
$sqlNoticias = "CREATE TABLE IF NOT EXISTS noticias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT NOT NULL,
    fecha DATE NOT NULL DEFAULT (CURRENT_DATE),
    imagen VARCHAR(255),
    autor VARCHAR(100) NOT NULL,
    likes INT DEFAULT 0
)";
$conexion->exec($sqlNoticias);


// 3. Tabla Productos
//Se crea después de users porque tiene una clave foránea
$sqlProductos = "CREATE TABLE IF NOT EXISTS productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(8,2),
    imagen VARCHAR(255),
    vendedor INT,
    stock INT DEFAULT 0, 
    categoria VARCHAR(255),
    CONSTRAINT fk_vendedor FOREIGN KEY (vendedor) REFERENCES users(id) ON DELETE CASCADE
)";
$conexion->exec($sqlProductos);


    // 4. Tabla Información (Para la página Quiénes Somos)
$sqlInfo = "CREATE TABLE IF NOT EXISTS informacion (
    id INT PRIMARY KEY, 
    titulo VARCHAR(255),
    nosotros TEXT,
    problema TEXT,
    video VARCHAR(255),
    imagen VARCHAR(255)
)";
$conexion->exec($sqlInfo);



// -------------------------------------------CREAR ADMINISTRADOR PRINCIPAL--------------------------------------------------

// Comprobamos si hay usuarios
$comprobar = $conexion->query("SELECT COUNT(*) as total FROM users");
$total = $comprobar->fetchColumn();

if ($total == 0) {
    $nombre = 'Carlos';
    $email = 'carlosalcazarnavarro@gmail.com';
    $pass = password_hash("1234", PASSWORD_DEFAULT);
    $rol = 'admin';

    $sqlInsert = "INSERT INTO users (nombre, email, password, rol) VALUES (:nombre, :email, :pass, :rol)";
    $stmt = $conexion->prepare($sqlInsert);
    $stmt->execute([
        ':nombre' => $nombre,
        ':email'  => $email,
        ':pass'   => $pass,
        ':rol'    => $rol
    ]);

}