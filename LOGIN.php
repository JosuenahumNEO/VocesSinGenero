<?php
session_start();
include(__DIR__ . '/conexion_bd.php');

// Procesar inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_submit'])) {
    $usuario = mysqli_real_escape_string($conexion, trim($_POST['usuario_login']));
    $password = trim($_POST['password_login']);

    $stmt = mysqli_prepare($conexion, "SELECT ID_USUARIO, usuario, contraseña FROM usuarios WHERE usuario = ?");
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $usuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Verificación de contraseña (NO se desencripta, se compara el hash)
            if (password_verify($password, $row['contraseña'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['usuario'] = $row['usuario'];
                header("Location: index.php"); // Cambiado a index.html
                exit();
            } else {
                $_SESSION['error_login'] = "Contraseña incorrecta";
            }
        } else {
            $_SESSION['error_login'] = "Usuario no encontrado";
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error_login'] = "Error en el sistema";
    }
    header("Location: LOGIN.php");
    exit();
}
?>

<!-- El resto del HTML se mantiene igual -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <link rel="stylesheet" href="LOGIN.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="main">
        <div class="icon">
            <img src="img/logo igualdad de genero.png" alt="Logo Igualdad de Género">
        
        <div class="navbar">
            <div class="icon"></div>
        </div>
        <div class="content">
            <h1>PALABRAS SIN MOLDES<br><span>VOCES SIN GÉNERO</span></h1>
            <p class="par" style="text-align: justify;">
                La igualdad de género es un principio constitucional que estipula
                <br>que hombres y mujeres son iguales ante la ley”, lo que significa
                <br>que todas las personas sin distingo alguno tenemos los mismos
                <br>derechos y deberes frente al Estado y la sociedad en su conjunto.
                <br>
                <br>Sabemos bien que no basta decretar la igualdad en la ley si en la realidad
                <br>no es un hecho. Para que así lo sea, la igualdad debe traducirse
                <br>en oportunidades reales y efectivas para ir a la escuela,
            </p>

            <div class="wrapper">
                <!-- Formulario Login -->
                <div class="form-wrapper sing-in">
                    <form action="" method="POST">
                        <h2>Login</h2>
                        <?php if(isset($_SESSION['error_login'])): ?>
                            <div class="error"><?= $_SESSION['error_login'] ?></div>
                            <?php unset($_SESSION['error_login']); ?>
                        <?php endif; ?>
                        
                        <div class="input-group">
                            <input type="text" name="usuario_login" required autocomplete="off">
                            <label>Usuario</label>
                        </div>
                        <div class="input-group">
                            <input type="password" name="password_login" id="loginPassword" placeholder="Contraseña" required>
                            <i class="fas fa-eye toggle-icon" onclick="togglePassword('loginPassword', this)"></i>
                        </div>
                        <button type="submit" name="login_submit">Login</button>
                        <div class="singUp-link">
                            <p>¿No tienes cuenta? <a href="#" class="singUpBtn-link" data-action="show-register">Registrarse</a></p>
                        </div>
                        <button type="button" onclick="window.history.back()" style="width: 25%; left: 40%;">Volver</button>
                    </form>
                </div>

                <!-- Formulario Registro -->
                <div class="form-wrapper sing-up"><!-- Cambiar el action del formulario de registro -->
                    <form action="controlador_registrar_usuario.php" method="POST" id="formularioRegistro">
                        <h2></h2>
                        <br>
                        <?php if(isset($_SESSION['error_registro'])): ?>
                            <div class="error"><?= $_SESSION['error_registro'] ?></div>
                            <?php unset($_SESSION['error_registro']); ?>
                        <?php endif; ?>
                        <?php if(isset($_SESSION['success_registro'])): ?>
                            <div class="success"><?= $_SESSION['success_registro'] ?></div>
                            <?php unset($_SESSION['success_registro']); ?>
                        <?php endif; ?>
                        
                        <div class="input-group">
                            <input type="text" name="nombre" required autocomplete="off">
                            <label>Nombre de usuario</label>
                        </div>
                        <div class="input-group">
                            <input type="email" name="correo" required autocomplete="off">
                            <label>Correo electrónico</label>
                        </div>
                        <div class="input-group">
                            <input type="password" name="password" id="registroPassword" placeholder="Contraseña" required>
                            <i class="fas fa-eye toggle-icon" onclick="togglePassword('registroPassword', this)"></i>
                        </div>
                        <div class="input-group">
                            <input type="password" name="confirm_password" id="confirmarPassword" placeholder="Confirme contraseña" required>
                            <i class="fas fa-eye toggle-icon" onclick="togglePassword('confirmarPassword', this)"></i>
                        </div>

                        <p>Al crear cuenta aceptas nuestros <a href="terminos_condiciones.html">Términos y condiciones</a></p>
                        
                        <ul id="password-rules" style="list-style: none; padding-left: 0;">
                            <li id="rule-length" class="invalid">✔ Mínimo de 8 caracteres</li>
                            <li id="rule-uppercase" class="invalid">✔ Mayúsculas y minúsculas</li>
                            <li id="rule-number" class="invalid">✔ Un número</li>
                            <li id="rule-special" class="invalid">✔ Un carácter especial</li>
                        </ul>

                        
                        
                        <button type="submit" name="registro">Registrarse</button>
                        <div class="singUp-link">
                            <p>¿Ya tienes cuenta? <a href="login.php" class="singInBtn-link" data-action="show-login" >Iniciar Sesión</a></p>
                        </div>
                        <button type="button" onclick="window.history.back()" style="width: 25%; left: 40%;">Volver</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="LOGIN.js"></script>
    <script>
        // Función para mostrar/ocultar contraseñas
        function togglePassword(inputId, icon) {
            const passwordField = document.getElementById(inputId);
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye-slash');
        }

        // Manejo de tecla Enter
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const form = input.closest('form');
                    if (form.checkValidity()) {
                        form.submit();
                    }
                }
            });
        });
    </script>
    
</body>
</html>