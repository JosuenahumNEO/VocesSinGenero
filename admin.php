<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
    exit;
}

require_once 'conexion.php';
$conn = conectarDB();
$result = $conn->query("SELECT id, titulo, fecha FROM posts ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
  <div class="admin-container">
    <aside class="sidebar">
      <h2>Voces sin Género</h2>
      <nav>
        <ul>
          <li><a href="crear_post.php">Crear Publicación</a></li>
          <li><a href="#gestion" onclick="mostrarSeccion('gestion')">Gestionar Publicaciones</a></li>
        </ul>
      </nav>
      <div class="logout">
        <p>Bienvenid@, [Admin]</p>
        <form action="logout.php" method="POST">
          <button type="submit">Cerrar Sesión</button>
        </form>
      </div>
    </aside>

    <main class="main-panel">
      <section id="gestion">
        <h2>Gestor de Publicaciones</h2>
        <table>
          <thead>
            <tr>
              <th>Título</th>
              <th>Fecha</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['titulo']) ?></td>
                <td><?= date("d M Y - H:i", strtotime($row['fecha'])) ?></td>
                <td>
                  <a href="editar_post.php?id=<?= $row['id'] ?>" class="btn-edit">Editar</a>
                  <a href="eliminar_post.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('¿Estás segur@ que deseas eliminar este artículo?')">Eliminar</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>

  <script>
    function mostrarSeccion(id) {
      document.querySelectorAll('main section').forEach(sec => sec.style.display = 'none');
      document.getElementById(id).style.display = 'block';
    }
    mostrarSeccion('gestion');
  </script>
</body>
</html>

<?php
$conn->close();
?>
