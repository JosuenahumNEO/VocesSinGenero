<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

date_default_timezone_set('America/Mexico_City');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se envió un comentario
    if(empty($_POST["comentario"])) {
        header("Location: opiniones_panel.php?error=" . urlencode("El comentario no puede estar vacío"));
        exit;
    }

    $comentario = trim($_POST["comentario"]);
    
    // Validar longitud del comentario
    if(strlen($comentario) > 500) {
        header("Location: opiniones_panel.php?error=" . urlencode("El comentario no puede exceder los 500 caracteres"));
        exit;
    }

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "voces_db");
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    
    // Insertar en la base de datos
    $stmt = $conexion->prepare("INSERT INTO opiniones (comentario) VALUES (?)");

    if ($stmt === false) {
        die("Error en prepare: " . $conexion->error);
    }

    $stmt->bind_param("s", $comentario);

    
    if ($stmt->execute()) {
        // Registrar en archivo
        $fechaHora = date('Y-m-d H:i:s');
        $registro = "--- OPINIÓN ANÓNIMA ---\nFecha: $fechaHora\nComentario: $comentario\n\n";
        file_put_contents("opiniones_ANONIMAS.txt", $registro, FILE_APPEND);
        
        header("Location: opiniones_panel.php?success=true");
    } else {
        header("Location: opiniones_panel.php?error=" . urlencode("Error al guardar el comentario"));
    }

    $stmt->close();
    $conexion->close();
    exit;
}
?>