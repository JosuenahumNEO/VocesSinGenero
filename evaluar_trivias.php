<?php
require_once 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "mensaje" => "Acceso no válido"]);
    exit;
}

$conn = conectarDB();
$resultado = [];

foreach ($_POST as $key => $valor) {
    if (strpos($key, "pregunta_") === 0) {
        $id_pregunta = str_replace("pregunta_", "", $key);
        $respuesta_usuario = $conn->real_escape_string($valor);

        $stmt = $conn->prepare("SELECT respuesta_correcta FROM trivias WHERE id = ?");
        $stmt->bind_param("i", $id_pregunta);
        $stmt->execute();
        $stmt->bind_result($respuesta_correcta);
        $stmt->fetch();
        $stmt->close();

        $resultado[$id_pregunta] = [
            "correcta" => $respuesta_correcta,
            "usuario" => $respuesta_usuario,
            "es_correcta" => $respuesta_usuario === $respuesta_correcta
        ];
    }
}

echo json_encode(["success" => true, "resultado" => $resultado]);
?>
