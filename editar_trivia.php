<?php
require_once 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$conn = conectarDB();
$trivia_id = $_GET['id'] ?? null;

if (!$trivia_id) {
    $_SESSION['mensaje'] = "ID de trivia no válido.";
    header("Location: admin_panel.php");
    exit;
}

// Obtener datos de la trivia (asumiendo múltiples preguntas por post_id)
$stmt = $conn->prepare("SELECT * FROM trivias WHERE post_id = (SELECT post_id FROM trivias WHERE id = ?)");
$stmt->bind_param("i", $trivia_id);
$stmt->execute();
$resultado = $stmt->get_result();
$trivias = $resultado->fetch_all(MYSQLI_ASSOC);

$post_id = $trivias[0]['post_id'] ?? null;

// Obtener lista de artículos
$posts = $conn->query("SELECT id, titulo FROM posts ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Trivia</title>
  <link rel="stylesheet" href="css/global.css">
  <style>
    body {
      background-color: #121212;
      font-family: Arial, sans-serif;
      color: white;
      padding: 2rem;
    }

    .container {
      max-width: 800px;
      margin: auto;
      background-color: #1e1e1e;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }

    .alert.success {
      background-color: #19bc70;
      color: white;
      padding: 1rem;
      border-radius: 8px;
      margin-bottom: 1rem;
      text-align: center;
    }

    h1 {
      text-align: center;
      color: #19bc70;
    }

    label {
      display: block;
      margin-top: 1rem;
    }

    input[type="text"],
    textarea,
    select {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      background-color: #2c2c2c;
      border: 1px solid #555;
      color: white;
      margin-bottom: 0.5rem;
    }

    input[type="file"] {
      margin: 1rem 0;
      color: white;
    }

    .btn {
      background-color: #19bc70;
      border: none;
      padding: 10px 20px;
      color: white;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 1.5rem;
      display: inline-block;
    }

    .btn:hover {
      background-color: #15995d;
    }

    .trivia-box {
      background: #2a2a2a;
      padding: 1rem;
      border-radius: 8px;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Editar Trivia</h1>

    <?php if (!empty($_SESSION['mensaje'])): ?>
      <div class="alert success"><?= $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
    <?php endif; ?>

    <form action="procesar_editar_trivia.php" method="POST" enctype="multipart/form-data">
      <label>Artículo relacionado:</label>
      <select name="post_id" required>
        <?php while ($p = $posts->fetch_assoc()): ?>
          <option value="<?= $p['id'] ?>" <?= ($p['id'] == $post_id ? 'selected' : '') ?>>
            <?= htmlspecialchars($p['titulo']) ?>
          </option>
        <?php endwhile; ?>
      </select>

      <label>Nueva portada (opcional):</label>
      <input type="file" name="portada" accept="image/*">

      <?php foreach ($trivias as $index => $trivia): ?>
        <div class="trivia-box">
          <input type="hidden" name="trivia_ids[]" value="<?= $trivia['id'] ?>">

          <label>Pregunta <?= $index + 1 ?>:</label>
          <textarea name="pregunta[]"><?= htmlspecialchars($trivia['pregunta']) ?></textarea>

          <label>Opción A:</label>
          <input type="text" name="opcion_a[]" value="<?= htmlspecialchars($trivia['opcion_a']) ?>">

          <label>Opción B:</label>
          <input type="text" name="opcion_b[]" value="<?= htmlspecialchars($trivia['opcion_b']) ?>">

          <label>Opción C:</label>
          <input type="text" name="opcion_c[]" value="<?= htmlspecialchars($trivia['opcion_c']) ?>">

          <label>Opción D:</label>
          <input type="text" name="opcion_d[]" value="<?= htmlspecialchars($trivia['opcion_d']) ?>">

          <label>Respuesta correcta:</label>
          <select name="respuesta_correcta[]">
            <option value="A" <?= $trivia['respuesta_correcta'] == 'A' ? 'selected' : '' ?>>A</option>
            <option value="B" <?= $trivia['respuesta_correcta'] == 'B' ? 'selected' : '' ?>>B</option>
            <option value="C" <?= $trivia['respuesta_correcta'] == 'C' ? 'selected' : '' ?>>C</option>
            <option value="D" <?= $trivia['respuesta_correcta'] == 'D' ? 'selected' : '' ?>>D</option>
          </select>
        </div>
      <?php endforeach; ?>

      <button type="submit" class="btn">Guardar Cambios</button>
    </form>
  </div>
</body>
</html>
