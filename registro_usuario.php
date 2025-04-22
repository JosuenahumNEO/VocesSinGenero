<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="css/registro_usuario.css">
</head>
<body>
<div class="container">
    <form action="" method="POST" class="formulario" id="formularioRegistro">
        <h2>REGISTRAR</h2>
        <?php
        include(__DIR__ . '/conexion_bd.php');
        include(__DIR__ . '/controlador_registrar_usuario.php');
        ?>
        <div class="padre">
            <div class="nombre">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" autocomplete="off"> 
            </div>
            <div class="correo">
                <label for="correo">Email:</label>
                <input type="email" name="correo" id="correo" autocomplete="off">
            </div>
            <div class="contrasena">
                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" autocomplete="off" minlength="8">
            </div>
            <div class="confirmarcontrasena">
                <label for="confirmarcontrasena">Confirmar Contraseña</label>
                <input type="password" name="confirmarcontrasena" id="confirmarcontrasena" autocomplete="off" minlength="8">
            </div>

            <br>
            <p>Al registrarte acepas nuestros </p><a href="terminos_condiciones.html">terminos y condiciones</a>

            <button class="button" type="submit" name="registro">Registrar</button>
            <button><a href="index.html"  style="width: 20%;">Regresar</a></button>            
        </div>
    </form>
</div>

<script>
    // Función para manejar el evento "Enter"
    function manejarEnter(event, siguienteInputId) {
        if (event.key === "Enter") {
            event.preventDefault(); // Evita el comportamiento por defecto (enviar el formulario)
            if (siguienteInputId) {
                document.getElementById(siguienteInputId).focus(); // Enfoca el siguiente input
            } else {
                document.getElementById("formularioRegistro").submit(); // Envía el formulario
            }
        }
    }

    // Asignar eventos a los inputs
    document.getElementById("nombre").addEventListener("keydown", function (event) {
        manejarEnter(event, "correo");
    });

    document.getElementById("correo").addEventListener("keydown", function (event) {
        manejarEnter(event, "contrasena");
    });

    document.getElementById("contrasena").addEventListener("keydown", function (event) {
        manejarEnter(event, "confirmarcontrasena");
    });

    document.getElementById("confirmarcontrasena").addEventListener("keydown", function (event) {
        manejarEnter(event, null); // Envía el formulario al presionar Enter en el último campo
    });
</script>
</body>
</html>