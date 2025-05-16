<?php
session_start();
include(__DIR__ . '/conexion_bd.php');

date_default_timezone_set('America/Mexico_City');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registro'])) {
    // Validar campos vacíos
    $camposRequeridos = ['nombre', 'correo', 'password', 'confirm_password'];
    $camposVacios = array_filter($camposRequeridos, fn($campo) => empty($_POST[$campo]));
    
    if (!empty($camposVacios)) {
        $_SESSION['error_registro'] = "Todos los campos son obligatorios";
    } else {
        // Limpiar y validar datos
        $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
        $correo = mysqli_real_escape_string($conexion, trim($_POST['correo']));
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);

        // Validaciones
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_registro'] = "Formato de correo electrónico inválido";
        } elseif ($password !== $confirm_password) {
            $_SESSION['error_registro'] = "Las contraseñas no coinciden";
        } elseif (strlen($password) < 8) {
            $_SESSION['error_registro'] = "La contraseña debe tener al menos 8 caracteres";
        } else {
            // Verificar usuario existente
            $stmt_check = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = ? OR correo = ?");
            $stmt_check->bind_param("ss", $nombre, $correo);
            $stmt_check->execute();
            $stmt_check->store_result();
            
            if ($stmt_check->num_rows > 0) {
                $_SESSION['error_registro'] = "El nombre de usuario o correo ya está registrado";
            } else {
                // Hash de contraseña (encriptación)
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Insertar usuario
                $stmt = $conexion->prepare("INSERT INTO usuarios (usuario, correo, contraseña, fecha_registro) VALUES (?, ?, ?, NOW())");
                $stmt->bind_param("sss", $nombre, $correo, $password_hash);
                
                if ($stmt->execute()) {
                    // Log de registro
                    $log = sprintf(
                        "---NUEVO REGISTRO---\nFecha: %s\nNombre: %s\nCorreo: %s\n\n",
                        date('Y-m-d H:i:s'),
                        $nombre,
                        $correo
                    );
                    file_put_contents(__DIR__ . "/registros.txt", $log, FILE_APPEND);
                    
                    $_SESSION['success_registro'] = "¡Registro exitoso! Ahora puedes iniciar sesión";
                } else {
                    $_SESSION['error_registro'] = "Error al registrar: " . $stmt->error;
                }
                $stmt->close();
            }
            $stmt_check->close();
        }
    }
    header("Location: LOGIN.php");
    exit();
}
?>