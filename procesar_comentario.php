<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "No tienes permiso para comentar.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contenido = trim($_POST['contenido']);
    $post_id = intval($_POST['post_id']);
    $usuario_id = $_SESSION['usuario_id'];

    if (strlen($contenido) < 2 || strlen($contenido) > 500) {
        echo "El comentario debe tener entre 2 y 500 caracteres.";
        exit;
    }

    $conn = conectarDB();
    $stmt = $conn->prepare("INSERT INTO comentarios (contenido, post_id, usuario_id, fecha) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sii", $contenido, $post_id, $usuario_id);

    if ($stmt->execute()) {
        header("Location: articulo.php?id=$post_id"); // 🔁 Redirigir al artículo
        exit;
    } else {
        echo "Error al guardar el comentario.";
    }

    $stmt->close();
    $conn->close();
}
?>
