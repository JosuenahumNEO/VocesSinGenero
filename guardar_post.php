<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    echo "<script>alert('No tienes permisos para publicar.'); window.location.href='index.php';</script>";
    exit;
}

$titulo = trim($_POST['titulo']);
$contenido = trim($_POST['contenido']);
$etiquetas = trim($_POST['etiquetas']);
$descripcion_aside = trim($_POST['descripcion_aside']);
$autor_id = $_SESSION['usuario_id'];

// Función para subir imagen
function subirImagen($inputName, $folder) {
    if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === 0) {
        $dir = "images/$folder/";
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $nombreArchivo = uniqid() . "_" . basename($_FILES[$inputName]['name']);
        $rutaFinal = $dir . $nombreArchivo;
        if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $rutaFinal)) {
            return $rutaFinal;
        }
    }
    return "";
}

// Subir imágenes
$portada = subirImagen('portada', 'portadas');
$imagen_general = subirImagen('imagen_general', 'general');
$imagen_aside = subirImagen('imagen_aside', 'aside');

// Guardar en base de datos
$conn = conectarDB();
$stmt = $conn->prepare("
    INSERT INTO posts (titulo, contenido, etiquetas, portada, imagen_general, imagen_aside, descripcion_aside, autor_id, fecha)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
");

$stmt->bind_param("sssssssi", $titulo, $contenido, $etiquetas, $portada, $imagen_general, $imagen_aside, $descripcion_aside, $autor_id);

if ($stmt->execute()) {
    $post_id = $conn->insert_id;
    echo "<script>alert('Artículo publicado correctamente.'); window.location.href='articulo.php?id=$post_id';</script>";
} else {
    echo "Error al guardar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
