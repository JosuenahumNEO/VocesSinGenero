<?php
session_start();
include(__DIR__ . '/conexion_bd.php');

date_default_timezone_set('America/Mexico_City');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['titulo'])) {
    // Validaciones iniciales
    $errores = [];
    $camposRequeridos = ['titulo', 'descripcion'];
    
    // Validar campos vacíos
    foreach ($camposRequeridos as $campo) {
        if (empty(trim($_POST[$campo]))) {
            $errores[] = "El campo " . ucfirst($campo) . " es obligatorio";
        }
    }
    
    // Sanitizar datos
    $titulo = mysqli_real_escape_string($conexion, trim($_POST['titulo']));
    $descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion']));
    
    // Validar longitud
    if (strlen($titulo) > 255) {
        $errores[] = "El título no puede exceder 255 caracteres";
    }
    
    // Procesamiento de imágenes
    $uploadsDir = __DIR__ . '/uploads/';
    $imagenesPermitidas = ['image/jpeg', 'image/png', 'image/gif'];
    $nombresImagenes = ['imagen1' => null, 'imagen2' => null, 'imagen3' => null];
    
    // Crear directorio si no existe
    if (!is_dir($uploadsDir)) {
        if (!mkdir($uploadsDir, 0755, true)) {
            $errores[] = "Error al crear el directorio de uploads";
        }
    }
    
    // Validar y mover imágenes
    if (empty($errores)) {
        foreach (['imagen_cabecera', 'imagen_cuerpo1', 'imagen_cuerpo2'] as $key => $inputName) {
            if (!empty($_FILES[$inputName]['name'])) {
                $archivo = $_FILES[$inputName];
                $tipoReal = mime_content_type($archivo['tmp_name']);
                
                if (!in_array($tipoReal, $imagenesPermitidas)) {
                    $errores[] = "El archivo " . ($key + 1) . " no es una imagen válida";
                    continue;
                }
                
                $nombreSeguro = uniqid('img_', true) . '.' . pathinfo($archivo['name'], PATHINFO_EXTENSION);
                $rutaDestino = $uploadsDir . $nombreSeguro;
                
                if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
                    $errores[] = "Error al subir la imagen " . ($key + 1);
                } else {
                    $nombresImagenes['imagen' . ($key + 1)] = $nombreSeguro;
                }
            }
        }
    }
    
    // Insertar en base de datos si no hay errores
    if (empty($errores)) {
        $stmt = $conexion->prepare("INSERT INTO publicaciones 
            (titulo, descripcion, imagen1, imagen2, imagen3) 
            VALUES (?, ?, ?, ?, ?)");
        
        $stmt->bind_param(
            'sssss',
            $titulo,
            $descripcion,
            $nombresImagenes['imagen1'],
            $nombresImagenes['imagen2'],
            $nombresImagenes['imagen3']
        );
        
        if ($stmt->execute()) {
            // Log de actividad
            $log = sprintf(
                "---NUEVA PUBLICACIÓN---\nFecha: %s\nTítulo: %s\nUsuario: %s\n\n",
                date('Y-m-d H:i:s'),
                $titulo,
                $_SESSION['admin']['nombre']
            );
            file_put_contents(__DIR__ . "/registros.txt", $log, FILE_APPEND);
            
            $_SESSION['success'] = true;
        } else {
            // Eliminar imágenes subidas si falla la inserción
            foreach ($nombresImagenes as $archivo) {
                if ($archivo && file_exists($uploadsDir . $archivo)) {
                    unlink($uploadsDir . $archivo);
                }
            }
            $errores[] = "Error al guardar la publicación: " . $stmt->error;
        }
        $stmt->close();
    }
    
    // Manejo de errores
    if (!empty($errores)) {
        $_SESSION['error'] = implode("\n", $errores);
    }
    
    header("Location: admin.php");
    exit();
}
?>