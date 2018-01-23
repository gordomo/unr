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

// $mensaje = getMensaje($state, $user);
// $categorias = getCategorias($mysqli, false);
// $subCategorias = getSubCategorias($mysqli, false);
?>

<!DOCTYPE html>
<html >
<head>
  <!-- Site made with Mobirise Website Builder v4.5.1, https://mobirise.com -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v4.5.1, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="description" content="Web Site Creator Description">
  <title>apunteca</title>
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

<section class="engine"><a href="https://mobirise.co/n">bootstrap modal</a></section><section class="mbr-section content5 cid-qDTlstB3AY mbr-parallax-background" id="content5-3x" data-rv-view="3578">

    

    <div class="mbr-overlay" style="opacity: 0.4; background-color: rgb(35, 35, 35);">
    </div>

    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <h2 class="align-center mbr-bold mbr-white pb-3 mbr-fonts-style display-1">APUNTES<br></h2>
                
                
                <div class="mbr-section-btn align-center"><a class="btn btn-black display-4" href="index.html">volver</a></div>
            </div>
        </div>
    </div>
</section>

<section class="features3 cid-qDTltotN5L" id="features3-3z" data-rv-view="3583">

    

    
    <div class="container">
        <div class="media-container-row">
            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-wrapper">
                    <div class="card-img">
                        <img src="assets/images/01-1200x800.jpg" alt="Mobirise" title="" media-simple="true">
                    </div>
                    <div class="card-box">
                        <h4 class="card-title mbr-fonts-style display-7">CICLO BÁSICO</h4>
                        
                    </div>
                    <div class="mbr-section-btn text-center"><a href="ciclobasico.html#content5-28" class="btn btn-primary display-4">ver apuntes</a></div>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-wrapper">
                    <div class="card-img">
                        <img src="assets/images/mbr-1-1620x1080.jpg" alt="Mobirise" title="" media-simple="true">
                    </div>
                    <div class="card-box">
                        <h4 class="card-title mbr-fonts-style display-7">
                            CONTADOR PÚBLICO</h4>
                        
                    </div>
                    <div class="mbr-section-btn text-center"><a href="contadorpublico.html" class="btn btn-primary display-4">ver apuntes</a></div>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-wrapper">
                    <div class="card-img">
                        <img src="assets/images/01-1200x800.jpg" alt="Mobirise" title="" media-simple="true">
                    </div>
                    <div class="card-box">
                        <h4 class="card-title mbr-fonts-style display-7">LIC. EN ADMINISTRACION&nbsp;</h4>
                        
                    </div>
                    <div class="mbr-section-btn text-center"><a href="administracion.html#content5-2b" class="btn btn-primary display-4">ver apuntes</a></div>
                </div>
            </div>

            
        </div>
    </div>
</section>

<section class="features3 cid-qDTlsNl2Zs" id="features3-3y" data-rv-view="3586">

    

    
    <div class="container">
        <div class="media-container-row">
            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-wrapper">
                    <div class="card-img">
                        <img src="assets/images/01-1200x800.jpg" alt="Mobirise" title="" media-simple="true">
                    </div>
                    <div class="card-box">
                        <h4 class="card-title mbr-fonts-style display-7">LIC. EN ECONOMÍA</h4>
                        
                    </div>
                    <div class="mbr-section-btn text-center"><a href="economia.html#content5-2e" class="btn btn-primary display-4">
                            ver apuntes</a></div>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-wrapper">
                    <div class="card-img">
                        <img src="assets/images/01-1200x800.jpg" alt="Mobirise" title="" media-simple="true">
                    </div>
                    <div class="card-box">
                        <h4 class="card-title mbr-fonts-style display-7">
                            LIC. EN ESTADÍSTICAS</h4>
                        
                    </div>
                    <div class="mbr-section-btn text-center"><a href="estadisticas.html#content5-2h" class="btn btn-primary display-4">
                            ver apuntes</a></div>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-wrapper">
                    <div class="card-img">
                        <img src="assets/images/01-1200x800.jpg" alt="Mobirise" title="" media-simple="true">
                    </div>
                    <div class="card-box">
                        <h4 class="card-title mbr-fonts-style display-7">
                            OTROS APUNTES</h4>
                        
                    </div>
                    <div class="mbr-section-btn text-center"><a href="otros.html" class="btn btn-primary display-4">
                            ver apuntes</a></div>
                </div>
            </div>

            
        </div>
    </div>
</section>

<section once="" class="cid-qDOjjfAhP7" id="footer6-3s" data-rv-view="3589">

    

    

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
  <script src="assets/viewportchecker/jquery.viewportchecker.js"></script>
  <script src="assets/dropdown/js/script.min.js"></script>
  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>
  <script src="assets/parallax/jarallax.min.js"></script>
  <script src="assets/theme/js/script.js"></script>
  
  
 <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i></i></a></div>
    <input name="animation" type="hidden">
  </body>
</html>