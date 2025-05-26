<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
    exit;
}

$conn = conectarDB();
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    echo "<script>alert('ID no válido.'); window.location.href='admin_articulos.php';</script>";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
$stmt->close();

if (!$post) {
    echo "<script>alert('Artículo no encontrado.'); window.location.href='admin_articulos.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Editar Artículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color:#0e110d;
        }
        .form-container {
           max-width: 780px;
           margin: 4rem auto;
           padding: 2.5rem;
           background-color:#ffffff1a;
            
           border-radius: 10px;
           box-shadow: 0 4px 16px  #0e110d;
        }
            .form-label small {
           font-weight: normal;
        }
    </style>
    
  <link rel="stylesheet" href="css/global.css" />

	
    <link rel="stylesheet" href="css/admin.css"> 
	<link rel="stylesheet" href="css/footer.css" />
	
</head>
<body>
    
<div class="form-container">
    <h2 class="text-center mb-4">Editar Artículo</h2>
    <form action="guardar_edicion.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($post['id']) ?>">

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" class="form-control" name="titulo" value="<?= htmlspecialchars($post['titulo']) ?>" required />
        </div>

        <div class="mb-3">
            <label class="form-label">Contenido</label>
            <textarea class="form-control" name="contenido" id="contenido" rows="7" required><?= htmlspecialchars($post['contenido']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen General (opcional)</label>
            <input type="file" class="form-control" name="imagen_general" accept="image/*" />
            <small class="text-muted">Actual: <?= htmlspecialchars($post['imagen_general']) ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen Aside (opcional)</label>
            <input type="file" class="form-control" name="imagen_aside" accept="image/*" />
            <small class="text-muted">Actual: <?= htmlspecialchars($post['imagen_aside']) ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Texto Aside</label>
            <textarea class="form-control" name="descripcion_aside" rows="2"><?= htmlspecialchars($post['descripcion_aside']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Etiquetas</label>
            <input type="text" class="form-control" name="etiquetas" value="<?= htmlspecialchars($post['etiquetas']) ?>" required />
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen de Portada (opcional)</label>
            <input type="file" class="form-control" name="portada" accept="image/*" />
            <small class="text-muted">Actual: <?= htmlspecialchars($post['portada']) ?></small>
        </div>

        <button type="submit" class="btn btn-success w-100">Guardar cambios</button>
    </form>
</div>

<script src="https://cdn.tiny.cloud/1/l7dwfb1m900twsdiyt823fsyebdtfd0hnllee33dk2p21k5q/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#contenido',
        height: 400,
        menubar: false,
        plugins: 'lists link image code fullscreen preview',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link image | fullscreen preview',
        branding: false,
        language: 'es'
    });
</script>
</body>
</html>
