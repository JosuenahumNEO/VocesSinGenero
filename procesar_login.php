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
            $_SESSION['usuario_id'] = $id;
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            $_SESSION['foto_perfil'] = $foto_perfil;
            $_SESSION['rol'] = $rol;
            unset($_SESSION['error'], $_SESSION['correo_guardado'], $_SESSION['login_intentado']);

            echo "<script>
                localStorage.setItem('user', JSON.stringify({
                    name: '" . addslashes($nombre_usuario) . "',
                    photo: '" . addslashes($foto_perfil) . "',
                    rol: '" . addslashes($rol) . "'
                }));
                window.location.href = 'index.php';
            </script>";
            exit;
        } else {
            $_SESSION['error'] = "Contraseña incorrecta.";
        }
    } else {
        $_SESSION['error'] = "Usuario no encontrado.";
    }

    $stmt->close();
    $conexion->close();

    header("Location: login.php");
    exit;
}
?>
