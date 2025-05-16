<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: LOGIN.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Voces Sin Género</title>
    <meta name="description" content="Plataforma por la equidad de género">
    <meta name="robots" content="index,follow">
    <script src="https://kit.fontawesome.com/13ad7a6a05.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/principal.css">
    <link rel="stylesheet" href="css/inicio.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <div class="container-hero">
            <div class="container hero">
                <div class="customer-support">
                    <i class="fa-solid fa-headset"></i>
                    <div class="content-customer-support">
                        <span class="text">Soporte al cliente</span>
                        <span class="number">123-456-7890</span>
                    </div>
                </div>

                <div class="container-logo">
                    <i class="fa-solid fa-face-meh-blank"></i>
                    <h1 class="logo"><a href="/">Voces Sin Genero</a></h1>
                </div>

                <div class="container-user">
                    <a href="LOGIN.php"><i class="fa-solid fa-user"></i></a>
                    <a href="#"><i class="fa-solid fa-heart"></i></a>
                    <div class="content-shopping-cart">
                        <span class="text">Favoritos</span>
                        <span class="number">(0)</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-navbar">
            <nav class="navbar container">
                <i class="fa-solid fa-bars"></i>
                <ul class="menu">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="opiniones.php">Opiniones</a></li>
                    <li><a href="nosotros.html">Nosotros</a></li>
                    <li><a href="admin.php">Admin</a></li>
                    <li><a href="plantilla.php?id=2">Recuperacion</a></li>
                </ul>

                <form class="search-form" action="buscar.php" method="GET">
                    <input type="search" name="query" placeholder="Buscar...">
                    <button type="submit" class="btn-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </nav>
        </div>
    </header>