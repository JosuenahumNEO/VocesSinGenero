<?php
require_once 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $conn = conectarDB();
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM trivias WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    $_SESSION['mensaje'] = "Trivia eliminada correctamente.";
}

header("Location: admin_panel.php");
exit;
