<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <link rel="stylesheet" href="LOGIN.css">
    <?php
    include(__DIR__ . '/conexion_bd.php');
    include(__DIR__ . '/controlador_registrar_usuario.php');
    ?>
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
            <p class="par">La igualdad de género es un principio constitucional que estipula
                <br> que hombres y mujeres son iguales ante la ley”, lo que significa
                <br> que todas las personas sin distingo alguno tenemos los mismos
                <br> derechos y deberes frente al Estado y la sociedad en su conjunto.
                <br>
                <br>Sabemos bien que no basta decretar la igualdad en la ley si en la realidad
                <br> no es un hecho.  Para que así lo sea, la igualdad debe traducirse
                <br> en oportunidades reales y efectivas para ir a la escuela,</p>

                <div class="wrapper">
                    <!-- Formulario Login -->
                    <div class="form-wrapper sing-in">
                        <form action="" method="POST">
                            <h2>Login</h2>
                            <div class="input-group">
                                <input type="text" name="correo_login" required>
                                <label>Usuario</label>
                            </div>
                            <div class="input-group">
                                <input type="password" name="contrasena_login" id="password" required>
                                <label>Contraseña</label>
                            </div>
                            <div class="show-remember">
                                <button type="button" onclick="togglePassword('password')">Mostrar Contraseña</button>
                            </div>
                            <button type="submit">Login</button>
                            <div class="singUp-link">
                                <p>¿No tienes cuenta? <a href="#" class="singUpBtn-link">Registrarse</a></p>
                            </div>
                            <button onclick="window.history.back()" style="width: 25%; left: 40%;">Volver</button>
                        </form>
                    </div>
            
                    <!-- Formulario Registro -->
                    <div class="form-wrapper sing-up">
                        <form action="" method="POST" id="formularioRegistro">
                            <h2></h2>
                            <BR></BR>
                            <?php if(isset($error)) { ?>
                                <div class="error"><?php echo $error; ?></div>
                            <?php } ?>
                            
                            <div class="input-group">
                                <input type="text" name="nombre" required>
                                <label>Nombre completo</label>
                            </div>
                            <div class="input-group">
                                <input type="email" name="correo" required>
                                <label>Correo electrónico</label>
                            </div>
                            <div class="input-group">
                                <input type="password" name="contrasena" id="registroPassword" required minlength="8">
                                <label>Contraseña</label>
                            </div>
                            <div class="input-group">
                                <input type="password" name="confirmarcontrasena" id="confirmarPassword" required minlength="8">
                                <label>Confirmar Contraseña</label>
                            </div>

                            <div class="show-password">
                                <button type="button" onclick="togglePassword('registroPassword', 'confirmarPassword')">Mostrar Contraseñas</button>
                            </div>
                            <p>Al crear cuenta aceptas nuestros</p><a href="terminos_condiciones.html">Términos y condiciones</a>
                            <button type="submit" name="registro">Registrarse</button>
                            <div class="singUp-link">
                                <p>¿Ya tienes cuenta? <a href="#" class="singInBtn-link">Iniciar Sesión</a></p>
                            </div>
                            <button onclick="window.history.back()" style="width: 25%; left: 40%;   ">Volver</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="LOGIN.js"></script>
    <script>
        // Función para manejar el evento "Enter"
        function manejarEnter(event, siguienteInputId) {
            if (event.key === "Enter") {
                event.preventDefault();
                if (siguienteInputId) {
                    document.getElementById(siguienteInputId).focus();
                } else {
                    document.getElementById("formularioRegistro").submit();
                }
            }
        }

        // Asignar eventos a los inputs del formulario de registro
        document.querySelector('[name="nombre"]').addEventListener("keydown", function (event) {
            manejarEnter(event, "registroPassword");
        });

        document.querySelector('[name="correo"]').addEventListener("keydown", function (event) {
            manejarEnter(event, "registroPassword");
        });

        document.getElementById("registroPassword").addEventListener("keydown", function (event) {
            manejarEnter(event, "confirmarPassword");
        });

        document.getElementById("confirmarPassword").addEventListener("keydown", function (event) {
            manejarEnter(event, null);
        });

        // Función para mostrar/ocultar contraseñas
        function togglePassword(...ids) {
            ids.forEach(id => {
                const passwordField = document.getElementById(id);
                passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
            });
        }
    </script>
</body>
</html>