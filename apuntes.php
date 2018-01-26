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

$idCategoria = (isset($_GET['id'])) ? $_GET['id'] : 'no-id';

if(is_numeric($idCategoria)) 
{
  $categoria = getCategoria($mysqli,$idCategoria);
  $subCategorias = getSubCategoriasFromCat($mysqli,$idCategoria);
  $subCatArray = [];
  while ($fila = $subCategorias->fetch_array(MYSQLI_ASSOC)) {
    $subCatArray[$fila['id']] = $fila['name'];
  }
  $apuntes = getApuntesFromCategoria($mysqli,$idCategoria);
}
else
{
    header('Location: categorias.php'); 
}    

?>

<!DOCTYPE html>
<html >
<head>
  <title>apuntes</title>
   <?php include_once("includes/headerlinks.html"); ?>
</head>
<body>

   <?php include_once("includes/navbar.php");?>
    

<section class="mbr-section content5 cid-qCodzBq9XL mbr-parallax-background" id="content5-28" data-rv-view="2607">

    
    <div class="mbr-overlay" style="opacity: 0.4; background-color: rgb(35, 35, 35);">
    </div>

    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <h2 class="align-center mbr-bold mbr-white pb-3 mbr-fonts-style display-1"><?= $categoria['name'] ?><br></h2>
                
                
                <div class="mbr-section-btn align-center"><a class="btn btn-black display-4" href="categorias.php">volver</a></div>
            </div>
        </div>
    </div>
</section>

<section class="mbr-gallery mbr-slider-carousel cid-qFM44TTfBE" id="gallery2-4m" data-rv-view="2610">

    

    <div class="container">
        <div><!-- Filter -->
            <div class="mbr-gallery-filter container gallery-filter-active">
                <ul buttons="0">
                    <li class="mbr-gallery-filter-all">
                        <a class="btn btn-md btn-info active display-4" href="">Todos</a>
                    </li>
                </ul>
            </div><!-- Gallery -->
            <div class="mbr-gallery-row">
                <div class="mbr-gallery-layout-default">
                    <?php while ($apunte = $apuntes->fetch_array(MYSQLI_ASSOC)) { ?>     
                            <div class="mbr-gallery-item mbr-gallery-item--p1" data-video-url="false" data-tags="<?= $subCatArray[$apunte['sub_cat_id']] ?>">
                                <div onclick="location.href='compra.html';">
                                    <span class="mbr-gallery-title mbr-fonts-style display-7">
                                        <?= $apunte['name'] ?>
                                    </span>
                                </div>
                            </div>
                         <?php } ?>                                         
                    <div class="clearfix"></div>            
                </div>                    
            </div><!-- Lightbox -->
            
    </div>

</section>

<section once="" class="cid-qDOjjfAhP7" id="footer6-33" data-rv-view="2641">

    

    

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