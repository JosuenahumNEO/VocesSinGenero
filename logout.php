<?php
session_start();
session_unset();
session_destroy();
// Borrar cookie
setcookie('user_data', '', time() - 3600, "/");

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cerrando sesión...</title>
  <script>
    // Eliminar todos los datos del localStorage
    localStorage.clear();

    // Pequeño delay para asegurar que se limpie antes de redirigir
    setTimeout(() => {
      window.location.href = "index.php";
    }, 200); // 200 ms es suficiente
  </script>
</head>
</html>
