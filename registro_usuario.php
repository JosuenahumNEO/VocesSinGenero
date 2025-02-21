<!DOCTYPE html>
<html lang="en">
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
        include("conexion_bd.php");
        include("controlador_registrar_ususario.php");
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
            <div class="contraseña">
                <label for="contraseña">Contraseña</label>
                <input type="password" name="contraseña" id="contraseña" autocomplete="off">
            </div>
            <div class="confirmarcontraseña">
                <label for="confirmarcontraseña">Confirmar Contraseña</label>
                <input type="password" name="confirmarcontraseña" id="confirmarcontraseña" autocomplete="off">
            </div>
            <button class="button" type="submit" name="registro">Registrar</button>
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
        manejarEnter(event, "contraseña");
    });

    document.getElementById("contraseña").addEventListener("keydown", function (event) {
        manejarEnter(event, "confirmarcontraseña");
    });

    document.getElementById("confirmarcontraseña").addEventListener("keydown", function (event) {
        manejarEnter(event, null); // Envía el formulario al presionar Enter en el último campo
    });
</script>
</body>
</html>