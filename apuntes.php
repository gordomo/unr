<?php
include_once 'includes/db_connect.php';
include_once 'includes/funciones.php';

ini_set('xdebug.var_display_max_depth', 5);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 1024);

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
    $subCatArray[$fila['id']]['name'] = $fila['name'];
    $subsub = getSubSubFromSubCategoria($mysqli,$fila['id']);
    while ($subsubarr = $subsub->fetch_array(MYSQLI_ASSOC)) {
      if(isset($subsubarr)) {
        $subCatArray[$fila['id']]['subsub'][$subsubarr['id']] = $subsubarr;
        $apuntes = getApuntesFromSubSubCategoria($mysqli, $subsubarr['id']);
        if(isset($apuntes)) {
          while ($apuntesarr = $apuntes->fetch_array(MYSQLI_ASSOC)) {
            $subCatArray[$fila['id']]['subsub'][$subsubarr['id']]['apuntes'][] = $apuntesarr;
          }
        }
      }
    }
  }

  // die(var_dump($subCatArray[2]));
  
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
          <?php foreach ($subCatArray as $value) { ?>
          <?php if(isset($value['subsub'])) { ?>
          <?php foreach ($value['subsub'] as $subsub) { ?>
          <div class="mbr-gallery-item mbr-gallery-item--p1" data-video-url="false" data-tags="<?=$value['name']?>">
            <div class="subcategoria-div">
              <span class="mbr-gallery-title mbr-fonts-style display-7">
                <?=$subsub['name']?>
              </span>
              <ul class="apuntes-list">
              <?php if(isset($subsub['apuntes'])) { ?>
              
                <?php foreach ($subsub['apuntes'] as $apuntes) { ?>
                <li>
                  <a href="compra.php?id=<?=$apuntes['id']?>"><?=$apuntes['name']?></a>
                </li>
                <?php } ?>
              <?php } else {?>
                <li>
                  Sin apuntes
                </li>      
              <?php } ?>
              </ul>
            </div>
          </div>
          <?php } ?>  
          <?php } ?>
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
  <script type="text/javascript">
    $(".subcategoria-div").click(function showApuntes(){
      $(this).find(".apuntes-list").toggle();
    });
  </script>
</body>
</html>