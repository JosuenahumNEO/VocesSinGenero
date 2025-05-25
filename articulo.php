<?php
require_once 'conexion.php';
session_start();

$conn = conectarDB();
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Artículo no encontrado.";
    exit;
}

$stmt = $conn->prepare("
    SELECT p.titulo, p.contenido, p.portada, p.imagen_general, p.imagen_aside, 
           p.descripcion_aside, p.fecha, u.nombre_usuario 
    FROM posts p 
    JOIN usuarios u ON p.autor_id = u.id 
    WHERE p.id = ?
");
$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    echo "Error al cargar el artículo.";
    exit;
}

$resultado = $stmt->get_result();
if ($resultado->num_rows === 0) {
    echo "Artículo no disponible.";
    exit;
}

$post = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($post['titulo']) ?> | Voces Sin Género</title>
  <!-- biblioteca de íconos -->
	<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
		integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
		crossorigin="anonymous"
		referrerpolicy="no-referrer"
	/>
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/header.css" />
  <link rel="stylesheet" href="css/articulos.css"/>
  <link rel="stylesheet" href="css/home.css" />
    <link rel="stylesheet" href="css/footer.css" />
</head>

<body>
<header>
  <div class="container header-expand">
    <div class="container-logo">
      <img src="images/img/logoblanco.png" alt="Logo" />
      <span>Voces Sin Género</span>
    </div>
    <nav>
      <ul>
        <li><a href="index.php
">Inicio</a></li>
        <li><a href="nosotros.html">Acerca</a></li>
        <li><a href="http://localhost:3000/opiniones.php">Opiniones</a></li>
        <li><a href="post.php">Artículos</a></li>
      </ul>
    </nav>
    <div class="user-menu-container">
      <button class="profile-btn" onclick="toggleMenu()">
        <img src="images/usuario.png" alt="Perfil" class="avatar-icon" />
      </button>
      <div id="user-menu" class="user-menu hidden"></div>
    </div>
    <button class="btn-toggle">
      <i class="fa-solid fa-bars active"></i>
      <i class="fa-solid fa-xmark"></i>
    </button>
    <div class="menu-responsive">
      <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="nosotros.html">Acerca</a></li>
        <li><a href="http://localhost:3000/opiniones.php">Opiniones</a></li>
        <li><a href="post.php">Artículos</a></li>
      </ul>
    </div>
  </div>
</header>

<!-- PORTADA HERO -->
<div class="article-container-cover" style="background-image: url('<?= htmlspecialchars($post['portada']) ?>')">
  <div class="container-cover-info">
    <h1><?= htmlspecialchars($post['titulo']) ?></h1>
    <p>Publicado por <strong><?= htmlspecialchars($post['nombre_usuario']) ?></strong> el <?= date("d M Y - h:i a", strtotime($post['fecha'])) ?></p>
  </div>
</div>

<section class="background-dark-2">
  <div class="container-content">
    <article>
      <div><?= $post['contenido'] ?></div>
      <?php if (!empty($post['imagen_general'])): ?>
        <img src="<?= htmlspecialchars($post['imagen_general']) ?>" alt="Imagen del artículo" />
      <?php endif; ?>
    </article>

    <div class="container-aside">
        <!-- Aside personalizado (Trivia) -->
        <aside>
            <h2>Artículos relacionados</h2>
            <p><?= nl2br(htmlspecialchars($post['descripcion_aside'])) ?></p>
            <?php if (!empty($post['imagen_aside'])): ?>
            <img src="<?= htmlspecialchars($post['imagen_aside']) ?>" alt="Imagen trivia" />

            <div class="container-button">
                <a href="post.php" class="btn-read-more">
                    Leer más
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <?php endif; ?>
        </aside>

        <!-- Aside adicional (fijo o dinámico) -->
        <aside>
            <h2>Trivia</h2>
            <p>Juega aqui</p>
            <img src="images/Voces/img1.jpg" alt="Trivia" />
            <button class="btn btn-secondary" onclick="window.location.href='Trivia/juegotrivia.html'">Jugar</button>
        </aside>
    </div>
  </div>
</section>

<!-- FOOTER -->
	<footer class="background-dark-1">
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
$stmt->close();
$conn->close();
?>
