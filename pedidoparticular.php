<?php
include_once 'includes/db_connect.php';
include_once 'includes/funciones.php';

sec_session_start();
$logged = false;
$user = '';
if (login_check($mysqli) == true) {
  $logged = true;
  $user = $_SESSION['user'];

  $configuracion = getPrecios($mysqli);
  $precios = $configuracion->fetch_assoc();
} else {
  header('Location: index.php');
  exit();
}
$mensaje = '';
if (isset($_GET['status'])) {
  $mensaje = getMensaje($_GET['status']);
}

?>
<!DOCTYPE html>
<html >
<head>
  <title>TusApuntes.net</title>
  <?php include_once("includes/headerlinks.html"); ?>
</head>
<body>
  <?php 
  include_once("includes/navbar.php");
  ?>

  <section class="cid-qwfntpqnfS mbr-fullscreen mbr-parallax-background" id="header2-e" data-rv-view="2596" style="padding-top: 100px;">

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);"></div>

    <div class="container" style="font-size: 24px;">
      <div><h1> <?=$mensaje?> </h1></div>
      <div class="row justify-content-md-center" style="background: #050506ad;">
        <div class="mbr-white col-md-10">
          <form class="mbr-form" action="admin/controllers/pedidos_controller.php" method="post" enctype="multipart/form-data" accept="application/pdf">
            <input type="hidden" name="action" id="action" value="nuevoPedidoDesdeForm">
            <div class="form-group">
              <label for="fileToUpload">Apunte:</label>
              <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" required="true">
            </div>
            <div class="form-group">
              <label for="name">Nombre del apunte:</label>
              <input class="form-control" type="text" name="ApunteName" id="ApunteName" required="true">
            </div>
            <div class="form-group">
              <label for="paginas">Cantidad de Apuntes:</label>
              <input class="form-control" type="number" min="1" value="1" name="cantidadDeApuntes" id="cantidadDeApuntes" required="true">
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="paginas">Desde Página:</label>
                <input class="form-control" type="number" min="1" name="desde" value="1" id="desde" required="true">
              </div>
              <div class="col-md-6">
                <label for="paginas">Hasta Página:</label>
                <input class="form-control" type="number" min="1" name="hasta" value="1" id="hasta" required="true">
              </div>
              <div class="col-md-12">  
                <small id="emailHelp" class="form-text">Solo imprimiremos la cantidad de paginas que ingreses en este campo</small>
              </div>  
            </div>
            <br>
            <div class="row">
              <div class="col-md-4">
                <label for="name">Simple Faz:</label>
                <input type="checkbox" name="simpleFaz" id="simpleFaz">
              </div>
              <div class="col-md-4"> 
                <label for="name">Anillado:</label>
                <input type="checkbox" name="anillado" id="anilladoCustom">
              </div>
              <div class="col-md-4"> 
                <label for="name">Total:</label>
                <span id="precio-final">$0</span>
              </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 35px; font-size: 25px;">Realizar pedido</button>
            <br><br>
          </form>
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


<?php include_once("includes/footer.html"); ?>


  <div id="scrollToTop" class="scrollToTop mbr-arrow-up"><a style="text-align: center;"><i></i></a></div>
  <script type="text/javascript">
    var precioSimpleFaz = <?=$precios['price_pages']?>;
    var precioDobleFaz = <?=$precios['double_fas']?>;
    var precioAnillados = <?=$precios['ringed']?>;
  </script>
</body>
</html>