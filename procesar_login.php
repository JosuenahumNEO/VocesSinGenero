<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['login_intentado'] = true;
    $correo = trim($_POST['correo']);
    $contraseña = $_POST['contraseña'];
    $_SESSION['correo_guardado'] = $correo;

    $conexion = conectarDB();
    $stmt = $conexion->prepare("SELECT id, nombre_usuario, contraseña, foto_perfil, rol FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $nombre_usuario, $hash, $foto_perfil, $rol);
        $stmt->fetch();

        if (password_verify($contraseña, $hash)) {
            session_regenerate_id(); // seguridad
            $_SESSION['usuario_id'] = $id;
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            $_SESSION['foto_perfil'] = $foto_perfil;
            $_SESSION['rol'] = $rol;

            // Guardamos para localStorage
            $_SESSION['local_user'] = [
                'name' => $nombre_usuario,
                'photo' => $foto_perfil,
                'rol' => $rol
            ];

            $stmt->close();
            $conexion->close();

            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error'] = "Contraseña incorrecta.";
        }
    } else {
        $_SESSION['error'] = "Usuario no encontrado.";
    }

    $stmt->close();
    $conexion->close();

    // Redirige a login solo si falla
    header("Location: login.php");
    exit;
}
?>
