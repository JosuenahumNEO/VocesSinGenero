<?php
include('conexion_bd.php');
$id = intval($_POST['id']);
$titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
$descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);

$query = "UPDATE publicaciones SET titulo='$titulo', descripcion='$descripcion' WHERE id=$id";
mysqli_query($conexion, $query);

header('Location: admin.php?success=true');
exit();
?>
