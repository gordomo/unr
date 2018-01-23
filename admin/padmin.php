<?php
include_once '../includes/db_connect.php';
include_once '../includes/funciones.php';
session_set_cookie_params(0);
sec_session_start();
$logged = false;
$user = '';
if (login_check($mysqli) == true) {
  if(isset($_SESSION['grup']) && $_SESSION['grup'] != 0) {
    $logged = true;
    $user = $_SESSION['user'];
  }
}
?>

<!DOCTYPE html>
<html >
<head>
  <!-- Site made with Mobirise Website Builder v4.5.1, https://mobirise.com -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v4.5.1, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <meta name="description" content="Site Maker Description">
  <title>Bienvenido Admin</title>
  <link rel="stylesheet" href="../assets/web/assets/mobirise-icons/mobirise-icons.css">
  <link rel="stylesheet" href="../assets/tether/tether.min.css">
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="../assets/animatecss/animate.min.css">
  <link rel="stylesheet" href="../assets/dropdown/css/style.css">
  <link rel="stylesheet" href="../assets/theme/css/style.css">
  <link rel="stylesheet" href="../assets/mobirise/css/mbr-additional.css" type="text/css">
  
  
  
</head>
<body>
  
  <?php 
    include_once("includes/navbar.php")
  ?>

  <section class="header12 cid-qFMckFKfWf mbr-parallax-background" id="header12-4o" data-rv-view="3275">

  

  <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(15, 118, 153);">
  </div>

  <div class="container  ">
    <div class="media-container">
      <div class="col-md-12 align-center">
        <h1 class="mbr-section-title pb-3 mbr-white mbr-bold mbr-fonts-style display-2">Panel de<br>Administración</h1>
        
        
        <?php if($logged) { ?>
        <div class="icons-media-container mbr-white">
          <div class="card col-12 col-md-6 col-lg-3">
            <div class="icon-block">
              <a href="pedidos.html#table1-4r">
                <span class="mbr-iconfont mbri-layers" media-simple="true"></span>
              </a>
            </div>
            <h5 class="mbr-fonts-style display-5"><a href="pedidos.html#table1-4r" class="text-secondary">Pedidos</a></h5>
          </div>

          <div class="card col-12 col-md-6 col-lg-3">
            <div class="icon-block">
              <a href="carga.html">
                <span class="mbr-iconfont mbri-smile-face" media-simple="true"></span>
              </a>
            </div>
            <h5 class="mbr-fonts-style display-5"><a href="carga.html" class="text-secondary"></a><a href="carga.html" class="text-success">Usuarios&nbsp;y Saldo&nbsp;</a></h5>
          </div>

          <div class="card col-12 col-md-6 col-lg-3">
            <div class="icon-block">
              <a href="categorias.php">
                <span class="mbr-iconfont mbri-numbered-list" media-simple="true"></span>
              </a>
            </div>
            <h5 class="mbr-fonts-style display-5"><a href="categorias.php" class="text-secondary">Categorías</a></h5>
          </div>

          <div class="card col-12 col-md-6 col-lg-3">
            <div class="icon-block">
              <a href="apuntes.php">
                <span class="mbr-iconfont mbri-print" media-simple="true"></span>
              </a>
            </div>
            <h5 class="mbr-fonts-style display-5"><a href="apuntes.php" class="text-success">Apuntes</a></h5>
          </div>



          <div class="card p-3 col-12 col-md-6 col-lg-4">
            <div class="card-img pb-3">
              <a href="sub.php"><span class="mbr-iconfont mbri-numbered-list" style="color: rgb(255, 255, 255);" media-simple="true"></span></a>
            </div>
            <div class="card-box">
              <h4 class="card-title py-3 mbr-fonts-style display-5"><a href="sub.php" class="text-success">Sub Categor</a>ías</h4>
              
            </div>
          </div>

          <div class="card p-3 col-12 col-md-6 col-lg-4">
            <div class="card-img pb-3">
              <a href="historialcarga.html"><span class="mbr-iconfont mbri-chat" style="color: rgb(255, 255, 255);" media-simple="true"></span></a>
            </div>
            <div class="card-box">
              <h4 class="card-title py-3 mbr-fonts-style display-5"><a href="historialcarga.html" class="text-secondary">Historial de Carga</a></h4>
              
            </div>
          </div>

          <div class="card p-3 col-12 col-md-6 col-lg-4">
            <div class="card-img pb-3">
              <a href="admin.html"><span class="mbr-iconfont mbri-responsive" style="color: rgb(255, 255, 255);" media-simple="true"></span></a>
            </div>
            <div class="card-box">
              <h4 class="card-title py-3 mbr-fonts-style display-5"><a href="admin.html" class="text-success">Administradores</a></h4>
              
            </div>
          </div>
          <?php } else { ?>
          <h1 class="mbr-section-title pb-3 mbr-white mbr-bold mbr-fonts-style display-2"> por favor... ingrese al sistema
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  
</section>

<section once="" class="cid-qDOjjfAhP7" id="footer6-4i" data-rv-view="3283">

  

  

  <div class="container">
    <div class="media-container-row align-center mbr-white">
      <div class="col-12">
        <p class="mbr-text mb-0 mbr-fonts-style display-7">© Copyright 2018 Team Builder - contacto@teambuilder.com.ar</p>
      </div>
    </div>
  </div>
</section>


<script src="../assets/web/assets/jquery/jquery.min.js"></script>
<script src="../assets/popper/popper.min.js"></script>
<script src="../assets/tether/tether.min.js"></script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/smoothscroll/smooth-scroll.js"></script>
<script src="../assets/viewportchecker/jquery.viewportchecker.js"></script>
<script src="../assets/dropdown/js/script.min.js"></script>
<script src="../assets/touchswipe/jquery.touch-swipe.min.js"></script>
<script src="../assets/parallax/jarallax.min.js"></script>
<script src="../assets/theme/js/script.js"></script>



<div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i></i></a></div>
<input name="animation" type="hidden">
</body>
</html>