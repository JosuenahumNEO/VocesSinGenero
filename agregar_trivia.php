<?php
require_once 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$conn = conectarDB();
$result = $conn->query("SELECT id, titulo FROM posts ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Trivia</title>
  <link rel="stylesheet" href="css/global.css">
  <style>
    body {
      background-color: #121212;
      font-family: Arial, sans-serif;
      color: white;
      padding: 2rem;
    }

    .container {
      max-width: 700px;
      margin: auto;
      background-color: #1e1e1e;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }

    h1 {
      text-align: center;
      color: #19bc70;
      margin-bottom: 2rem;
    }

    label {
      display: block;
      margin: 1rem 0 0.5rem;
      color: #ccc;
    }

    select,
    input[type="text"],
    textarea {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #333;
      background-color: #2a2a2a;
      color: white;
      font-size: 1rem;
    }

    button {
      background-color: #19bc70;
      color: white;
      padding: 0.75rem 1.5rem;
      margin-top: 1.5rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      background-color: #15995d;
    }

    a {
      color: #19bc70;
      text-decoration: none;
      display: inline-block;
      margin-top: 1rem;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Agregar pregunta de trivia</h1>

    <form action="procesar_trivia.php" method="POST" enctype="multipart/form-data">
      <label for="post_id">Artículo relacionado:</label>
      <select name="post_id" required>
        <option value="">Selecciona un artículo</option>
        <?php while ($row = $result->fetch_assoc()): ?>
          <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['titulo']) ?></option>
        <?php endwhile; ?>
      </select>

      <label for="portada">Imagen de portada:</label>
      <input type="file" name="portada" accept="image/*" required>
      
      <?php for ($i = 1; $i <= 5; $i++): ?>
    <fieldset style="margin-bottom: 2rem; border: 1px solid #444; padding: 1rem; border-radius: 8px;">

        <label>Pregunta <?= $i ?>:</label>
        <textarea name="pregunta[]" required></textarea>

        <label>Opción A:</label>
        <input type="text" name="opcion_a[]" required>

        <label>Opción B:</label>
        <input type="text" name="opcion_b[]" required>

        <label>Opción C:</label>
        <input type="text" name="opcion_c[]" required>

        <label>Opción D:</label>
        <input type="text" name="opcion_d[]" required>

        <label>Respuesta correcta:</label>
        <select name="respuesta_correcta[]" required>
        <option value="">Selecciona</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
        </select>
    </fieldset>
    <?php endfor; ?>


      <button type="submit">Guardar Trivia</button>
    </form>

    <a href="admin_panel.php">⬅ Volver al panel de administración</a>
  </div>
</body>
</html>