<?php



date_default_timezone_set('America/Mexico_City');
$fechaHora = date('Y-m-d H:i:s');






if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //DECLARACION DE VARIABLES
    $nombre = $_POST["nombre"];

    $correo = $_POST["correo"];

    $contraseña = $_POST["contraseña"];

    $confirmarcontraseña = $_POST["confirmarcontraseña"];

    
/*
    $imagen = $_FILES["imagen"]["tmp_name"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar que se haya subido un archivo
        if(isset($_FILES["imagen"]) && !empty($_FILES["imagen"]["tmp_name"])) {
            // Guardar la imagen en una carpeta en el servidor
            $carpeta_destino = "imgestudiantes/";
            $nombre_imagen = $_FILES["imagen"]["name"];
            $ruta_imagen = $carpeta_destino . $nombre_imagen;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_imagen);
        } else {
            // Si no se subió una imagen, establecer la ruta de imagen como vacía
            $ruta_imagen = '';
        }

*/





    //VERFICACION DE DATOS
    if (
        !empty($nombre) &&
        !empty($correo) &&
        !empty($contraseña) &&
        !empty($confirmarcontraseña)
    ) {

/*
        $guardarimagen = "imgemepleados";
        $b = fopen($guardarimagen, "a") or die("No se abrió el archivo :( " . $guardarimagen);
        fwrite($b, $imagen);
        fclose($b);
        $ruta_imagen_db = $carpeta_destino . $nombre_imagen;
*/


        //conectameos base de datos del "Localhost/phpmyadmin"
        $conexion = mysqli_connect("localhost", "root", "", "vsg");
        // Ejecutar la consulta SQL
        $resultado = mysqli_query($conexion, 'INSERT INTO usuarios(usuario, correo, contraseña) 
 VALUES ("' . $nombre . '", "' . $correo . '", "' . $contraseña );

        //EXPORTAR INFORMACION A ARCHIVO DE TEXTO
        $informacionmandada = "--------------------NUEVO REGISTRO--------------------" . "\n" . "                  " . $fechaHora . "\n" .
            "Nombre: " . $nombre . "\n" .
            "CURP: " . $correo . "\n" .
            "Contraseña: " . $confirmarcontraseña . "\n" .
            "Sexo: " . $confirmarcontraseña .
            "\n";


        $archivo = "registros.txt";


        $a = fopen($archivo, "a") or die("No se abrió el archivo :( " . $archivo);
        fwrite($a, $informacionmandada);
        fclose($a);

        header('Location: registro_usuario.php');
    }
} else {
}
