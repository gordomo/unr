<?php
include_once 'includes/db_connect.php';
include_once 'includes/funciones.php';

sec_session_start();
$logged = false;
$user = '';
if (login_check($mysqli) == true) {
  $logged = true;
  $user_mail = $_SESSION['user'];
  $user = getUsuarioByEmail($mysqli, $user_mail);
  $saldo = getSaldo($mysqli, $user['id']);
  $historial = getHistorialForUser($mysqli,$user['id']);
}

$mensaje = '';
if(isset($_GET['status'])) {
  switch ($_GET['status']) {
    case '0':
    $mensaje = 'pedido agregado correctamente';
    break;
    case '1':
    $mensaje = 'Error preparando la carga. Intente de nuevo';
    break;
    case '2':
    $mensaje = 'Error ejecuntando la consulta. Intente de nuevo';
    break;   
    default:

    break;
  }
}

?>
<!DOCTYPE html>
<html >
<head>
  <?php include_once("includes/headerlinks.html"); ?>
  <title>Mis Pedidos</title>
</head>
<body>
  <?php include_once("includes/navbar.php");?>
  <?php if($logged) { ?>
  <section class="mbr-section info1 cid-qDT34MKTzc" id="info1-3m" data-rv-view="3447">
    <div class="container">
      <div class="row justify-content-center content-row">
        <div class="media-container-column title col-12 col-lg-7 col-md-6">
          <h2 class="align-left mbr-bold mbr-fonts-style display-2"></h2>
        </div>
        <div class="media-container-column col-12 col-lg-3 col-md-4">
          <div class="mbr-section-btn align-right py-4">
            <a class="btn btn-primary display-4" href="#table1-3f">
              <span class="mbri-cash mbr-iconfont mbr-iconfont-btn"></span>&nbsp;= $<?=$saldo?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="table1 section-table cid-qDOqk1ywwV" id="table1-3f" data-rv-view="3450">
    <div class="container-fluid">
      <div class="media-container-row align-center">
        <div class="col-12 col-md-12">
          <h2 class="mbr-section-title mbr-fonts-style mbr-black display-2">Mis Pedidos</h2>
          <p><?=$mensaje?></p>
          <div class="underline align-center pb-3">
            <div class="line"></div>
          </div>
          <h3 class="mbr-section-subtitle mbr-light mbr-fonts-style pb-5 pt-3 display-5">Acá podrás observar tus pedidos y su estado, también ver el historial de tus cargas&nbsp;y llevar un control de tus compras.&nbsp;</h3>
          <div class="table-wrapper" style="width: 88%;">
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
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>OPERACIÓN</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>CÓDIGO</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>CANTIDAD</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>TOTAL</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>FECHA</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>NOMBRE</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>ESTADO</strong>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($historial as $row) { ?>
                  <tr> 
                    <td class="body-item mbr-fonts-style display-7"><?=$row['mov']?></td>
                    <td class="body-item mbr-fonts-style display-7"><?=($row['mov'] == "pedido") ? $row['id_pedido'] : ""?></td>
                    <td class="body-item mbr-fonts-style display-7"><?=$row['cantidad']?></td>
                    <td class="body-item mbr-fonts-style display-7"><?=$row['amount']?></td>
                    <td class="body-item mbr-fonts-style display-7"><?=$row['date']?></td>
                    <td class="body-item mbr-fonts-style display-7"><?=($row['id_pedido']) ? getPedido($mysqli, $row['id_pedido'])['nombre'] : ''?></td>
                    <td class="body-item mbr-fonts-style display-7">
                      <?php switch ($row['estado']) {
                        case '1':
                          echo "Pendiente";
                          break;
                        case '2':
                          echo "En proceso";
                          break;
                        case '3':
                          echo "Finalizado";
                          break;
                      }  ?>
                    </td>
                  </tr>  
                  <?php } ?>

                </tbody>
              </table>
            </div>
            <div class="container-fluid table-info-container">
              <div class="row info mbr-fonts-style display-7">
                <div class="dataTables_info">
                  <span class="infoBefore">Mostrando</span>
                  <span class="inactive infoRows"></span>
                  <span class="infoAfter">entradas</span>
                  <span class="infoFilteredBefore">(Filtradas por:</span>
                  <span class="inactive infoRows"></span>
                  <span class="infoFilteredAfter">total)</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php } else { ?>
  <section class="mbr-section info1 cid-qDT34MKTzc" id="info1-3m" data-rv-view="3447">
  </section>  
  <section class="table1 section-table cid-qDOqk1ywwV" id="table1-3f" data-rv-view="3450">
    <div class="container-fluid">
      <div class="media-container-row align-center">
        <div class="col-12 col-md-12">
          <h2 class="mbr-section-title mbr-fonts-style mbr-black display-2">Mis Pedidos</h2>
          <div class="underline align-center pb-3">
            <div class="line"></div>
          </div>
          <h3 class="mbr-section-subtitle mbr-light mbr-fonts-style pb-5 pt-3 display-5">debes acceder a tu cuenta para ver tus pedidos</h3>
        </div>
      </div>
    </div>
  </section>
  <?php } ?>
  <?php include_once("includes/footer.html"); ?>
</body>
</html>