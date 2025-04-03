<?php
// Incluir la conexión a la base de datos
include 'conexion_bd.php';

try {
    // Consulta SQL
    $sql = "SELECT * FROM publicaciones";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicaciones</title>
</head>
<body>
    <section>
        <div>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Publicación</th>
                    </tr>
                </thead>
                
            <tbody>
               <?php
               while ($filas = mysqli_fetch_assoc($resultado)) {
               ?>
                  <tr>
                     <td><?php echo $filas['id'] ?></td>
                     <td><?php echo $filas['titulo'] ?></td>
                     <td><?php echo $filas['descripcion'] ?></td>
                     <td>
                        -
                        <?php echo "<a href='editaragregar.php?id=" . $filas["id"] . "'><button>EDITAR</button></a>"; ?>
                        -
                        <?php echo "<a href='eliminaragregar.php?id=" . $filas["id"] . "' onclick='return confirmar(\"¿Estás seguro que deseas eliminar los datos del empleado?\")'><button>ELIMINAR</button></a>"; ?>
                     </td>
                  </tr>
               <?php
               }
               ?>
            </tbody>
            </table>
        </div>
    </section>

</body>
</html>
