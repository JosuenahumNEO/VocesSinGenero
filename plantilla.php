<?php
session_start();
include(__DIR__ . '/conexion_bd.php');

// Verificar si se proporcionó el ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID de publicación inválido";
    header("Location: index.php");
    exit();
}

$publicacionId = intval($_GET['id']);

// Obtener datos de la publicación
$stmt = $conexion->prepare("SELECT titulo, descripcion, imagen1, imagen2, imagen3 FROM publicaciones WHERE id = ?");
$stmt->bind_param("i", $publicacionId);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    $_SESSION['error'] = "Publicación no encontrada";
    header("Location: index.php");
    exit();
}

$publicacion = $resultado->fetch_assoc();

// Asignar valores
$titulo = htmlspecialchars($publicacion['titulo']);
$descripcion = htmlspecialchars($publicacion['descripcion']);
$imagenes = [
    $publicacion['imagen1'],
    $publicacion['imagen2'],
    $publicacion['imagen3']
];

$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?> - Voces Sin Género</title>
    <link rel="stylesheet" href="css/principal.css">
    <style>
        .publicacion-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .publicacion-imagen {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .publicacion-titulo {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .publicacion-descripcion {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #34495e;
        }
    </style>
</head>
<body>
    <!-- Incluir el header de tu index.php -->
    <?php include('header.php'); ?>

    <div class="publicacion-container" style="margin-top: 150px;">
        <h1 class="publicacion-titulo"><?php echo $titulo; ?></h1>
        
        <div class="publicacion-contenido">
            <p class="publicacion-descripcion"><?php echo nl2br($descripcion); ?></p>
        </div>
        
        <div class="publicacion-galeria">
            <?php foreach ($imagenes as $imagen): 
                if (!empty($imagen) && file_exists(__DIR__ . '/uploads/' . $imagen)):
            ?>
                <img src="uploads/<?php echo htmlspecialchars($imagen); ?>" 
                     alt="Imagen de la publicación" 
                     class="publicacion-imagen">
            <?php endif; 
            endforeach; ?>
        </div>

    </div>

    <!-- Incluir el footer de tu index.php -->
    <?php include('footer.php'); ?>
</body>
</html>