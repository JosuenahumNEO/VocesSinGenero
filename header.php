
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Voces Sin Género</title>
    <meta name="description" content="Plataforma por la equidad de género">
    <meta name="robots" content="index,follow">
    <script src="https://kit.fontawesome.com/13ad7a6a05.js" crossorigin="anonymous"></script>
 
    <link rel="stylesheet" href="css/global.css" />
	<link rel="stylesheet" href="css/header.css" />
	<link rel="stylesheet" href="css/home.css" />
    <link rel="stylesheet" href="css/admin.css"> 
	<link rel="stylesheet" href="css/footer.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
					<li><a href="index.php">Inicio</a></li>
					<li><a href="post.php">Artículos</a></li>
					<li><a href="nosotros.php">Acerca</a></li>
					<li><a href="opiniones_panel.php">Opiniones</a></li>
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
					<li><a href="post.php">Artículos</a></li>
					<li><a href="nosotros.php">Acerca</a></li>
					<li><a href="opiniones_panel.php">Opiniones</a></li>
				</ul>
				</ul>
			</div>
		</div>
	</header>

</body>