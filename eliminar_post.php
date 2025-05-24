<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    echo "<script>alert('ID de artículo no válido.'); window.location.href='mis_articulos.php';</script>";
    exit;
}

$conn = conectarDB();

// Opcional: eliminar imágenes del servidor (si lo deseas)
$stmt = $conn->prepare("SELECT portada, imagen_general, imagen_aside FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$datos = $result->fetch_assoc();
$stmt->close();

if ($datos) {
    @unlink($datos['portada']);
    @unlink($datos['imagen_general']);
    @unlink($datos['imagen_aside']);
}

// Eliminar el post
$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo "<script>alert('Artículo eliminado exitosamente.'); window.location.href='admin_panel.php';</script>";
} else {
    echo "<script>alert('Error al eliminar el artículo.'); window.location.href='admin_panel.php';</script>";
}

$stmt->close();
$conn->close();
?>
