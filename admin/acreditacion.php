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
if(!$logged) {
  header("Location: padmin.php");
}

$id = (isset($_GET['id'])) ? $_GET['id'] : 'no-id';

if (is_numeric($id)) {
    
    $usuario = getUsuario($mysqli, $id);
    
    if($usuario['valid']){
       $saldo = getSaldo($mysqli, $id); 
    }
    else
    {
      header('Location: carga.php'); 
    }      
}
else
{
  header('Location: carga.php'); 
}    


?>


<!DOCTYPE html>
<html >
  <head>
    <?php include_once("includes/headerlinks.html"); ?>
    <title>acreditación</title>
  </head>
  <body>
  <?php include_once("includes/navbar.php") ?>
    <section class="header13 cid-qDTEMu69hb mbr-parallax-background" id="header13-4c" data-rv-view="3267">
        <div class="container">
            <h1 class="mbr-section-title align-center pb-3 mbr-white mbr-bold mbr-fonts-style display-1">CARGA DE SALDO</h1>
            <h3 class="mbr-section-subtitle mbr-fonts-style display-5">
              <strong>Usuario&nbsp;</strong>: <?=$usuario['email']?><br>
              <strong>Saldo Actual :</strong> <b id="saldoActual">$<?=$saldo?></b><br>
            </h3>
            <div class="container mt-5 pt-5 pb-5">
                <div class="media-container-column">
                    <form class="form-inline" action="controllers/saldo_controller.php" method="post">
                        <input type="hidden" value="agregarSaldo" name="action">
                        <input type="hidden" value="<?=$user?>" name="admin">
                        <input type="hidden" value="<?=$usuario['id']?>" name="user">
                        <input type="hidden" value="<?=$saldo?>" name="saldo">
                        <div class="form-group">
                            <input type="number" class="form-control input-sm input-inverse" name="sumar" required="true" placeholder="Saldo a Cargar" id="sumar">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control input-sm input-inverse" name="total" required="true" placeholder="Nuevo Total" id="total" disabled="true">
                        </div>
                        <div class="buttons-wrap">
                          <button href="" class="btn btn-primary display-4" type="submit" role="button">Agregar saldo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
  <?php include_once("includes/footer.html") ?>
  </body>
</html>