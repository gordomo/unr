<?php
include_once 'includes/db_connect.php';
include_once 'includes/funciones.php';

sec_session_start();
$logged = false;
$user = '';
if (login_check($mysqli) == true) {
  $logged = true;
  $user = $_SESSION['user'];
}

$state = 0;

if (isset($_SESSION['state'])) {
  $state = $_SESSION['state'];
  unset($_SESSION['state']);
}

$mensaje = '';

// if(isset($_SESSION['message'])) die(var_dump($_SESSION['message']));

$mensaje = getMensaje($state, $user);

?>
<!DOCTYPE html>
<html >
<head>
  <!-- Site made with Mobirise Website Builder v4.5.1, https://mobirise.com -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v4.5.1, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="description" content="">
  <title>Home</title>
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons/mobirise-icons.css">
  <link rel="stylesheet" href="assets/tether/tether.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="assets/animatecss/animate.min.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">


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
          <h1><?=$mensaje?>
            <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1">TusApuntes.com</h1>
            <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">&nbsp;"La librería online de la Facultad de Ciencias Económicas y Estadística"&nbsp;</h3>


          </div>
        </div>
      </div>
      <div class="mbr-arrow hidden-sm-down" aria-hidden="true">
        <a href="#next">
          <i class="mbri-down mbr-iconfont"></i>
        </a>
      </div>
    </section>

    <section class="header12 cid-qwUpxchJHb mbr-fullscreen" id="header12-10" data-rv-view="2599">



      <div class="mbr-overlay" style="opacity: 0.7; background-color: rgb(35, 35, 35);">
      </div>

      <div class="container  ">
        <div class="media-container">
          <div class="col-md-12 align-center">
            <h1 class="mbr-section-title pb-3 mbr-white mbr-bold mbr-fonts-style display-1">¿Cómo Funciona?</h1>



            <div class="icons-media-container mbr-white">
              <div class="card col-12 col-md-6 col-lg-3">
                <div class="icon-block">
                  <a href="https://mobirise.com/">
                    <span class="mbr-iconfont mbri-user" media-simple="true"></span>
                  </a>
                </div>
                <h5 class="mbr-fonts-style display-5">Creas un usuario &nbsp;completando el formulario de registro con tus datos.</h5>
              </div>

              <div class="card col-12 col-md-6 col-lg-3">
                <div class="icon-block">
                  <a href="https://mobirise.com/">
                    <span class="mbr-iconfont mbri-cash" media-simple="true"></span>
                  </a>
                </div>
                <h5 class="mbr-fonts-style display-5">Cargas la Billetera Virtual en los puntos de carga.</h5>
              </div>

              <div class="card col-12 col-md-6 col-lg-3">
                <div class="icon-block">
                  <a href="https://mobirise.com/">
                    <span class="mbr-iconfont mbri-touch" media-simple="true"></span>
                  </a>
                </div>
                <h5 class="mbr-fonts-style display-5">Seleccionas los apuntes que quieras.</h5>
              </div>

              <div class="card col-12 col-md-6 col-lg-3">
                <div class="icon-block">
                  <a href="https://mobirise.com/">
                    <span class="mbr-iconfont mbri-smile-face" media-simple="true"></span>
                  </a>
                </div>
                <h5 class="mbr-fonts-style display-5">Te avisamos cuando están listos y los retiras.</h5>
              </div>
            </div>
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