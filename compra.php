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

$idApunte = $_GET['id'];

if(is_numeric($idApunte)) 
{
    $apunte = getApunte($mysqli, $idApunte);
    
    $categoria = getCategoria($mysqli, $apunte['cat_id']);
    
    $subCategoria = getSubCategoria($mysqli, $apunte['sub_cat_id']);
        
    $configuracion = getPrecios($mysqli);
    $precios = $configuracion->fetch_assoc();
      
    $precioFinal = $apunte['pages'] * $precios['price_pages'];
    
    //die(var_dump( $subCategoria));
 
}
else
{
    header('Location: apuntes.php'); 
}    

?>

<!DOCTYPE html>
<html >
<head>
<title>compra</title>
   <?php include_once("includes/headerlinks.html"); ?>
</head>
<body>
    
    <?php include_once("includes/navbar.php");?>

<section class="engine"><a href="https://mobirise.co/j">how to design a website for free</a></section><section class="header3 cid-qDNWd4kudw" id="header3-2w" data-rv-view="3261">


    <div class="container">
        <div class="media-container-row">
            <div class="mbr-figure" style="width: 85%;">
                <img src="assets/images/1622801-10203308569574458-90356929-n-1-960x638.jpg" alt="Mobirise" title="" media-simple="true">
            </div>
            <div class="media-content">
                <h1 class="mbr-section-title mbr-white pb-3 mbr-fonts-style display-2"><?= $categoria['name'] ?></h1>
                
                <div class="mbr-section-text mbr-white pb-3 ">
                    <p class="mbr-text mbr-fonts-style display-5"><strong>Nombre</strong>: <?= $subCategoria['name'] ?><strong><br>Apunte </strong>: &nbsp;<?= $apunte['name'] ?>&nbsp;<br><strong>Cantidad: 1</strong><br><strong>Precio</strong>:<span id="precio-final"> <?= $precioFinal ?></span></p>
                <label class="checkbox-inline"><input type="checkbox" value="" id="doble-faz">Doble faz</label>
                <label class="checkbox-inline"><input type="checkbox" value="<?= $precios['ringed'] ?>" id="anillado">Anillado</label>
                </div>
                <div class="mbr-section-btn"><a class="btn btn-md btn-primary display-4" href="mispedidos.html">Agregar a la cola de impresión</a> <a class="btn btn-md btn-black display-4" href="apuntes.php?id=<?=$categoria['id'] ?>">voler atras&nbsp;</a></div>
            </div>   
        </div>
    </div>

</section>

<section once="" class="cid-qDOhUkRGTQ" id="footer6-2y" data-rv-view="3264">

    

    

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