<?php
function conectarDB() {
    $host = "localhost";
    $usuario = "root";
    $password = "";
    $base_datos = "voces_db"; // Cambiado de voces_blog a voces_db

    $conn = new mysqli($host, $usuario, $password, $base_datos);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    return $conn;
}
?>
