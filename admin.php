<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// SI EL USUARIO NO ESTA LOGEADO REDIRIGIR A:
if (!isset($_SESSION['admin'])) {
    header("Location: LOGIN.PHP");
    exit;
}

// Manejar mensajes
$mensaje = '';
if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $mensaje = '<div class="success-message">Publicación creada exitosamente!</div>';
}
if (isset($_SESSION['error'])) {
    $mensaje = '<div class="error-message">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="js/editor_texto_publicar_notas.js"></script>
    <title>Voces sin Género - Panel Admin</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h1>Voces sin Género</h1>
            <nav>
                <button class="nav-btn active" data-section="crear-post">Crear Publicación</button>
                <button class="nav-btn" data-section="usuarios">Administradores</button>
                <button class="nav-btn" data-section="estadisticas">Estadísticas</button>
            </nav>
            <div class="user-info">
                <p>Bienvenid@, <?php echo htmlspecialchars($_SESSION['admin']['nombre']); ?></p>
                <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
            </div>
        </aside>

        <main class="main-content">
            <?php echo $mensaje; ?>
            
            <section id="crear-post" class="content-section active">
                <h2>Crear Nueva Publicación</h2>
                <form class="post-form" enctype="multipart/form-data" method="POST" action="publicacionesconexion.php">
                    <div class="form-group">
                        <label for="titulo">Título:</label>
                        <input type="text" id="titulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="contenido">Contenido:</label>
                        <textarea id="contenido" name="contenido" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="imagen_cabecera">Imagen de cabecera:</label>
                        <input type="file" id="imagen_cabecera" name="imagen_cabecera" accept="image/*"><br><br>
                        
                        <label for="imagen_cuerpo1">Primera imagen de cuerpo:</label>
                        <input type="file" id="imagen_cuerpo1" name="imagen_cuerpo1" accept="image/*"><br><br>

                        <label for="imagen_cuerpo2">Segunda imagen de cuerpo:</label>
                        <input type="file" id="imagen_cuerpo2" name="imagen_cuerpo2" accept="image/*">
                    </div>
                    <button type="submit" class="submit-btn">Publicar</button>
                </form>
            </section>

            <!-- Resto del contenido... -->
        </main>
    </div>

    <script src="admin.js"></script>
</body>
</html>