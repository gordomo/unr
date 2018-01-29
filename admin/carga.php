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

$saldos = getSaldos($mysqli);
$usuarios = getUsuariosNoAdmin($mysqli);

?>
<!DOCTYPE html>
<html >
<head>
  <?php include_once("includes/headerlinks.html"); ?>
  <title>carga</title>
</head>
<body>
  <?php include_once("includes/navbar.php") ?>
  <section class="table1 section-table cid-qGqMKKZUMy" id="table1-6a" data-rv-view="3525">
    <div class="container-fluid">
      <div class="media-container-row align-center">
        <div class="col-12 col-md-12">
          <h2 class="mbr-section-title mbr-fonts-style mbr-black display-2">USUARIOS Y CARGA DE SALDO</h2>
          <div class="underline align-center pb-3">
            <div class="line"></div>
          </div>

          <div class="table-wrapper pt-5" style="width: 88%;">
            <div class="container-fluid">
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
            <div class="container-fluid scroll">
              <table class="table table-striped isSearch" cellspacing="0">
                <thead>
                  <tr class="table-heads">
                    <th class="head-item mbr-fonts-style display-4"><strong>USUARIO</strong></th>
                    <th class="head-item mbr-fonts-style display-4"><strong>SALDO</strong></th>
                    <th class="head-item mbr-fonts-style display-4"></th></tr>
                  </thead>
                  <tbody>
                    <?php foreach ($usuarios as $usr) { ?>
                    <tr>
                      <td class="body-item mbr-fonts-style display-7"><?=$usr['email']?></td>
                      <td class="body-item mbr-fonts-style display-7">$<?=getSaldo($mysqli, $usr['id'])?></td>
                      <td class="body-item mbr-fonts-style display-7">
                        <a class="table-link" href="acreditacion.php?id=<?=$usr['id']?>">Agregar Saldo</a>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="container-fluid table-info-container">
                <div class="row info mbr-fonts-style display-7">
                  <div class="dataTables_info">
                    <span class="infoBefore">Showing</span>
                    <span class="inactive infoRows"></span>
                    <span class="infoAfter">entries</span>
                    <span class="infoFilteredBefore">(filtered from</span>
                    <span class="inactive infoRows"></span>
                    <span class="infoFilteredAfter">total entries)</span>
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