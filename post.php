<?php
require_once 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$conn = conectarDB();
$query = "SELECT p.id, p.titulo, p.contenido, p.portada, p.fecha, p.etiquetas, u.nombre_usuario 
          FROM posts p 
          JOIN usuarios u ON p.autor_id = u.id 
          ORDER BY p.fecha DESC";
$resultado = $conn->query($query);

if (!$resultado) {
    die("Error en la consulta SQL: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>VocesSinGénero | Inicio</title>
	<link rel="icon" href="images/img/logoblanco.png" type="image/svg+xml" />

	<!-- biblioteca de íconos -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
	integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
	crossorigin="anonymous" referrerpolicy="no-referrer" />

	<link rel="stylesheet" href="css/global.css" />
	<link rel="stylesheet" href="css/header.css" />
	<link rel="stylesheet" href="css/home.css" />
	<link rel="stylesheet" href="css/footer.css" />
</head>

<body>
	<?php  include 'header.php'; ?>


    <!-- Sección de portada -->
    <div class="container-all" id="move-content">


        <div class="blog-container-cover">
            <div class="container-cover-info">
                <h1>¡Haz que tu voz</h1><span> cuente!</span>
                <p> Vivimos en un mundo lleno de posibilidades, donde cada paso hacia la equidad marca la diferencia. 
                    Explora historias, elige informarte y actúa con convicción, porque cada decisión construye un cambio real.</p>
            </div>
        </div>
    
        <!-- Contenido principal -->
        <div class="background-dark-2 container-post">

            <!--SISTEMA DE FILTRADO-->
            <div class="container-post">
                <input type="radio" id="TODOS" name="categorias" value="TODOS" checked> <!--Input: Entrada-->
                <input type="radio" id="TENDENCIAS" name="categorias" value="TENDENCIAS">
                <input type="radio" id="RECOMENDACIONES" name="categorias" value="RECOMENDACIONES">
                
                <div class="container-category">
                    <label for="TODOS">TODOS</label> <!--Los label funcionan en conjunto con el atributo "id=".-->
                    <label for="TENDENCIAS">TENDENCIAS</label>
                    <label for="RECOMENDACIONES">RECOMENDACIONES</label>
                </div>
            </div>
            
            <!-- Artículos -->
            <div class="posts">
                <?php while ($post = $resultado->fetch_assoc()): ?>
                    <div class="post" data-category="<?= htmlspecialchars($post['etiquetas']) ?>">
                        <div class="container-img">
                            <figure>
                                <img src="<?= htmlspecialchars($post['portada']) ?>" alt="Imagen de portada" />
                            </figure>
                            <span><?= date("d M Y - h:i a", strtotime($post['fecha'])) ?></span>

                            <div class="blog-info">
                                <h3>
                                    <a href="articulo.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['titulo']) ?></a>
                                </h3>

                                <ul>
                                    <?php
                                    $tags = explode(',', $post['etiquetas']);
                                    foreach ($tags as $tag): ?>
                                        <li><?= strtoupper(trim($tag)) ?></li>
                                    <?php endforeach; ?>
                                </ul>

                                <div class="container-button">
                                    <a href="articulo.php?id=<?= $post['id'] ?>" class="btn-read-more">
                                        Leer más <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

	<?php $conn->close(); ?>

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
	<script src="js/partials.js"></script>
	<script src="js/home.js"></script>
    <script src="js/filtro-articulos.js"></script>
</body>
</html>
