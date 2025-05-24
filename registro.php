<?php
session_start();
require_once 'conexion.php'; // Archivo para conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $correo = trim($_POST['correo']);
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $foto_perfil = 'images/usuario.png'; // Imagen por defecto

    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
        $dir_subida = 'images/perfiles/';
        if (!is_dir($dir_subida)) {
            mkdir($dir_subida, 0755, true);
        }
        $nombre_archivo = uniqid() . '_' . basename($_FILES['foto_perfil']['name']);
        $ruta_archivo = $dir_subida . $nombre_archivo;
        if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $ruta_archivo)) {
            $foto_perfil = $ruta_archivo;
        }
    }

    $conexion = conectarDB();
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, correo, contraseña, foto_perfil) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre_usuario, $correo, $contraseña, $foto_perfil);

    if ($stmt->execute()) {
        $_SESSION['usuario_id'] = $stmt->insert_id;
        $_SESSION['nombre_usuario'] = $nombre_usuario;
        $_SESSION['foto_perfil'] = $foto_perfil;
        header("Location: index.php");
    } else {
        echo "Error al registrar: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
