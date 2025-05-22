<?php
// modelo/conexion_bd.php
//localhost | railway.app |
$host = 'localhost'; // El servidor de la base de datos
$dbname = 'vsg';     // railway 
$user = 'root';      // El usuario de la base de datos
$password = '';      //TxTfAOzAsazNLEuCTWgdrFLmiYbYxOmy
$port = 3306;        // 3306

// Crear conexión
$conexion = new mysqli($host, $user, $password, $dbname, $port);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conexion->set_charset("utf8");
?>
