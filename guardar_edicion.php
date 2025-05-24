<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
    exit;
}

$conn = conectarDB();

$id = $_POST['id'];
$titulo = trim($_POST['titulo']);
$contenido = trim($_POST['contenido']);
$etiquetas = trim($_POST['etiquetas']);
$descripcion_aside = trim($_POST['descripcion_aside']);

// Subir nuevas imágenes si se proporcionan
function subirImagen($input, $folder) {
    if (isset($_FILES[$input]) && $_FILES[$input]['error'] === 0) {
        $dir = "images/$folder/";
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $nombre = uniqid() . "_" . basename($_FILES[$input]['name']);
        $ruta = $dir . $nombre;
        if (move_uploaded_file($_FILES[$input]['tmp_name'], $ruta)) return $ruta;
    }
    return null;
}

$portada = subirImagen('portada', 'portadas');
$imagen_general = subirImagen('imagen_general', 'general');
$imagen_aside = subirImagen('imagen_aside', 'aside');

// Obtener datos actuales
$stmt = $conn->prepare("SELECT portada, imagen_general, imagen_aside FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$actual = $res->fetch_assoc();
$stmt->close();

// Usar las nuevas rutas o mantener las anteriores
$portada = $portada ?? $actual['portada'];
$imagen_general = $imagen_general ?? $actual['imagen_general'];
$imagen_aside = $imagen_aside ?? $actual['imagen_aside'];

// Actualizar el post
$stmt = $conn->prepare("
    UPDATE posts SET titulo=?, contenido=?, etiquetas=?, portada=?, imagen_general=?, imagen_aside=?, descripcion_aside=?
    WHERE id=?
");
$stmt->bind_param("sssssssi", $titulo, $contenido, $etiquetas, $portada, $imagen_general, $imagen_aside, $descripcion_aside, $id);

if ($stmt->execute()) {
    echo "<script>alert('Artículo actualizado correctamente.'); window.location.href='articulo.php?id=$id';</script>";
} else {
    echo "Error al actualizar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
