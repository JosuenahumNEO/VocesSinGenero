<?php
include('connection.php');
$con = connection();

$id = $_GET['id']; // ID de la publicación
$tipo_imagen = $_GET['tipo']; // Ej: "Imagen1", "Imagen2", etc.

$sql = "SELECT $tipo_imagen FROM PUBLICACIONES WHERE ID_PUBLICACIONES = $id";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($query);

header("Content-Type: image/jpeg"); // Ajusta según el tipo de imagen (png, jpg, etc.)
echo $row[$tipo_imagen];
?>