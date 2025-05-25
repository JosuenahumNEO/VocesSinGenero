<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(403);
    echo "Debes iniciar sesión para comentar.";
    exit;
}

require_once 'conexion.php';
$conn = conectarDB();

$usuario_id = $_SESSION['usuario_id'];
$post_id = $_POST['post_id'] ?? null;
$contenido = trim($_POST['contenido'] ?? '');

if (!$post_id || strlen($contenido) < 5) {
    http_response_code(400);
    echo "Comentario inválido.";
    exit;
}

$stmt = $conn->prepare("INSERT INTO comentarios (usuario_id, post_id, contenido, fecha) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iis", $usuario_id, $post_id, $contenido);

if ($stmt->execute()) {
    echo "Comentario guardado correctamente.";
} else {
    http_response_code(500);
    echo "Error al guardar el comentario.";
}

$stmt->close();
$conn->close();
?>
