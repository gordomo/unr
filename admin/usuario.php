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

$id = (isset($_GET['id'])) ? $_GET['id'] : 'no-id';

if (is_numeric($id)) {
    
    $usuario = getUsuario($mysqli, $id);
    $saldo = 0;
    if($usuario['valid']) {
       $saldo = getSaldo($mysqli, $id); 
    }
} else {
  header('Location: carga.php'); 
}    
?>

<!DOCTYPE html>
<html >
<head>
  <title>Usuario</title>
  <?php include_once("includes/headerlinks.html"); ?>
</head>
<body>
  <?php include_once("includes/navbar.php") ?>
  <section class="mbr-section form1 cid-qFMJ4c68y8" style="height: 87vh;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="title col-12 col-lg-8">
          <h2 class="mbr-section-title pb-3 mbr-fonts-style display-2">DETALLES DE USUARIO</h2>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="media-container-column col-lg-8">
          <div class="row row-sm-offset">
              <div class="col-md-4 multi-horizontal" >
                <div class="form-group">
                  <label class="form-control-label" >Nombre: <?=$usuario['nombre']?></label> <br>
                  <label class="form-control-label" >Apellido: <?=$usuario['apellido']?></label><br>
                  <label class="form-control-label" >Email: <?=$usuario['email']?></label> <br>
                </div>
              </div>
              <div class="col-md-4 multi-horizontal" >
                <div class="form-group">
                  <label class="form-control-label" >Dirección: <?=$usuario['dir']?></label> <br>
                  <label class="form-control-label" >Teléfono: <?=$usuario['tel']?></label> <br>
                  <label class="form-control-label" >Usuario validado: <?=($usuario['valid'] == 1) ? 'SI' : 'NO'?></label> <br>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include_once("includes/footer.html") ?>
  </body>
  </html>