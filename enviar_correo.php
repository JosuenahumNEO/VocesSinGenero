<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correo'])) {
    $correo = $_POST['correo'];
    $conn = conectarDB();

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $token = bin2hex(random_bytes(16));
        $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $update = $conn->prepare("UPDATE usuarios SET token_recuperacion = ?, token_expira = ? WHERE correo = ?");
        $update->bind_param("sss", $token, $expira, $correo);
        $update->execute();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'vocessingenero@gmail.com';
            $mail->Password = 'dyec catv xujd rlfg'; // tu contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('vocessingenero@gmail.com', 'VocesSinGenero');
            $mail->addAddress($correo);
            $mail->isHTML(true);
            $mail->Subject = 'Recupera tu contraseña';
            $mail->Body = "Haz clic en el siguiente enlace para cambiar tu contraseña:<br><br>
                <a href='http://localhost/VocesSinGenero-main/nueva_contraseña.php?token=$token'>Recuperar contraseña</a>";

            $mail->send();
            echo "✅ Revisa tu correo para continuar.";
        } catch (Exception $e) {
            echo "❌ Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "❌ Correo no encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>
