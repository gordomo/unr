<?php
include_once '../includes/db_connect.php';
include_once '../includes/funciones.php';

sec_session_start();
$logged = false;
$user = '';
if (login_check($mysqli) == true) {
  if(isset($_SESSION['grup']) && $_SESSION['grup'] != 0) {
    $logged = true;
    $user = $_SESSION['user'];
  }
}

if(!$logged) {
  header("Location: padmin.php");
}
$mensaje = '';
if(isset($_GET['status'])) {
  switch ($_GET['status']) {
    case '0':
    $mensaje = 'Precios agregados/editados correctamente';
    break;
    case '1':
    $mensaje = 'Error preparando la carga. Intente de nuevo';
    break;
    case '2':
    $mensaje = 'Error ejecuntando la consulta. Intente de nuevo';
    break; 
    case '3':
    $mensaje = 'Precios borrados correctamente';
    break; 
    default:

    break;
  }
}

$precios = getPrecios($mysqli);

?>

<!DOCTYPE html>
<html >
<head>
  <title>Precios</title>
  <?php include_once("includes/headerlinks.html"); ?>
</head>
<body>
  <?php 
  include_once("includes/navbar.php");
  
  if($precios->num_rows == 0)
  {    
  ?>

  <section class="mbr-section form1 cid-qFMJ4c68y8" id="form1-56" data-rv-view="3383">
    <div class="container">
      <div class="row justify-content-center">
        <div class="title col-12 col-lg-8">
          <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">AGREGAR PRECIOS</h2>
          <p><?= $mensaje ?></p>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="media-container-column col-lg-8">
          <form class="mbr-form" action="controllers/configuracion_controller.php" method="post">
            <input type="hidden" name="action" value="nuevosPrecios">
            <div class="row row-sm-offset">
              <div class="col-md-4 multi-horizontal" data-for="price-pages">
                <div class="form-group">
                  <label class="form-control-label mbr-fonts-style display-7" for="name-form1-56">Por Página</label>
                  <input type="number" class="form-control" name="price-pages" data-form-field="price-pages" required="" id="price-pages">
                </div>
              </div>
              <div class="col-md-4 multi-horizontal" data-for="ringed">
                <div class="form-group">
                  <label class="form-control-label mbr-fonts-style display-7" for="name-form1-56">Anillado</label>
                  <input type="number" class="form-control" name="ringed" data-form-field="ringed" required="" id="ringed">
                </div>
              </div>  
            </div>
            <span class="input-group-btn">
              <button href="" type="submit" class="btn btn-primary btn-form display-4">Agregar</button>
            </span>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php }?>
  <section class="table1 section-table cid-qGqI5WXIg4" id="table1-62" data-rv-view="3388">




    <div class="container-fluid">
      <div class="media-container-row align-center">
        <div class="col-12 col-md-12">
          <h2 class="mbr-section-title mbr-fonts-style mbr-black display-2">PRECIOS</h2>
          <div class="underline align-center pb-3">
            <div class="line"></div>
          </div>

          <div class="table-wrapper pt-5" style="width: 88%;">
            
            <div class="container-fluid scroll">
              <table class="table table-striped isSearch" cellspacing="0">
                <thead>
                  <tr class="table-heads">
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>Por Página</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">Anillado</th>
                    <th class="head-item mbr-fonts-style display-4"></th>
                    <th class="head-item mbr-fonts-style display-4"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($precios as $pre) { ?>
                  <tr>
                    <td class="body-item mbr-fonts-style display-7" id="price-page">
                      <?= $pre['price_pages'] ?>
                    </td>
                    <td class="body-item mbr-fonts-style display-7" id="ringed">
                      <?= $pre['ringed'] ?>
                    </td>
                    <td class="body-item mbr-fonts-style display-7">
                      <button type="button" class="btn btn-default btn-sm editar-precio" data-do="e">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                      </button>
                    </td>
                    <td class="body-item mbr-fonts-style display-7">
                      <button type="button" class="btn btn-default btn-sm borrar-precio" >
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                      </button>
                    </td>
                  </tr>  
                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include_once("includes/footer.html") ?>
</body>
</html>