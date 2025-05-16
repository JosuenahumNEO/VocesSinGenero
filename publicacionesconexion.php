<?php
session_start();
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
}
?>