<?php
date_default_timezone_set('America/Mexico_City');
$fechaHora = date('Y-m-d H:i:s');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Declaración de variables
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $confirmarcontrasena = $_POST["confirmarcontrasena"];
    

    // Validación básica
    if (!empty($nombre) && !empty($correo) && !empty($contrasena) && !empty($confirmarcontrasena)) {
        if ($contrasena !== $confirmarcontrasena) {
            die("Las contraseñas no coinciden");
        }

        // Conexión segura con MySQLi
        $conexion = mysqli_connect("localhost", "root", "", "vsg");
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Sentencia preparada para evitar SQL Injection
        $stmt = $conexion->prepare("INSERT INTO usuarios(usuario, correo, contraseña) VALUES (?, ?, ?)");
        $password_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $nombre, $correo, $password_hash);
        
        if ($stmt->execute()) {
            // Registro en archivo
            $informacionmandada = "---NUEVO REGISTRO---\nFecha: $fechaHora\nNombre: $nombre\nCorreo: $correo\n";
            file_put_contents("registros.txt", $informacionmandada, FILE_APPEND);
            
            exit;
        } else {
            die("Error al insertar: " . $stmt->error);
        }
    }
}
?>