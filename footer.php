<footer class="footer">
        <div class="container container-footer">
            <div class="menu-footer">
                <div class="contact-info">
                    <p class="title-footer">Información de Contacto</p>
                    <ul>
                        <li>Dirección: Carretera Manzanillo-Cihuatlán</li>
                        <li>Teléfono: 123-456-7890</li>
                        <li>Email: vocessingenero@gmail.com</li>
                    </ul>
                    <div class="social-icons">
                        <a href="#" class="facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="x"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="youtube"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" class="instagram"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>

                <div class="information">
                    <p class="title-footer">Enlaces útiles</p>
                    <ul>
                        <li><a href="politica-privacidad.php">Política de Privacidad</a></li>
                        <li><a href="terminos.php">Términos y Condiciones</a></li>
                        <li><a href="equipo.php">Nuestro Equipo</a></li>
                        <li><a href="contacto.php">Contáctanos</a></li>
                    </ul>
                </div>

                <div class="newsletter">
                    <p class="title-footer">Boletín informativo</p>
                    <div class="content">
                        <p>Suscríbete para recibir actualizaciones:</p>
                        <form action="suscribir.php" method="POST">
                            <input type="email" name="email" placeholder="Ingresa tu correo" required>
                            <button type="submit" class="btn-suscribir">Suscribirse</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> Voces Sin Género. Todos los derechos reservados.</p>
                <p>Desarrollado por [Tu nombre o equipo]</p>
            </div>
        </div>
    </footer>
    
    <script src="js/script.js"></script>
</body>
</html>