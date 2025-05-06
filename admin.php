<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Si no hay sesión iniciada, crear una sesión como invitado
if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = [
        'nombre' => 'Invitado',
        'tipo' => 'invitado'
    ];
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
    <?php  include('conexion_bd.php') ?>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h1>Voces sin Género</h1>
            <nav>
                <button class="nav-btn active" data-section="crear-post">Crear Publicación</button>
                <button class="nav-btn" data-section="usuarios">Publicaciones</button>
                <button class="nav-btn" data-section="estadisticas">Estadísticas</button>
                <button  href="index.php"    class="nav-btn" ><a href="index.php">volverpe r9e9iippopoooo</a></button>



                <div class="user-info" >
                                <?php if ($_SESSION['admin']['tipo'] !== 'invitado'): ?>
                                    <a href="logoutADMIN.php" class="logout-btn">  Cerrar sesion </a>
                                <?php endif; ?>
                            </div>

            </nav>

            
            
        </aside>

        <main class="main-content">
                    

            <section id="crear-post" class="content-section active">
                
                
                <?php if ($_SESSION['admin']['tipo'] === 'invitado'): ?>
                    <h2>Panel no disponible</h2>






                    

                    <p class="info-message">Estás viendo este apartado como invitado. No puedes crear publicaciones hasta                      <a href="#" id="openLogin">Iniciar sesión</a>
                    </p>
                    <!-- Modal de Inicio de Sesión -->
                    <!-- Modal de Inicio de Sesión -->
                    <div id="loginModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>Iniciar Sesión</h2>
                            <form method="POST" action="loginADMIN.php">
                                <label for="usuario">Usuario:</label>
                                <input type="text" id="usuario" name="usuario" required><br><br>
                                <label for="contrasena">Contraseña:</label>
                                <input type="password" id="contrasena" name="contrasena" required><br><br>
                                <button type="submit" class="submit-btn">Entrar</button>
                            </form>
                        </div>
                    </div>


                     <?php else: ?>
                        <p style="font-size: 20pt;" ><b>Bienvenido <?php echo htmlspecialchars($_SESSION['admin']['nombre']); ?> ¿Que publicarémos hoy?    </b></p><br>
               







                        
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
                <?php endif; ?>
            </section>

            <!-- Aquí puedes añadir las otras secciones como usuarios y estadísticas -->
        </main>
    </div>

    <script src="admin.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('loginModal');
    const openBtn = document.querySelector('a[href="#"]');  // Botón "Iniciar sesión"
    const closeBtn = document.querySelector('.modal .close');

    if (openBtn) {
        openBtn.addEventListener('click', function (e) {
            e.preventDefault(); // Evita que se haga la acción predeterminada (redirigir)
            modal.style.display = 'block'; // Muestra el modal
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            modal.style.display = 'none'; // Oculta el modal
        });
    }

    window.addEventListener('click', function (e) {
        if (e.target == modal) {
            modal.style.display = 'none'; // Cierra el modal si se hace clic fuera de él
        }
    });
});
</script>
    <script>
        // Cambiar el contenido de la sección activa
        const navButtons = document.querySelectorAll('.nav-btn');
        const sections = document.querySelectorAll('.content-section');

        navButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetSection = button.getAttribute('data-section');

                sections.forEach(section => {
                    section.classList.remove('active');
                    if (section.id === targetSection) {
                        section.classList.add('active');
                    }
                });

                navButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            });
        });
    </script>
</body>
</html>
