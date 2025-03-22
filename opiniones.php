<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opiniones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: url('Voces/img1.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 800px;
            width: 90%;
            background: rgba(255, 255, 255, 0.7);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }
        h1, h2 {
            color: #333;
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
        }
        button {
            background-color: #007acc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        button:hover {
            background-color: #005fa3;
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

        <button onclick="window.history.back()">Volver</button>
    </div>
</body>
</html>