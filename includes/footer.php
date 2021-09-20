<div class="footer-dark">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-md-4 item">
                    <h3>Mapa del sitio</h3>
                    <ul>
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="showcase.php">Galería</a></li>
                        <li><a href="contact.php">Contacto</a></li>

                        <?php
                            if (isset($_SESSION['user'])) {
                                echo '<li><a href="scripts/logout.php">Cerrar sesión</a></li>';
                            } else {
                                echo '<li><a href="login.php">Iniciar sesión</a></li>';
                            }
                        ?>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-4 item">
                    <h3>Contacto</h3>
                    <ul>
                        <li style="color: rgb(240,249,255);"><i class="fas fa-mobile-alt" style="padding-right: 5px;"></i><label id="telephone"><?=$contact_info[0]?></label></li>
                        <li style="color: rgb(240,249,255);"><i class="fas fa-envelope" style="padding-right: 5px;"></i><label id="email"><?=$contact_info[3]?></label></li>
                        <li style="color: rgb(240,249,255);"><i class="fas fa-location-arrow" style="padding-right: 5px;"></i><label id="address"><?=$contact_info[1]?></label></li>
                    </ul>
                </div>
                <!-- <div class="item social col-sm-4 col-md-4">
                    <h3 style="padding-bottom: 10px;">Síguenos en redes sociales</h3>
                    <a href="#" style="margin-bottom: 10px;"><i class="icon ion-social-facebook"></i></a>
                    <a href="#" style="margin-bottom: 10px;"><i class="icon ion-social-twitter"></i></a>
                    <a href="#" style="margin-bottom: 10px;"><i class="icon ion-social-snapchat"></i></a>
                    <a href="#" style="margin-bottom: 10px;"><i class="icon ion-social-instagram"></i></a>
                </div> -->
                <div class="col-sm-4 col-md-4 item">
                    <h3></h3>
                    <ul style="margin-bottom: 0px;">
                        <li>© <?=date('Y')?></li>
                        <li>Sitio web desarrollado por Francisco Gálvez</li>
                        <li><a class="footer_link" href="https://www.github.com/fdgd1998/vigalArtesanos-CMS">github.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>
