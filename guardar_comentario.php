<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id']) || !isset($_POST['post_id']) || empty($_POST['comentario'])) {
    header("Location: post.php");
    exit;
}

$post_id = intval($_POST['post_id']);
$usuario_id = $_SESSION['usuario_id'];
$comentario = trim($_POST['comentario']);

$conn = conectarDB();
$stmt = $conn->prepare("INSERT INTO comentarios (post_id, usuario_id, comentario) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $post_id, $usuario_id, $comentario);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: articulo.php?id=" . $post_id);
exit;
?>
