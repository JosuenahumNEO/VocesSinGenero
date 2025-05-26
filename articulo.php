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
// Cargar trivia del artículo
$triviaStmt = $conn->prepare("SELECT * FROM trivias WHERE post_id = ?");
$triviaStmt->bind_param("i", $id);
$triviaStmt->execute();
$triviaResult = $triviaStmt->get_result();
$triviaData = $triviaResult->fetch_all(MYSQLI_ASSOC);
$triviaStmt->close();

// Obtener un artículo diferente al actual, de forma aleatoria
$relacionadoStmt = $conn->prepare("SELECT id, titulo, portada FROM posts WHERE id != ? ORDER BY RAND() LIMIT 1");
$relacionadoStmt->bind_param("i", $id);
$relacionadoStmt->execute();
$relacionado = $relacionadoStmt->get_result();
$articuloRelacionado = $relacionado->fetch_assoc();

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
    <link rel="stylesheet" href="css/admin.css" />
</head>

<body>
<?php  include 'header.php'; ?>


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
        <aside>
            <h2>Artículos relacionados</h2>
            <?php if ($articuloRelacionado): ?>
                <p><?= htmlspecialchars($articuloRelacionado['titulo']) ?></p>
                <img src="<?= htmlspecialchars($articuloRelacionado['portada']) ?>" alt="Imagen relacionada">
                <div class="container-button">
                <a href="articulo.php?id=<?= $articuloRelacionado['id'] ?>" class="btn-read-more">
                    Leer más <i class="fa-solid fa-arrow-right"></i>
                </a>
                </div>
            <?php else: ?>
                <p>No hay otros artículos para mostrar.</p>
            <?php endif; ?>
        </aside>


        <aside>
        <h2>Trivia del artículo</h2>
          <?php if ($triviaData && $triviaData[0]['portada']): ?>
            <img src="<?= htmlspecialchars($triviaData[0]['portada']) ?>" alt="Trivia portada" style="width: 100%; border-radius: 8px;" />

          <div class="container-button" style="margin-top: 10px;">
            <a href="jugar_trivia.php?post_id=<?= $id ?>" class="btn btn-primary">Jugar</a>
          </div>
          <?php else: ?>
                <p>No hay trivias que mostrar.</p>
            <?php endif; ?>
        </aside>


    </div>
  </div>
</section>

<section class="background-dark-1 section-comentarios">
  <h2>Comentarios</h2>

  <?php
  $comentariosStmt = $conn->prepare("
    SELECT c.contenido, c.fecha, u.nombre_usuario, u.foto_perfil
    FROM comentarios c
    JOIN usuarios u ON c.usuario_id = u.id
    WHERE c.post_id = ?
    ORDER BY c.fecha DESC
  ");
  $comentariosStmt->bind_param("i", $id);
  $comentariosStmt->execute();
  $comentarios = $comentariosStmt->get_result();

  while ($coment = $comentarios->fetch_assoc()):
  ?>
    <div class="comentario">
      <img src="<?= htmlspecialchars($coment['foto_perfil']) ?>" alt="Usuario" />
      <div>
        <div class="comentario-header">
          <strong><?= htmlspecialchars($coment['nombre_usuario']) ?></strong>
          <span class="text-muted" style="font-size: 0.8rem;"><?= date("d/m/Y H:i", strtotime($coment['fecha'])) ?></span>
        </div>
        <p><?= nl2br(htmlspecialchars($coment['contenido'])) ?></p>
      </div>
    </div>
  <?php endwhile; $comentariosStmt->close(); ?>

  <?php if (isset($_SESSION['usuario_id'])): ?>
    <form action="procesar_comentario.php" method="POST" class="form-comentario">
      <input type="hidden" name="post_id" value="<?= $id ?>">
      <textarea name="contenido" required minlength="2" maxlength="500" placeholder="Escribe tu comentario aquí..."></textarea>
      <button type="submit">Enviar Comentario</button>
    </form>
  <?php else: ?>
    <div class="login-btn-wrapper">
      <a href="login.php" class="btn-login-required">Inicia sesión para comentar</a>
    </div>
  <?php endif; ?>
</section>



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
<script>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".form-comentario");
  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();

      const user = JSON.parse(localStorage.getItem("user"));
      if (!user || !user.id) {
        alert("Debes iniciar sesión para comentar.");
        return;
      }

      const formData = new FormData(form);
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "procesar_comentario.php", true);

      xhr.onload = function () {
        if (xhr.status === 200) {
          const contenido = formData.get("contenido")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;"); // Prevención básica de XSS

          const nuevoComentario = document.createElement("div");
          nuevoComentario.classList.add("comentario");
          nuevoComentario.innerHTML = `
            <img src="${user.photo || 'images/usuario.png'}" alt="Usuario" />
            <div>
              <div class="comentario-header">
                <strong>${user.name || 'Usuario'}</strong>
                <span class="text-muted" style="font-size: 0.8rem;">Ahora</span>
              </div>
              <p>${contenido}</p>
            </div>
          `;

          document.querySelector(".section-comentarios").insertBefore(nuevoComentario, form);
          form.reset();
        } else {
          alert("Error al enviar comentario.");
        }
      };

      xhr.onerror = function () {
        alert("No se pudo conectar con el servidor.");
      };

      xhr.send(formData);
    });
  }
});
</script>


<script>
const textarea = document.querySelector("textarea[name='contenido']");
textarea.addEventListener("input", () => {
  if (textarea.value.length < 2) {
    textarea.setCustomValidity("El comentario debe tener al menos 5 caracteres.");
  } else {
    textarea.setCustomValidity("");
  }
});
</script>
<script>
document.getElementById("form-trivia").addEventListener("submit", function(e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  fetch("evaluar_trivia.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    const resultadoDiv = document.getElementById("resultado-trivia");
    resultadoDiv.innerHTML = "";

    if (data.success) {
      let correctas = 0;
      const total = Object.keys(data.resultado).length;

      for (const id in data.resultado) {
        const item = data.resultado[id];
        const p = document.createElement("p");
        p.innerHTML = `Pregunta ${id}: ${item.es_correcta ? '✅ Correcto' : `❌ Incorrecto (Correcta: ${item.correcta})`}`;
        p.style.color = item.es_correcta ? "lightgreen" : "tomato";
        resultadoDiv.appendChild(p);
        if (item.es_correcta) correctas++;
      }

      const resumen = document.createElement("p");
      resumen.innerHTML = `<strong>Puntaje final: ${correctas}/${total}</strong>`;
      resumen.style.marginTop = "1rem";
      resultadoDiv.appendChild(resumen);
    } else {
      resultadoDiv.innerHTML = "Ocurrió un error al evaluar.";
    }
  })
  .catch(err => {
    alert("Error al conectar con el servidor.");
  });
});
</script>



</body>
<?php if (!isset($_SESSION['usuario_id'])): ?>
  <script>
    localStorage.removeItem("user");
  </script>
<?php endif; ?>
</html>

<?php
$relacionadoStmt->close();
$stmt->close();
$conn->close();
?>
