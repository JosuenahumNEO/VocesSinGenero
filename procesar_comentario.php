<?php
session_start();
require 'conexion_bd.php';

if (isset($_POST['contenido'], $_POST['id_publicacion'], $_SESSION['usuario_id'])) {
    $contenido = trim($_POST['contenido']);
    $id_publicacion = intval($_POST['id_publicacion']);
    $id_usuario = $_SESSION['usuario_id'];

    if (!empty($contenido)) {
        $stmt = $conexion->prepare("INSERT INTO comentarios (id_publicacion, id_usuario, contenido) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id_publicacion, $id_usuario, $contenido);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: plantilla.php?id=$id_publicacion");
exit;
?>
