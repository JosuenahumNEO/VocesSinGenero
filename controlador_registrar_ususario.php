<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registro'])) {
    include('conexion_bd.php');
    // tomar los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmarcontraseña'];

    // verifiicar que las contraseñas coincidan
    if ($contraseña !== $confirmar_contraseña) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // "hashear" la contraseña (encriptarla)
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Preparar la consulta SQL
    $sql = "INSERT INTO usuarios (usuario, correo, contraseña, fecha_registro) VALUES ($nombre, $correo, $contraseña, NOW())";
    $stmt = $conexion->prepare($sql);

    $sql = mysqli_query($conexion, 'INSERT INTO usuarios(usuario,correo,contraseña,fecha_registro) 
    VALUES ("' . $nombre . '", "' . $correo . '", "' . $contraseña . '",
     "' . $sexo . '")');
   
   

    // Bind de los parámetros
    $stmt->bindParam(':usuario', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->bindParam(':contraseña', $contraseña_hash, PDO::PARAM_STR);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Mensaje de éxito
        echo "Usuario registrado correctamente.";

        // Guardar el registro en un archivo de texto
        $fecha = new DateTime('now', new DateTimeZone('America/Mexico_City')); // Zona horaria de México
        $fecha_formateada = $fecha->format('Y-m-d H:i:s'); // Formato de fecha y hora

        // Texto a guardar en el archivo
        $texto_registro = "El usuario $nombre se ha registrado el $fecha_formateada.\n";

        // Guardar en el archivo
        $archivo = 'registros.txt';
        file_put_contents($archivo, $texto_registro, FILE_APPEND | LOCK_EX); // FILE_APPEND añade al archivo, LOCK_EX bloquea el archivo mientras se escribe
    } else {
        echo "Error al registrar el usuario.";
    }
}
?>