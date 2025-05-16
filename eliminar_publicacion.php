<?php
include('conexion_bd.php');
$id = intval($_GET['id']);

mysqli_query($conexion, "DELETE FROM publicaciones WHERE id = $id");

header('Location: admin.php?success=true');
exit();
?>
