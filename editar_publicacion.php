<?php
include('conexion_bd.php');
$id = intval($_GET['id']);
$resultado = mysqli_query($conexion, "SELECT * FROM publicaciones WHERE id = $id");
$fila = mysqli_fetch_assoc($resultado);
?>

<style>
    :root {
        --primary-color: #278257;
        --secondary-color: #3ec284;
        --background: #f4f6f7;
        --text-color: #2d3436;
        --input-border: 1px solid #ccc;
        --input-focus-border: 1px solid var(--primary-color);
        --border-radius: 8px;
        --transition-fast: 0.3s;
    }

    body {
        background: var(--background);
        font-family: 'Segoe UI', sans-serif;
        padding: 40px;
        color: var(--text-color);
    }

    .post-form {
        max-width: 700px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .post-form h2 {
        font-size: 1.8rem;
        color: var(--primary-color);
        margin-bottom: 25px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .form-group input[type="text"],
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: var(--input-border);
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: border var(--transition-fast), box-shadow var(--transition-fast);
    }

    .form-group input[type="text"]:focus,
    .form-group textarea:focus {
        border: var(--input-focus-border);
        box-shadow: 0 0 5px rgba(39, 130, 87, 0.3);
        outline: none;
    }

    .submit-btn {
        padding: 12px 25px;
        border: none;
        border-radius: var(--border-radius);
        background: var(--primary-color);
        color: white;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background var(--transition-fast);
    }

    .submit-btn:hover {
        background: var(--secondary-color);
    }

    .submit-btn.back-btn {
        background: #ccc;
        color: var(--text-color);
    }

    .submit-btn.back-btn:hover {
        background: #b2bec3;
    }

    form > div:last-child {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 25px;
    }
</style>

<div class="post-form">
    <h2>Editar Publicación</h2>

    <form action="actualizar_publicacion.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($fila['titulo']); ?>" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Contenido:</label>
            <textarea id="descripcion" name="descripcion" rows="8" required><?php echo htmlspecialchars($fila['descripcion']); ?></textarea>
        </div>

        <div>
            <button type="submit" class="submit-btn">💾 Actualizar</button>
            <a href="admin.php" class="submit-btn back-btn">🔙 Regresar</a>
        </div>
    </form>
</div>
