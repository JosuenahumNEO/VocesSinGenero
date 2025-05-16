<?php
// listar_publicaciones.php
$conexion = new mysqli("localhost", "root", "", "vsg");
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$consulta = "SELECT id, titulo FROM publicaciones ORDER BY id DESC";
$resultado = $conexion->query($consulta);

if (!$resultado) {
    die("Error al obtener publicaciones: " . $conexion->error);
}
?>

<h2 class="section-title">Gestión de Publicaciones</h2>

<div style="margin-bottom: 20px;">
    <a href="admin.php" class="submit-btn">➕ Nueva Publicación</a>
</div>

<div class="user-table-container">
    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Acciones</th>
            </tr>
        </thead>
          <tbody>
            <?php while ($fila = $resultado->fetch_assoc()) : ?>
            <tr>
                <td><?= $fila['id'] ?></td>
                <td><?= htmlspecialchars($fila['titulo']) ?></td>
                <td>
                    <a class="edit-btn" href="editar_publicacion.php?id=<?= $fila['id'] ?>">✏️ Editar</a>
                    <a class="delete-btn" href="eliminar_publicacion.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar esta publicación?');">🗑️ Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php $conexion->close(); ?>
