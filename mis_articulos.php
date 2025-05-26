<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
    exit;
}

$conn = conectarDB();
$result = $conn->query("SELECT p.id, p.titulo, p.fecha FROM posts p ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestionar Artículos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f4f4; }
    .table-container {
      max-width: 900px;
      margin: 4rem auto;
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .btn-edit { background-color: #ffc107; color: #fff; }
    .btn-delete { background-color: #dc3545; color: #fff; }
  </style>
</head>
<body>

<div class="table-container">
  <h2 class="text-center mb-4">Mis Artículos</h2>
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Fecha</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['titulo']) ?></td>
          <td><?= date("d M Y - h:i a", strtotime($row['fecha'])) ?></td>
          <td>
            <a href="editar_post.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-edit">Editar</a>
            <a href="eliminar_post.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-delete" onclick="return confirm('Seguro que deseas eliminar este artículo?');">Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
