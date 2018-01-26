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
  <?php include_once("includes/headerlinks.html"); ?>
  <title>Bienvenido Admin</title>
</head>
<body>
  <?php include_once("includes/navbar.php") ?>

  <section class="header12 cid-qFMckFKfWf mbr-parallax-background" id="header12-4o" data-rv-view="3275">
    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(15, 118, 153);"></div>
    <div class="container  ">
      <div class="media-container">
        <div class="col-md-12 align-center">
          <h1 class="mbr-section-title pb-3 mbr-white mbr-bold mbr-fonts-style display-2">Panel de<br>Administración</h1>


          <?php if($logged) { ?>
          <div class="icons-media-container mbr-white">
            <div class="card col-12 col-md-6 col-lg-3">
              <div class="icon-block">
                <a href="pedidos.php">
                  <span class="mbr-iconfont mbri-layers" media-simple="true"></span>
                </a>
              </div>
              <h5 class="mbr-fonts-style display-5"><a href="pedidos.php" class="text-secondary">Pedidos</a></h5>
            </div>

            <div class="card col-12 col-md-6 col-lg-3">
              <div class="icon-block">
                <a href="carga.php">
                  <span class="mbr-iconfont mbri-smile-face" media-simple="true"></span>
                </a>
              </div>
              <h5 class="mbr-fonts-style display-5"><a href="carga.php" class="text-secondary"></a>
                <a href="carga.php" class="text-success">Usuarios&nbsp;y Saldo&nbsp;</a></h5>
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
                  <a href="historialcarga.php"><span class="mbr-iconfont mbri-chat" style="color: rgb(255, 255, 255);" media-simple="true"></span></a>
                </div>
                <div class="card-box">
                  <h4 class="card-title py-3 mbr-fonts-style display-5"><a href="historialcarga.php" class="text-secondary">Historial de Carga</a></h4>

                </div>
              </div>

              <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-img pb-3">
                  <a href="admin.php"><span class="mbr-iconfont mbri-responsive" style="color: rgb(255, 255, 255);" media-simple="true"></span></a>
                </div>
                <div class="card-box">
                  <h4 class="card-title py-3 mbr-fonts-style display-5"><a href="admin.php" class="text-success">Administradores</a></h4>

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
      <?php include_once("includes/footer.html") ?>
    </body>
    </html>