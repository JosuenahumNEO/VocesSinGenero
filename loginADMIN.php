<?php
session_start();
include('conexion_bd.php'); // Asegúrate de incluir tu conexión

// Verificar si se enviaron datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);

    // Consulta para verificar credenciales
    $query = "SELECT * FROM admin WHERE nombre = '$usuario' AND contraseña = '$contrasena'";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) == 1) {
        // Credenciales válidas
        $admin = mysqli_fetch_assoc($resultado);
        
        $_SESSION['admin'] = [
            'id_admin' => $admin['id_admin'],
            'nombre' => $admin['nombre'],
            'tipo' => 'admin'
        ];
        
        header('Location: admin.php');
        exit();
    } else {
        // Credenciales inválidas
        $_SESSION['error'] = 'Usuario o contraseña incorrectos';
        header('Location: admin.php');
        exit();
    }
} else {
    // Acceso no autorizado
    header('Location: admin.php');
    exit();
}
?>