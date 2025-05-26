<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>VocesSinGénero | Inicio</title>
	<link rel="icon" href="images/img/logoblanco.png" type="image/svg+xml" />

	<!-- biblioteca de íconos -->
	<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
		integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
		crossorigin="anonymous"
		referrerpolicy="no-referrer"
	/>
	
</head>

<body>
	<?php  include 'header.php'; ?>
            
            <section class="background-dark-2 team-container">
                <div class="container-team">
                    <h1>Conoce a Nuestro Equipo</h1>
                    <h2>Somos un equipo de 6 integrantes detras de este sitio web, este blog web se basa en el 5to ODS de la ONU. Todos los integrantes de este equipo estuvieron detras del desarrollo de este blog web interactivo</h2>
                    <div class="container team">
                        <div class="member">
                            <img src="https://via.placeholder.com/100" alt="Miembro 1">
                            <h3>Josué Nahúm</h3>
                            <p>Programador</p>
                        </div>
                        <div class="member">
                            <img src="https://via.placeholder.com/100" alt="Miembro 2">
                            <h3>Melany Guadalupe</h3>
                            <p>Programador</p>
                        </div>
                        <div class="member">
                            <img src="images/Desarrolladores/Tona.jpg" alt="Miembro 3">
                            <h3>Roberto Tonatiuh</h3>
                            <p>Base de datos</p>
                        </div>
                        <div class="member">
                            <img src="https://via.placeholder.com/100" alt="Miembro 4">
                            <h3>Miguel Angel</h3>
                            <p>Documentacion</p>
                        </div>
                        <div class="member">
                            <img src="https://via.placeholder.com/100" alt="Miembro 5">
                            <h3>Richie Angelo</h3>
                            <p>Programador</p>
                        </div>
                        <div class="member">
                            <img src="https://via.placeholder.com/100" alt="Miembro 6">
                            <h3>Manuel Sebastian</h3>
                            <p>Documentacion</p>
                        </div>
                    </div>
                </div>

                <a href="index.php"><button>REGRESAR</button></a>

            </section>

                <!-- FOOTER -->
                <footer class="background-dark-1">
                    <div class="container">
                        <div class="content">
                            <div class="container-logo">
                                <img src="images/img/logoblanco.png" alt="Logo" />
                                <span>Voces Sin Género</span>
                            </div>

                            <ul>
                                <li>
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>Dirección: Carretera Manzanillo-Cihuatlán kilómetro 20 El Naranjo, 28860 Manzanillo, Col.
                                    </span>
                                </li>
                                <li>
                                    <i class="fa-solid fa-phone"></i>
                                    <span>+123 456 7890</span>
                                </li>
                            </ul>
                        </div>

                        <div class="container-social-copyright">
                            <ul>
                                <li>
                                    <a href="https://www.facebook.com/share/1PXSEEAPko/" target="_blank">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" target="_blank">
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/vocessingenero?igsh=c3V1cmFzemYyczZp" target="_blank">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://mail.google.com/mail/?view=cm&to=vocessingenero@gmail.com" target="_blank">
                                        <i class="fa-regular fa-envelope"></i>
                                    </a>
                                </li>
                            </ul>

                            <p>&copy; 2025 Voces sin Género. Todas las voces importan. Todos los derechos reservados.</p>
                        </div>
                    </div>
                </footer>

                <script src="js/partials.js"></script>
                <script src="js/home.js"></script>
                <script src="js/testimonial.js"></script>
            </body>
            </html>
