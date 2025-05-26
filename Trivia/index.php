<?php
session_start();
require_once 'conexion.php';
$conn = conectarDB();
$resultado = $conn->query("SELECT id, titulo, portada FROM posts ORDER BY fecha DESC LIMIT 3");
if (!isset($_SESSION['usuario_id']) && isset($_COOKIE['user_data'])) {
    $user_data = json_decode($_COOKIE['user_data'], true);
    if ($user_data && isset($user_data['id'])) {
        $_SESSION['usuario_id'] = $user_data['id'];
        $_SESSION['nombre_usuario'] = $user_data['name'];
        $_SESSION['foto_perfil'] = $user_data['photo'];
        $_SESSION['rol'] = $user_data['rol'];

        // También actualizar localStorage en el navegador
        $_SESSION['local_user'] = [
            'name' => $user_data['name'],
            'photo' => $user_data['photo'],
            'rol' => $user_data['rol']
        ];
    }
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
	<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
		integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
		crossorigin="anonymous"
		referrerpolicy="no-referrer"
	/>
	<link rel="stylesheet" href="css/global.css" />
	<link rel="stylesheet" href="css/header.css" />
	<link rel="stylesheet" href="css/home.css" />
	<link rel="stylesheet" href="css/footer.css" />
</head>

<body>

<?php if (isset($_SESSION['local_user'])): ?>
<script>
  const user = <?= json_encode($_SESSION['local_user']) ?>;
  localStorage.setItem('user', JSON.stringify(user));
</script>
<?php unset($_SESSION['local_user']); ?>
<?php endif; ?>

<?php  include 'header.php'; ?>


	

	<!-- SECTION BANNER HERO -->
	<section class="hero-banner">
		<div class="container">
			<div class="content">
				<span class="badge">Equidad de género</span>
				<h1>La sociedad se transforma con <span>cada voz</span></h1>
				<p>
					Sumérgete en un espacio de reflexión e inspiración, donde cada historia
					es una expresión de lucha, identidad y respeto, construida con empatía,
					diversidad y conciencia social.
				</p>
			</div>

			<div class="container-images">
				<img src="images/Voces/hombreymujer.jpeg" alt="Hero Banner" class="main-image" />
				<img src="images/Voces/equidad4.jpg" alt="Hero Banner 1" class="img-banner-1" />
				<img src="images/Voces/equidad2.jpg" alt="Hero Banner 2" class="img-banner-2" />
			</div>
		</div>
	</section>

	<!-- BLOG DINÁMICO -->
<section class="background-dark-2 section-blog">
  <div class="container">
    <div class="content">
      <span class="badge"> Mejores artículos de la semana </span>
      <h2 class="title">Explora nuestros Mejores <span>artículos</span></h2>

      <div class="container-blogs">
        <?php while ($row = $resultado->fetch_assoc()): ?>
          <div class="container-blog">
            <a href="articulo.php?id=<?= $row['id'] ?>" class="container-img">
              <figure><img src="<?= htmlspecialchars($row['portada']) ?>" alt="Imagen del artículo" /></figure>
            </a>
            <div class="blog-info">
              <h3><a href="articulo.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['titulo']) ?></a></h3>
              <div class="container-button">
                <a href="articulo.php?id=<?= $row['id'] ?>" class="btn-read-more">Leer más <i class="fa-solid fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>

      <p class="dish-link">¿Quieres saber más? <a href="post.php">¡Mira todos los artículos!</a></p>
    </div>
  </div>
</section>


	<!-- ABOUT US -->
	<section class="background-dark-1 section-about">
		<div class="container">
			<div class="container-images">
				<img src="images/home/igualdad.jpg" class="main-image" alt="About us" />
				<img src="images/home/Mujeres.png" class="alt-image" alt="Mujeres" />
			</div>

			<div class="content">
				<h2 class="title-about">Nuestro compromiso con la Autenticidad & <span>Equidad</span></h2>
				<p>
					Cada artículo que compartimos celebra la diversidad desde la empatía y los derechos humanos.
					Creamos un espacio seguro para todas las identidades, donde cada historia inspira y promueve
					un mundo más justo e inclusivo.
				</p>
				<p>
					<i class="fa-solid fa-quote-left"></i>
					"La equidad de género no es solo un objetivo, es un camino hacia la justicia social y el respeto por la diversidad humana."
					<i class="fa-solid fa-quote-right"></i>
				</p>
			</div>
		</div>
	</section>

	<!-- ACERCA DE NOSOTROS -->
	<section class="background-dark-2 section-our-ingredients">
		<div class="container">
			<div class="container-images">
				<img src="images/Voces/mujer.jpg" alt="Nuestra comunidad" class="main-image" />
			</div>

			<div class="content">
				<span class="badge">Acerca de nosotros</span>
				<h2 class="title">Voces que inspiran, <span>historias que transforman</span></h2>
				<p>
					<strong>Voces sin Género</strong> nace como un espacio digital donde la equidad, la inclusión y el respeto
					no son solo ideales, sino acciones constantes. Nos dedicamos a visibilizar realidades, compartir experiencias
					auténticas y construir una comunidad que valore la diversidad en todas sus formas.
				</p>

				<div class="container-options">
					<div class="container-option">
						<i class="fa-solid fa-users"></i>
						<h3>Comunidad diversa</h3>
					</div>
					<div class="container-option">
						<i class="fa-solid fa-book-open"></i>
						<h3>Contenidos transformadores</h3>
					</div>
					<div class="container-option">
						<i class="fa-solid fa-handshake-angle"></i>
						<h3>Compromiso social</h3>
					</div>
				</div>

				<div class="container-button">
					<a href="nosotros.html" class="btn btn-primary">
						Descubre más sobre nosotros <i class="fa-solid fa-arrow-right"></i>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- TESTIMONIALS -->
	<section class="section-testimonials">
		<div class="container">
			<div class="content">
				<span class="badge"> Testimonios </span>
				<h2 class="title">Historias reales que reflejan lucha, resiliencia y <span>transformación social</span></h2>

				<div class="carousel-wrapper">
					<div class="container-testimonials">
						<!-- Testimonio 1 -->
						<div class="testimonial">
							<img src="images/home/quote.svg" alt="Icon Quote" class="quote-icon" />
							<p>Poder compartir mi opinión en este espacio fue liberador. Por primera vez sentí que mi voz tenía un lugar, sin juicios ni etiquetas.</p>
							<figure><img src="images/home/customer-1.jpg" alt="Testimonial 1" /></figure>
							<h3>Carlos Pérez</h3>
						</div>

						<!-- Testimonio 2 -->
						<div class="testimonial">
							<img src="images/home/quote.svg" alt="Icon Quote" class="quote-icon" />
							<p>Encontré artículos que me ayudaron a comprender mejor mi identidad. Este blog es una herramienta poderosa para el cambio social.</p>
							<figure><img src="images/home/customer-2.jpg" alt="Testimonial 2" /></figure>
							<h3>José Carlos</h3>
						</div>

						<!-- Testimonio 3 -->
						<div class="testimonial">
							<img src="images/home/quote.svg" alt="Icon Quote" class="quote-icon" />
							<p>Este espacio me inspiró a empezar una red de apoyo en mi comunidad. Leer experiencias diversas me ayudó a entender que no estamos solxs.</p>
							<figure><img src="images/home/customer-3.jpg" alt="Testimonial 3" /></figure>
							<h3>Andrea Rodríguez</h3>
						</div>
					</div>

					<!-- BOTONES CARRUSEL -->
					<button type="button" class="btn-carousel btn-prev">
						<i class="fa-solid fa-chevron-left"></i>
					</button>
					<button type="button" class="btn-carousel btn-next">
						<i class="fa-solid fa-chevron-right"></i>
					</button>
				</div>
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

	<div id="cookie-banner" style="display: none; position: fixed; bottom: 20px; left: 20px; right: 20px; background: #333; color: #fff; padding: 15px 20px; border-radius: 8px; z-index: 1000; box-shadow: 0 0 10px rgba(0,0,0,0.4);">
  <p style="margin: 0; font-size: 14px;">
    Este sitio utiliza cookies para mejorar tu experiencia. Al continuar navegando, aceptas su uso.
    <button id="accept-cookies" style="margin-left: 15px; background: #19bc70; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Aceptar</button>
  </p>
</div>


<!-- SCRIPTS -->
<script src="js/partials.js" defer></script>
<script src="js/home.js"></script>
<script src="js/testimonial.js"></script>
</body>
</html>


