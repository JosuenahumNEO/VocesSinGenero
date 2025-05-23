<?php
session_start();
$error = $_SESSION['error'] ?? '';
$correo_guardado = $_SESSION['correo_guardado'] ?? '';
unset($_SESSION['error'], $_SESSION['correo_guardado'], $_SESSION['login_intentado']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Iniciar Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="articulos.css" rel="stylesheet" />
  <style>
    .input-group-text {
      background: white;
      cursor: pointer;
    }
    .password-check {
      font-size: 0.9rem;
      color: #888;
    }
    .password-check span.valid {
      color: green;
    }
    .password-check span.invalid {
      color: red;
    }
  </style>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card mx-auto p-4 shadow" style="max-width: 500px;">
      <h3 class="text-center mb-4">Iniciar Sesión</h3>
      <form action="procesar_login.php" method="POST">
        <div class="mb-3">
          <label for="correo" class="form-label">Correo electrónico</label>
          <input type="email" class="form-control" id="correo" name="correo"
                 value="<?php echo htmlspecialchars($correo_guardado); ?>" required />
        </div>

        <div class="mb-3">
          <label for="contraseña" class="form-label">Contraseña</label>
          <div class="input-group">
            <input type="password" class="form-control" id="contraseña" name="contraseña" required />
            <span class="input-group-text" onclick="togglePassword()">
              <i id="eyeIcon" class="fa-solid fa-eye-slash"></i>
            </span>
          </div>
        </div>

        <div class="password-check mb-2" id="passwordCheck">
          <span id="length" class="invalid">• Mínimo 8 caracteres</span><br>
          <span id="uppercase" class="invalid">• Una letra mayúscula</span><br>
          <span id="number" class="invalid">• Un número</span><br>
          <span id="special" class="invalid">• Un carácter especial</span>
        </div>

        <?php if ($error): ?>
          <div class="text-danger mb-3"><?php echo $error; ?></div>
        <?php endif; ?>

        <button type="submit" class="btn btn-success w-100">Ingresar</button>
      </form>
      <div class="text-center mt-3">
        <a href="registro.html">¿No tienes cuenta? Regístrate</a>
      </div>
    </div>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('contraseña');
      const icon = document.getElementById('eyeIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      }
    }

    document.getElementById('contraseña').addEventListener('input', function () {
      const val = this.value;
      document.getElementById('length').className = val.length >= 8 ? 'valid' : 'invalid';
      document.getElementById('uppercase').className = /[A-Z]/.test(val) ? 'valid' : 'invalid';
      document.getElementById('number').className = /\d/.test(val) ? 'valid' : 'invalid';
      document.getElementById('special').className = /[!@#$%^&*(),.?":{}|<>]/.test(val) ? 'valid' : 'invalid';
    });
  </script>
</body>
</html>
