<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $correo = trim($_POST['correo']);
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    if ($contraseña !== $confirmar_contraseña) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
        exit;
    }

    if (
        strlen($contraseña) < 8 ||
        !preg_match('/[A-Z]/', $contraseña) ||
        !preg_match('/[a-z]/', $contraseña) ||
        !preg_match('/\d/', $contraseña) ||
        !preg_match('/[^A-Za-z0-9]/', $contraseña)
    ) {
        echo "<script>alert('La contraseña no cumple con los requisitos de seguridad.'); window.history.back();</script>";
        exit;
    }

    $contraseña_hashed = password_hash($contraseña, PASSWORD_DEFAULT);
    $foto_perfil = 'images/usuario.png';

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
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, correo, contraseña, foto_perfil, rol) VALUES (?, ?, ?, ?, 'usuario')");
    $stmt->bind_param("ssss", $nombre_usuario, $correo, $contraseña_hashed, $foto_perfil);

    if ($stmt->execute()) {
        $usuario_id = $stmt->insert_id;

        $_SESSION['usuario_id'] = $usuario_id;
        $_SESSION['nombre_usuario'] = $nombre_usuario;
        $_SESSION['foto_perfil'] = $foto_perfil;
        $_SESSION['rol'] = "usuario";

        $user_data = [
            'id' => $usuario_id,
            'name' => $nombre_usuario,
            'photo' => $foto_perfil,
            'rol' => 'usuario'
        ];

        // Cookie por 30 días
        setcookie("user_data", json_encode($user_data), time() + (86400 * 30), "/");

        // Para localStorage vía index.php
        $_SESSION['local_user'] = $user_data;

        header("Location: index.php");
        exit;
    } else {
        echo "Error al registrar: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
