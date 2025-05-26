<?php
session_start();
$error = $_SESSION['error'] ?? '';
$correo_guardado = $_SESSION['correo_guardado'] ?? '';
unset($_SESSION['error'], $_SESSION['correo_guardado'], $_SESSION['login_intentado']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/13ad7a6a05.js" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="container">
        <div class="form-box login">
          <form action="procesar_login.php" method="POST">
            <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?= $_SESSION['error'] ?></p>
            <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

                <h1>Login</h1>
                <div class="input-box">
                    <input type="email" name="correo" placeholder="Correo" required>
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="input-box">
                  <input type="password" id="loginPassword" name="contraseña" placeholder="Contraseña" required>
                  <i class="fa-solid fa-eye" id="toggleLoginPassword" onclick="togglePasswordVisibility('loginPassword', 'toggleLoginPassword')"></i>
                </div>

                <div class="forgot-link">
                    <a href="recuperar_contraseña.php">Olvidaste tu contraseña?</a>
                </div>
                <button type="submit" class="btn">Login</button>
                <p>Siguenos en nuestras redes sociales</p>
                <div class="social-icons">
                    <a href="https://www.facebook.com/share/1PXSEEAPko/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/vocessingenero" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fa-solid fa-x"></i></a>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <form action="registro.php" method="POST" enctype="multipart/form-data">
                <h1>Registrate</h1>
                <div class="input-box1">
                  <label for="foto_perfil" style="display: block; text-align: left; font-weight: 500;"></label>
                  <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*" required>
                  <i class="fa-solid fa-camera"></i>
                </div>
                <div class="input-box1">
                    <input type="text" name="nombre_usuario" placeholder="Usuario" required>
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="input-box1">
                    <input type="email" name="correo" placeholder="Correo" required>
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <!-- Contraseña -->
                <div class="input-box1 contraseña-box">
                  <input type="password" id="registroPassword" name="contraseña" placeholder="Contraseña" required>
                  <i class="fa-solid fa-eye" id="toggleRegistroPassword" onclick="togglePasswordVisibility('registroPassword', 'toggleRegistroPassword')"></i>
                </div>

                <div class="input-box1 contraseña-box">
                  <input type="password" id="confirmarPassword" name="confirmar_contraseña" placeholder="Confirmar contraseña" required>
                  <i class="fa-solid fa-eye" id="toggleConfirmarPassword" onclick="togglePasswordVisibility('confirmarPassword', 'toggleConfirmarPassword')"></i>
                </div>


                <!-- Mensaje si no coinciden -->
                <small id="passwordMismatch" style="color: red; display: none;">Las contraseñas no coinciden.</small>


                        
                        <ul id="password-rules" style="list-style: none; padding-left: 0;">
                            <li id="rule-length" class="invalid">✔ Mínimo de 8 caracteres</li>
                            <li id="rule-uppercase" class="invalid">✔ Mayúsculas y minúsculas</li>
                            <li id="rule-number" class="invalid">✔ Un número</li>
                            <li id="rule-special" class="invalid">✔ Un carácter especial</li>
                        </ul>
                <p class="terminos_condiciones">Al crear cuenta aceptas nuestros <a href="terminos_condiciones.html">Términos y condiciones</a></p>

                <button type="submit" class="btn">Registrate</button>
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hola, Bienvenido a Voces sin Genero!</h1>
                <p>No tienes cuenta?</p>
                <button class="btn register-btn">Registrate</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Bienvenido de nuevo!</h1>
                <p>Ya tienes cuenta?</p>
                <button class="btn login-btn">Login</button>
            </div>
        </div>

    </div>
    
    <script src="js/login.js"></script>
</body>
</html>
