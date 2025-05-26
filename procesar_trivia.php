<?php
require_once 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$conn = conectarDB();

$post_id = $_POST['post_id'];
$preguntas = $_POST['pregunta'];
$opciones_a = $_POST['opcion_a'];
$opciones_b = $_POST['opcion_b'];
$opciones_c = $_POST['opcion_c'];
$opciones_d = $_POST['opcion_d'];
$respuestas = $_POST['respuesta_correcta'];

// Manejo de la portada
$portada = null;

if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = uniqid() . '_' . basename($_FILES['portada']['name']);
    $rutaDestino = 'uploads/trivias/' . $nombreArchivo;

    if (!is_dir('uploads/trivias')) {
        mkdir('uploads/trivias', 0777, true);
    }

    if (move_uploaded_file($_FILES['portada']['tmp_name'], $rutaDestino)) {
        $portada = $rutaDestino;
    }
}

// Insertar cada pregunta con la misma portada
$stmt = $conn->prepare("INSERT INTO trivias (post_id, pregunta, opcion_a, opcion_b, opcion_c, opcion_d, respuesta_correcta, portada) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

for ($i = 0; $i < count($preguntas); $i++) {
    $stmt->bind_param(
        "isssssss",
        $post_id,
        $preguntas[$i],
        $opciones_a[$i],
        $opciones_b[$i],
        $opciones_c[$i],
        $opciones_d[$i],
        $respuestas[$i],
        $portada
    );
    $stmt->execute();
}

$stmt->close();
$conn->close();

header("Location: admin_panel.php");
exit;
?>
