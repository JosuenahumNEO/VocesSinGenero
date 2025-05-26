<?php
require __DIR__ . '/vendor/autoload.php';

// Cargar DotEnv solo en entorno local (opcional)
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
}

function conectarDB() {
    // Variables para Railway (sobrescriben las de .env si existen)
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $usuario = $_ENV['DB_USER'] ?? 'root';
    $password = $_ENV['DB_PASSWORD'] ?? '';
    $base_datos = $_ENV['DB_NAME'] ?? 'voces_db';
    $puerto = $_ENV['DB_PORT'] ?? '3306'; // Puerto por defecto de MySQL

    $conn = new mysqli($host, $usuario, $password, $base_datos, $puerto);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    return $conn;
}
?>