<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opiniones</title>
	<link rel="icon" href="images/img/logoblanco.png" type="image/svg+xml" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            justify-content: center;
            height: 100vh;
            background-image: url(images/Voces/equidad.jpeg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            
            &::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.664);
		    z-index: -1;
            }
        }
        .container {
            max-width: 800px;
            width: 90%;
            margin: 100px auto;
            background: rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px); /* Soporte Safari */
            color: #000;
        }
        h1, h2 {
            color: rgb(255, 255, 255) ;
        }
        .error {
            color: red;
            margin: 10px 0;
            font-weight: bold;
        }
        .success {
            color: green;
            margin: 10px 0;
            font-weight: bold;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.1); /* Fondo semitransparente */
            color: white;                         /* Texto blanco para contraste */
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            outline: none;
        }

        textarea::placeholder {
        color: white;
        opacity: 1; /* Asegura que no se vea gris claro */
        }

        button {
            background-color: #19bc70 ;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        button:hover {
            background-color: #19bc70;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>El equipo detrás de Voces sin Género quiere escucharte</h1>
        <h2>Cuentanos en qué podemos mejorar</h2>
        
        <?php if(isset($_GET['error'])) { ?>
            <div class="error"><?= urldecode($_GET['error']) ?></div>
        <?php } ?>
        
        <?php if(isset($_GET['success'])) { ?>
            <div class="success">¡Gracias por tu opinión!</div>
        <?php } ?>

        <form action="opinionesconexion.php" method="POST">
            <textarea name="comentario" rows="6" required placeholder="Escribe tu comentario aquí..."></textarea><br>
            <button type="submit">Enviar comentario</button>
        </form>

        <a href="index.php"><button type="button">Volver al inicio</button></a>
    </div>
</body>
</html>