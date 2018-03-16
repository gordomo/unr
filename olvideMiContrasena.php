<?php

include_once 'includes/funciones.php';
$logged = false;
$user = '';

$status = (isset($_GET['status'])) ? $_GET['status'] : 3;

?>
<!DOCTYPE html>
<html >
<head>
  <title>Olvidé mi contraseña</title>
  <?php include_once("includes/headerlinks.html"); ?>
</head>
<body>
  <?php 
  include_once("includes/navbar.php");
  ?>

  <section class="engine">
    <a href=""></a>
  </section>
  <section class="cid-qwfntpqnfS mbr-fullscreen mbr-parallax-background" id="header2-e" data-rv-view="2596">



    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);"></div>

    <div class="container align-center">
      <div class="row justify-content-md-center">
        <div class="mbr-white col-md-10">
          <h1>Recuperar contraseña</h1>
          <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1">TusApuntes.net</h1>
          <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">&nbsp;"La librería online de la Facultad de Ciencias Económicas y Estadística"&nbsp;</h3>
          <?php if($status == 1) { ?>
            <h2>&nbsp;Usuario no registrado&nbsp;</h2><br>
          <?php } ?>
          <?php if($status == 2) { ?>
            <h2>&nbsp;No pudimos enviarte el correo, intenta de nuevo más tarde&nbsp;</h2><br>
          <?php } ?>
          <?php if($status != 0) { ?>
            <h2>&nbsp;Ingresa el correo que usaste para registrarte en el sistema para que podamos enviarte tu contraseña&nbsp;</h2><br>

            <form action="includes/process_login.php" method="post" role="form" style="display: block;">
              <input type="hidden" name="action" value="olvideMiContrasena">
              <div class="form-group">
                <input type="email" name="emailUsuario" tabindex="1" class="form-control" placeholder="Email" value="" required="true">
              </div>
              <div class="form-group">
                <div class="row">
                  <input type="submit" tabindex="2" class="form-control btn btn-login" value="Recuperar Contraseña">
                </div>
              </div>
            </form>
          <?php } else { ?>
            <h2>&nbsp;Hemos enviado un correo a la dirección que ingresaste con tu contraseña&nbsp;</h2><br>
          <?php } ?>
          
        </div>
      </div>
    </div>
  </section>

  <section once="" class="cid-qDOhx8EtgS" id="footer6-2x" data-rv-view="2602">





    <div class="container">
      <div class="media-container-row align-center mbr-white">
        <div class="col-12">
          <p class="mbr-text mb-0 mbr-fonts-style display-7">© Copyright 2018 Team Builder - contacto@teambuilder.com.ar</p>
        </div>
      </div>
    </div>
  </section>


  <script src="assets/web/assets/jquery/jquery.min.js"></script>
  <script src="assets/popper/popper.min.js"></script>
  <script src="assets/tether/tether.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/smoothscroll/smooth-scroll.js"></script>
  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>
  <script src="assets/viewportchecker/jquery.viewportchecker.js"></script>
  <script src="assets/parallax/jarallax.min.js"></script>
  <script src="assets/dropdown/js/script.min.js"></script>
  <script src="assets/theme/js/script.js"></script>


  <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i></i></a></div>
  <input name="animation" type="hidden">
</body>
</html>