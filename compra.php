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

    $subSubCategoria = getSubSubCategoria($mysqli, $apunte['subsub_cat_id']);

    $configuracion = getPrecios($mysqli);
    $precios = $configuracion->fetch_assoc();

    $precioFinal = $apunte['pages'] * $precios['double_fas'];

}
else
{
    header('Location: apuntes.php'); 
}    
$mensaje = '';
if(isset($_GET['status'])) {
  switch ($_GET['status']) {
    case '5':
        $mensaje = 'no cuentas con saldo suficiente para realizar este pedido';
    break;
  }
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

    <section class=""></section>
    <section class="header3 cid-qDNWd4kudw" id="header3-2w" data-rv-view="3261">
        <div class="container">
            <div class="media-container-row">
                <div class="mbr-figure" style="width: 85%; text-align: center;">
                    <p class="mbr-section-title mbr-white pb-3 mbr-fonts-style display-5"><?=$mensaje?></p>
                    <span class="mbr-iconfont mbri-print" media-simple="true" style="font-size: 14rem;color: #fff;"></span>
                </div>
                <div class="media-content">
                    <form class="mbr-form" action="admin/controllers/pedidos_controller.php" method="post">
                        <input type="hidden" value="nuevoPedido" name="action">
                        <input type="hidden" value="<?= $apunte['id'] ?>" name="apunte">
                        <h1 class="mbr-section-title mbr-white pb-3 mbr-fonts-style display-2"><?= $categoria['name'] ?></h1>
                    
                        <div class="mbr-section-text mbr-white pb-3 ">
                            <p class="mbr-text mbr-fonts-style display-5">
                                <strong><?= $subCategoria['name'] ?></strong> - <strong><?= $subSubCategoria['name'] ?></strong><br>
                                <strong>Nombre</strong>: &nbsp;<?= $apunte['name'] ?><br>
                                <?php if($precios['demora']) { ?>
                                    <strong>Demora Promedio</strong>: &nbsp;<?= $precios['demora'] ?> días<br>
                                <?php } ?>    

                            </p>    
                            <p class="mbr-text mbr-fonts-style display-5">
                                <div style="font-size: 25px;">
                                    <strong>Copias:</strong> 
                                    <input type="number" value="1"  min="1" style="height: 35px;width: 65px;" name="cantidad" id="cantidad"> --->
                                    <strong>Precio</strong>:&nbsp;$
                                    <span id="precio-final"><?= $precioFinal ?></span>
                                </div>
                                
                                <div style="font-size: 25px;">
                                    <strong>Paginas:</strong> 
                                    <span><?= $apunte['pages'] ?></span>
                                </div>
                            </p>
                            <p class="mbr-text display-7">
                                <label class="checkbox-inline"><input type="checkbox" name="simpleFaz" id="simple-faz">Simple Faz</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label class="checkbox-inline"><input type="checkbox" name="anillado" id="anillado">Anillado</label>
                            </p>
                        </div>
                        <div class="mbr-section-btn">
                            <div class="row">
                                <div class="col-md-12">
                                    <button href="" type="submit" class="btn btn-md btn-primary display-4" style="width: 100%;">Agregar a la cola de impresión</button> 
                                </div>
                                <div class="col-md-6">    
                                    <a class="btn btn-md btn-black display-4" href="apuntes.php?id=<?=$categoria['id'] ?>" style="border-radius: 0; width: 100%;">volver atrás&nbsp;</a>
                                </div>
                                <div class="col-md-6">    
                                    <a class="btn btn-md btn-black display-4" href="<?= str_replace("..", "admin", $apunte['file'])?>" target="_BLANK" style="border-radius: 0; width: 100%;">ver apunte</a>
                                </div>    
                            </div>    
                        </div>
                    </form>    
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
    <script type="text/javascript">
        var precioSimpleFaz = <?=$precios['price_pages']?>;
        var precioDobleFaz = <?=$precios['double_fas']?>;
        var cantidadPaginas = <?=$apunte['pages']?>;
        var precioAnillados = <?=$precios['ringed']?>;
    </script>

    <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i></i></a></div>
    <input name="animation" type="hidden">
</body>
</html>