<?php
date_default_timezone_set('America/Mexico_City');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se envió un comentario
    if(empty($_POST["comentario"])) {
        header("Location: opiniones.php?error=" . urlencode("El comentario no puede estar vacío"));
        exit;
    }

    $comentario = trim($_POST["comentario"]);
    
    // Validar longitud del comentario
    if(strlen($comentario) > 500) {
        header("Location: opiniones.php?error=" . urlencode("El comentario no puede exceder los 500 caracteres"));
        exit;
    }

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "vsg");
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    
    // Insertar en la base de datos
    $stmt = $conexion->prepare("INSERT INTO opiniones (comentario) VALUES (?)");
    $stmt->bind_param("s", $comentario);
    
    if ($stmt->execute()) {
        // Registrar en archivo
        $fechaHora = date('Y-m-d H:i:s');
        $registro = "--- OPINIÓN ANÓNIMA ---\nFecha: $fechaHora\nComentario: $comentario\n\n";
        file_put_contents("opiniones_ANONIMAS.txt", $registro, FILE_APPEND);
        
        header("Location: opiniones.php?success=true");
    } else {
        header("Location: opiniones.php?error=" . urlencode("Error al guardar el comentario"));
    }

    $stmt->close();
    $conexion->close();
    exit;
}
?>