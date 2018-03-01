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

$pedidos = getPedidos($mysqli);

?>
<!DOCTYPE html>
<html >
<head>
  <?php include_once("includes/headerlinks.html"); ?>
  <title>historialcarga</title>
</head>
<body>
  <?php include_once("includes/navbar.php") ?>
  <section class="table1 section-table cid-qGqMbQ6tUo" id="table1-69" data-rv-view="3496">
    <div class="">
      <div class="media-container-row align-center">
        <div class="col-12 col-md-12">
          <h2 class="mbr-section-title mbr-fonts-style mbr-black display-2">PEDIDOS</h2>
          <div class="underline align-center pb-3">
            <div class="line"></div>
          </div>
          <div class="table-wrapper pt-5" style="width: 100%;">
            <div class="">
              <div class="row search">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                  <div class="dataTables_filter">
                    <label class="searchInfo mbr-fonts-style display-7">Search:</label>
                    <input class="form-control input-sm" disabled="">
                  </div>
                </div>
              </div>
            </div>
            <div class="scroll">
              <table class="table table-striped isSearch" cellspacing="0">
                <thead>
                  <tr class="table-heads">
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>Code</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>File</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>Usuario</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>Cant</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>Anillado</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>Doble Faz</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>Total</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>Fecha</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>Estado</strong>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pedidos as $row) { $emailUsuario = getUsuario($mysqli, $row['usr_id'])['email'];?>
                    <tr> 
                      <td class="body-item mbr-fonts-style display-7"><?=$row['id']?></td>
                      <td class="body-item mbr-fonts-style display-7"><a href="<?=str_replace("../", "", $row['archivo'])?>" class="table-link"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td>
                      <td class="body-item mbr-fonts-style display-7"><?=$emailUsuario?></td>
                      <td class="body-item mbr-fonts-style display-7"><?=$row['cantidad']?></td>
                      <td class="body-item mbr-fonts-style display-7"><?=($row['anillado']) ? 'SI' : 'NO'?></td>
                      <td class="body-item mbr-fonts-style display-7"><?=($row['doblefaz']) ? 'SI' : 'NO'?></td>
                      <td class="body-item mbr-fonts-style display-7">$<?=$row['total']?></td>
                      <td class="body-item mbr-fonts-style display-7"><?=$row['date']?></td>
                      <td class="body-item mbr-fonts-style display-7">
                        <select class="estado" data-id-pedido="<?=$row['id']?>" data-id-usuario="<?=$row['usr_id']?>" data-user="<?=$user?>" data-email-usuario="<?=$emailUsuario?>">
                            <option value="1" <?=($row['estado'] == 1) ? 'selected' : ''?>>Confirmado</option>
                            <option value="2" <?=($row['estado'] == 2) ? 'selected' : ''?>>En proceso</option>
                            <option value="3" <?=($row['estado'] == 3) ? 'selected' : ''?>>Finalizado</option>
                        </select>
                        
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
                  </div>
                  <div class="table-info-container">
                    <div class="row info mbr-fonts-style display-7">
                      <div class="dataTables_info">
                        <span class="infoBefore">Mostrando</span>
                        <span class="inactive infoRows"></span>
                        <span class="infoAfter">entradas</span>
                        <span class="infoFilteredBefore">(filtradas de un total de:</span>
                        <span class="inactive infoRows"></span>
                        <span class="infoFilteredAfter">)</span>
                      </div>
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