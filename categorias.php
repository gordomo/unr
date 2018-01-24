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

$categorias = getCategorias($mysqli, false);

?>

<!DOCTYPE html>
<html >
<head>
  <title>categorias</title>
   <?php include_once("includes/headerlinks.html"); ?>
</head>
<body>

    <?php include_once("includes/navbar.php");?>

<section class="mbr-section content5 cid-qDTlstB3AY mbr-parallax-background" id="content5-3x" data-rv-view="3578">
  

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
        <?php while ($fila = $categorias->fetch_array(MYSQLI_ASSOC)) { ?>            
            <div class="card p-3 col-12 col-md-6 col-lg-4">
                <div class="card-wrapper">
                    <div class="card-img">
                        <img src="assets/images/01-1200x800.jpg" alt="Mobirise" title="" media-simple="true">
                    </div>
                    <div class="card-box">
                        <h4 class="card-title mbr-fonts-style display-7"><?= $fila['name'] ?></h4>
                        
                    </div>
                    <div class="mbr-section-btn text-center"><a href="apuntes.php?id=<?= $fila['id'] ?>" class="btn btn-primary display-4">ver apuntes</a></div>
                </div>
            </div>
        <?php } ?>            

            
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

<?php include_once("includes/footer.html"); ?>
    
 <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i></i></a></div>
    <input name="animation" type="hidden">
  </body>
</html>