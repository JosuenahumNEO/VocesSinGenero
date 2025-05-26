<?php
require_once 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$conn = conectarDB();

$post_id = $_POST['post_id'];
$trivia_ids = $_POST['trivia_ids'];
$preguntas = $_POST['pregunta'];
$opciones_a = $_POST['opcion_a'];
$opciones_b = $_POST['opcion_b'];
$opciones_c = $_POST['opcion_c'];
$opciones_d = $_POST['opcion_d'];
$respuestas = $_POST['respuesta_correcta'];

// Cargar nueva portada si se subió
if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
    $nombreTmp = $_FILES['portada']['tmp_name'];
    $nombreArchivo = basename($_FILES['portada']['name']);
    $rutaDestino = "uploads/trivias/" . time() . "_" . $nombreArchivo;

    if (!is_dir("uploads/trivias")) {
        mkdir("uploads/trivias", 0755, true);
    }

    move_uploaded_file($nombreTmp, $rutaDestino);

    // Actualizar todas las preguntas de ese post con la nueva portada
    $conn->query("UPDATE trivias SET portada = '$rutaDestino' WHERE post_id = $post_id");
}

// Actualizar preguntas
$stmt = $conn->prepare("
    UPDATE trivias SET
    pregunta = ?, opcion_a = ?, opcion_b = ?, opcion_c = ?, opcion_d = ?, respuesta_correcta = ?
    WHERE id = ?
");

for ($i = 0; $i < count($trivia_ids); $i++) {
    $stmt->bind_param(
        "ssssssi",
        $preguntas[$i],
        $opciones_a[$i],
        $opciones_b[$i],
        $opciones_c[$i],
        $opciones_d[$i],
        $respuestas[$i],
        $trivia_ids[$i]
    );
    $stmt->execute();
}

$stmt->close();
$conn->close();

$_SESSION['mensaje'] = "Trivia actualizada correctamente.";
header("Location: admin_panel.php");
exit;
