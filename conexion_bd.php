<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "vsg";

try {
    $conexion = mysqli_connect($host, $user, $password, $dbname);
    
    if (!$conexion) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
    
    if (!mysqli_set_charset($conexion, "utf8mb4")) {
        throw new Exception("Error al configurar charset: " . mysqli_error($conexion));
    }
    
} catch (Exception $e) {
    die("Error crítico en la conexión: " . $e->getMessage());
}
?>