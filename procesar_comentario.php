<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$post_id = $_POST['post_id'];
$contenido = trim($_POST['contenido']);

if (empty($contenido)) {
    header("Location: articulo.php?id=$post_id");
    exit;
}

$conn = conectarDB();
$stmt = $conn->prepare("INSERT INTO comentarios (contenido, post_id, usuario_id, fecha) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sii", $contenido, $post_id, $usuario_id);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: articulo.php?id=$post_id");
exit;
