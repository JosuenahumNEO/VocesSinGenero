<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "vsg";

$conexion = mysqli_connect($host, $user, $password, $dbname);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Configurar caracteres a UTF-8
mysqli_set_charset($conexion, "utf8");
?>
