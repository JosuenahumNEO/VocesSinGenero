<?php
session_start();
<<<<<<< HEAD
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
=======
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Mexico_City');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar sesión
    if (!isset($_SESSION['admin'])) {
        $_SESSION['error'] = "Acceso no autorizado";
        header("Location: login_admin.php");
        exit;
    }

    // Validar campos obligatorios
    if (empty($_POST["titulo"]) || empty($_POST["contenido"])) {
        $_SESSION['error'] = "Título y contenido son obligatorios";
        header("Location: admin.php");
        exit;
    }

    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "vsg");
    if (!$conexion) {
        $_SESSION['error'] = "Error de conexión: " . mysqli_connect_error();
        header("Location: admin.php");
        exit;
    }

    // Función para subir imágenes
    function subirImagen($nombreArchivo) {
        if (empty($_FILES[$nombreArchivo]['name'])) {
            return null;
        }
        
        $directorio = "uploads/";
        if (!is_dir($directorio)) {
            if (!mkdir($directorio, 0755, true)) {
                $_SESSION['error'] = "Error al crear directorio de uploads";
                return false;
            }
        }

        $nombreUnico = uniqid() . '_' . basename($_FILES[$nombreArchivo]['name']);
        $rutaCompleta = $directorio . $nombreUnico;
        $tipoArchivo = strtolower(pathinfo($rutaCompleta, PATHINFO_EXTENSION));

        // Validaciones
        $permitidos = ['jpg', 'jpeg', 'png', 'gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($tipoArchivo, $permitidos)) {
            $_SESSION['error'] = "Solo se permiten imágenes JPG, JPEG, PNG y GIF";
            return false;
        }

        if ($_FILES[$nombreArchivo]['size'] > $maxSize) {
            $_SESSION['error'] = "La imagen excede el tamaño máximo permitido (5MB)";
            return false;
        }

        if (!move_uploaded_file($_FILES[$nombreArchivo]['tmp_name'], $rutaCompleta)) {
            $_SESSION['error'] = "Error al subir el archivo";
            return false;
        }
        
        return $rutaCompleta;
    }

    // Procesar imágenes
    try {
        $imagenCabecera = subirImagen('imagen_cabecera');
        if ($imagenCabecera === false) exit;

        $imagenCuerpo1 = subirImagen('imagen_cuerpo1');
        if ($imagenCuerpo1 === false) exit;

        $imagenCuerpo2 = subirImagen('imagen_cuerpo2');
        if ($imagenCuerpo2 === false) exit;

        // Insertar en la base de datos
        $stmt = $conexion->prepare("INSERT INTO publicaciones 
            (titulo, contenido, imagen_cabecera, imagen_cuerpo1, imagen_cuerpo2, fecha_publicacion) 
            VALUES (?, ?, ?, ?, ?, NOW())");

        $stmt->bind_param("sssss", 
            $_POST['titulo'],
            $_POST['contenido'],
            $imagenCabecera ?? null,
            $imagenCuerpo1 ?? null,
            $imagenCuerpo2 ?? null
        );

        if ($stmt->execute()) {
            header("Location: admin.php?success=true");
        } else {
            throw new Exception("Error en la base de datos: " . $stmt->error);
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: admin.php");
    } finally {
        if (isset($stmt)) $stmt->close();
        $conexion->close();
    }
    exit;
>>>>>>> 1f02db6c352807683c36e49ae151b2b60fcf0f30
}
?>