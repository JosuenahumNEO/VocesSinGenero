<?php

session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
  echo "<script>alert('Acceso denegado. Solo para administradores'); window.location.href='index.php';</script>";
  exit;
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Crear publicación</title>
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
    <h2 class="text-center mb-4">Crear nueva publicación</h2>
    <form action="guardar_post.php" method="POST" enctype="multipart/form-data">
      <!-- Título -->
      <div class="mb-3">
        <label for="titulo" class="form-label">Título del artículo</label>
        <input type="text" class="form-control" name="titulo" id="titulo"/>
      </div>

      <!-- Contenido -->
      <div class="mb-3">
        <label for="contenido" class="form-label">Contenido completo</label>
        <textarea class="form-control" name="contenido" id="contenido" rows="7" ></textarea>
      </div>

      <!-- Imagen general -->
      <div class="mb-3">
        <label for="imagen_general" class="form-label">Imagen destacada dentro del contenido</label>
        <input type="file" class="form-control" name="imagen_general" accept="image/*"  />
      </div>

      <!-- Etiquetas -->
      <div class="mb-3">
        <label for="etiquetas" class="form-label">Etiquetas <small>(separadas por comas)</small></label>
        <input type="text" class="form-control" name="etiquetas" id="etiquetas" placeholder="Ej: RECOMENDACIONES,TENDENCIAS" required />
      </div>

      <!-- Imagen portada -->
      <div class="mb-4">
        <label for="portada" class="form-label">Imagen de portada principal</label>
        <input type="file" class="form-control" name="portada" accept="image/*"  />
      </div>

      <!-- Botón de envío -->
      <button type="submit" class="btn btn-primary w-100">Publicar artículo</button>
     
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
