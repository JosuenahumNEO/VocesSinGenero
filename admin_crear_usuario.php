<?php
session_start();
require_once 'conexion.php';

// ✅ Proteger el acceso solo a administradores
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    echo "<script>alert('Acceso denegado. Solo administradores.'); window.location.href = 'index.php';</script>";
    exit;
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre_usuario']);
    $correo = trim($_POST['correo']);
    $rol = $_POST['rol'] ?? 'usuario';
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $foto_perfil = "images/usuario.png";

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $dir = "images/perfiles/";
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $nombre_archivo = uniqid() . "_" . basename($_FILES['foto']['name']);
        $ruta_archivo = $dir . $nombre_archivo;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_archivo)) {
            $foto_perfil = $ruta_archivo;
        }
    }

    $conn = conectarDB();
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, correo, contraseña, foto_perfil, rol) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $correo, $contraseña, $foto_perfil, $rol);

    if ($stmt->execute()) {
        $mensaje = "✅ Usuario creado exitosamente.";
    } else {
        $mensaje = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear nuevo usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow mx-auto p-4" style="max-width: 600px;">
      <h3 class="text-center mb-4">Crear nuevo usuario</h3>

      <?php if ($mensaje): ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Nombre de usuario</label>
          <input type="text" class="form-control" name="nombre_usuario" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Correo electrónico</label>
          <input type="email" class="form-control" name="correo" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" class="form-control" name="contraseña" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Foto de perfil (opcional)</label>
          <input type="file" class="form-control" name="foto" accept="image/*">
        </div>

        <div class="mb-3">
          <label class="form-label">Rol</label>
          <select class="form-select" name="rol">
            <option value="usuario">Usuario</option>
            <option value="admin">Administrador</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Crear usuario</button>
      </form>
    </div>
  </div>
</body>
</html>
