<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    echo "<script>alert('Acceso denegado'); window.location.href='index.php';</script>";
    exit;
}

$conn = conectarDB();
$result = $conn->query("SELECT id, titulo, fecha FROM posts ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
		integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
		crossorigin="anonymous"
		referrerpolicy="no-referrer"
	/>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/admin.css"> <!-- nuevo -->
  <link rel="stylesheet" href="css/footer.css">

  
</head>
<body>

<header>
  <div class="container header-expand">
    <div class="container-logo">
      <img src="images/img/logoblanco.png" alt="Logo">
      <span>Voces Sin Género</span>
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="post.php">Artículos</a></li>
      </ul>
    </nav>
  </div>
</header>

<main class="admin-panel">
  <div class="admin-container">
    <h1>Panel de Administración</h1>

    <div class="admin-section">
      <h2>Crear nueva publicación</h2>
      <a href="crear_post.php" class="btn btn-primary">Ir a crear publicación</a>
    </div>

    <div class="admin-section">
      <h2>Gestionar publicaciones existentes</h2>

      <table class="admin-table">
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
            <td><?= date('d/m/Y H:i', strtotime($row['fecha'])) ?></td>
            <td>
              <a href="editar_post.php?id=<?= $row['id'] ?>" class="btn-edit">Editar</a>
              <a href="eliminar_post.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('¿Seguro que deseas eliminar este artículo?');">Eliminar</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<!-- FOOTER -->
	<footer class="background-dark-2">
		<div class="container">
			<div class="content">
				<div class="container-logo">
					<img src="images/img/logoblanco.png" alt="Logo" />
					<span>Voces Sin Género</span>
				</div>

				<ul>
					<li><i class="fa-solid fa-location-dot"></i><span>Dirección: Carretera Manzanillo-Cihuatlán kilómetro 20 El Naranjo, 28860 Manzanillo, Col.</span></li>
					<li><i class="fa-solid fa-phone"></i><span>+123 456 7890</span></li>
				</ul>
			</div>

			<div class="container-social-copyright">
				<ul>
					<li><a href="https://www.facebook.com/share/1PXSEEAPko/" target="_blank"><i class="fa-brands fa-facebook"></i></a></li>
					<li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
					<li><a href="https://www.instagram.com/vocessingenero" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
					<li><a href="mailto:vocessingenero@gmail.com"><i class="fa-regular fa-envelope"></i></a></li>
				</ul>
				<p>&copy; 2025 Voces sin Género. Todas las voces importan. Todos los derechos reservados.</p>
			</div>
		</div>
	</footer>

<!-- SCRIPTS -->
<script src="js/partials.js" defer></script>
<script src="js/home.js"></script>
<script src="js/testimonial.js"></script>
</body>
</html>

<?php
$conn->close();
?>
