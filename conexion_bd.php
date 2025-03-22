<?php
// modelo/conexion_bd.php

$host = 'localhost'; // El servidor de la base de datos
$dbname = 'vsg';     // El nombre de la base de datos
$user = 'root';      // El usuario de la base de datos (por defecto es 'root' en XAMPP)
$password = '';      // La contraseña de la base de datos (por defecto está vacía en XAMPP)
$port = 3306;        // El puerto de la base de datos
try {
    $conexion = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password);
    // Configurar el manejo de errores
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configurar el juego de caracteres a UTF-8
    $conexion->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>