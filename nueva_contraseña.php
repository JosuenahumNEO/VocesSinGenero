<?php
require 'conexion.php';

$conn = conectarDB();
$token = $_GET['token'] ?? '';
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nueva = $_POST['nueva'];
    $confirmar = $_POST['confirmar'];
    $token = $_POST['token'];

    if ($nueva !== $confirmar) {
        $mensaje = "❌ Las contraseñas no coinciden.";
    } else {
        $stmt = $conn->prepare("SELECT id, token_expira FROM usuarios WHERE token_recuperacion = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $expira = strtotime($row['token_expira']);
            if (time() > $expira) {
                $mensaje = "❌ El enlace ha expirado. Solicita uno nuevo.";
            } else {
                // ✅ Actualizar contraseña
                $hash = password_hash($nueva, PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE usuarios SET contraseña = ?, token_recuperacion = NULL, token_expira = NULL WHERE id = ?");
                $update->bind_param("si", $hash, $row['id']);
                $update->execute();
                $mensaje = "✅ Contraseña actualizada con éxito.";
            }
        } else {
            $mensaje = "❌ Token inválido.";
        }
    }
}
?>

<h2>Establecer nueva contraseña</h2>
<form method="POST">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <input type="password" name="nueva" placeholder="Nueva contraseña" required><br>
    <input type="password" name="confirmar" placeholder="Confirmar contraseña" required><br>
    <button type="submit">Actualizar</button>
</form>
<p><?= $mensaje ?></p>
