<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['usuario_id'];
$nuevo_nombre = trim($_POST['nuevo_nombre']);
$nuevo_correo = trim($_POST['nuevo_correo']);
$nueva_contraseña = !empty($_POST['nueva_contraseña']) ? password_hash($_POST['nueva_contraseña'], PASSWORD_DEFAULT) : null;
$nueva_foto = $_SESSION['foto_perfil'];

// Guardar nueva imagen si se sube
if (isset($_FILES['nueva_foto']) && $_FILES['nueva_foto']['error'] === 0) {
    $dir = "images/perfiles/";
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $nombre_archivo = uniqid() . "_" . basename($_FILES['nueva_foto']['name']);
    $ruta_archivo = $dir . $nombre_archivo;

    if (move_uploaded_file($_FILES['nueva_foto']['tmp_name'], $ruta_archivo)) {
        $nueva_foto = $ruta_archivo;
    }
}

$conn = conectarDB();

if ($nueva_contraseña) {
    $stmt = $conn->prepare("UPDATE usuarios SET nombre_usuario = ?, correo = ?, contraseña = ?, foto_perfil = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nuevo_nombre, $nuevo_correo, $nueva_contraseña, $nueva_foto, $id);
} else {
    $stmt = $conn->prepare("UPDATE usuarios SET nombre_usuario = ?, correo = ?, foto_perfil = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nuevo_nombre, $nuevo_correo, $nueva_foto, $id);
}

if ($stmt->execute()) {
    $_SESSION['nombre_usuario'] = $nuevo_nombre;
    $_SESSION['foto_perfil'] = $nueva_foto;

    echo "<script>
        localStorage.setItem('user', JSON.stringify({
            name: '" . addslashes($nuevo_nombre) . "',
            photo: '" . addslashes($nueva_foto) . "'
        }));
        alert('¡Perfil actualizado correctamente!');
        window.location.href = 'index.php';
    </script>";
} else {
    echo "Error al actualizar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
