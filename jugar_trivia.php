<?php
require_once 'conexion.php';
session_start();

$post_id = $_GET['post_id'] ?? null;
if (!$post_id) {
    echo "Trivia no encontrada.";
    exit;
}

$conn = conectarDB();
$stmt = $conn->prepare("SELECT * FROM trivias WHERE post_id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$trivias = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Juego de Trivia</title>
  <link rel="stylesheet" href="css/juegotrivia.css" />
</head>
<body>

<div class="app">
  <h1>¿Leíste bien?<br>¡Comprobémoslo!</h1>
  <div class="quiz">
    <h2 id="question">Cargando pregunta...</h2>
    <div id="answer-buttons"></div>
    <button id="next-btn">Siguiente pregunta</button>
  </div>
</div>

<div style="text-align: center;">
  <a href="articulo.php?id=<?= $_GET['post_id'] ?>" class="btn-exit">Salir</a>
</div>


<script>
  const preguntas = <?= json_encode($trivias) ?>;
</script>
<script src="js/juegotrivia.js"></script>

</body>
</html>
