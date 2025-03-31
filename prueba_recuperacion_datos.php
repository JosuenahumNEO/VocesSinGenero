<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vsg";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID de la publicación
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT titulo, descripcion FROM publicaciones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($titulo, $descripcion);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titulo); ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; text-align: center; }
        .container { max-width: 600px; margin: auto; }
        img { width: 100%; max-width: 300px; margin: 10px 0; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($titulo); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($descripcion)); ?></p>
        <img src="mostrar_imagen.php?id=<?php echo $id; ?>&imagen=imagen1" alt="Imagen 1">
        <img src="mostrar_imagen.php?id=<?php echo $id; ?>&imagen=imagen2" alt="Imagen 2">
        <img src="mostrar_imagen.php?id=<?php echo $id; ?>&imagen=imagen3" alt="Imagen 3">
    </div>
    <?php
   include("publicacionesconexion.php");
   $sql = "select * from publicaciones";
   $conexion = mysqli_connect("localhost", "root", "", "peso1");
   $resultado = mysqli_query($conexion, $sql);
   ?>

    <?php
               while ($filas = mysqli_fetch_assoc($resultado)) {
               ?>
                  <tr>
                     <td><?php echo $filas['id'] ?></td>
                     <td><?php echo $filas['titulo'] ?></td>
                     <td><?php echo $filas['imagen1'] ?></td>
                     <td><?php echo $filas['Fecha de nacimiento'] ?></td>
                     <td><?php echo $filas['Sexo'] ?></td>
                     <td><?php echo $filas['Dirección'] ?></td>
                     <td><?php echo $filas['Teléfono'] ?></td>
                     <td><?php echo $filas['Correo'] ?></td>
                     <td><?php echo $filas['Fecha de ingreso'] ?></td>
                     <td><?php echo $filas['NSS'] ?></td>
                     <td><?php echo $filas['Teléfono de emergencia'] ?></td>
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


</body>
</html>
