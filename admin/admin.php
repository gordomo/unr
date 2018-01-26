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
  header("Lousrion: padmin.php");
}
$users = getUsuariosAdministradores($mysqli);
// foreach ($users as $value) {
//   var_dump($value);
// }
// die("fin");
$mensaje = '';
if(isset($_GET['status'])) {
  switch ($_GET['status']) {
    case '0':
    $mensaje = 'Admin agregada/editada correctamente';
    break;
    case '1':
    $mensaje = 'Error preparando la carga. Intente de nuevo';
    break;
    case '2':
    $mensaje = 'Error ejecuntando la consulta. Intente de nuevo';
    break; 
    case '3':
    $mensaje = 'Admin borrada correctamente';
    break; 
    case '4':
    $mensaje = 'El usuario ya existe';
    break; 
    default:

    break;
  }
}

?>

<!DOCTYPE html>
<html >
<head>
  <title>admin</title>
  <?php include_once("includes/headerlinks.html"); ?>
</head>
<body>
  <?php include_once("includes/navbar.php") ?>
  <section class="mbr-section form1 cid-qFMJ4c68y8">
    <div class="container">
      <div class="row justify-content-center">
        <div class="title col-12 col-lg-8">
          <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">AGREGAR ADMIN</h2>
          <p><?=$mensaje?></p>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="media-container-column col-md-12" >
          <div class="container">
            <div class="row justify-content-center">
              <div class="media-container-column col-md-12">
                <form class="mbr-form" action="controllers/admin_controller.php" method="post">
                  <input type="hidden" name="action" value="nuevoAdmin">
                  <div class="row row-sm-offset">
                    <div class="col-md-4 multi-horizontal" >
                      <div class="form-group">
                        <label class="form-control-label mbr-fonts-style display-7" >Usuario</label>
                        <input type="text" class="form-control" name="name" required="true">
                      </div>
                    </div>
                    <div class="col-md-4 multi-horizontal" >
                      <div class="form-group">
                        <label class="form-control-label mbr-fonts-style display-7" >Contraseña</label>
                        <input type="text" class="form-control" name="pass" required="true" >
                      </div>
                    </div>
                    <div class="col-md-4 multi-horizontal" >
                      <div class="form-group">
                        <label class="form-control-label mbr-fonts-style display-7" >Tipo</label>
                        <select type="text" class="form-control" name="tipo" required="true">
                          <option value="1">General</option>
                          <option value="2">Administrador</option>
                        </select>
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
        </div>
      </div>
    </section>

    <section class="table1 section-table cid-qGqI5WXIg4" id="table1-62" data-rv-view="3388">




      <div class="container-fluid">
        <div class="media-container-row align-center">
          <div class="col-12 col-md-12">
            <h2 class="mbr-section-title mbr-fonts-style mbr-black display-2">Usuarios Administradores</h2>
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
                      <th class="head-item mbr-fonts-style display-4">
                        <strong>NOMBRE</strong>
                      </th>
                      <th class="head-item mbr-fonts-style display-4">
                        <strong>PASS</strong>
                      </th>
                      <th class="head-item mbr-fonts-style display-4">
                        <strong>TIPO</strong>
                      </th>
                      <th class="head-item mbr-fonts-style display-4"></th>
                      <th class="head-item mbr-fonts-style display-4"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($users as $usr) { ?>
                    <tr>
                      <td class="body-item mbr-fonts-style display-7" id="usr-<?=$usr['id']?>">
                        <input type="text" name="email" id="email-<?=$usr['id']?>" value="<?= $usr['email'] ?>" disabled="true">
                      </td>
                      <td class="body-item mbr-fonts-style display-7" id="usr-<?=$usr['id']?>">
                        <input type="password" name="pass" id="pass-<?=$usr['id']?>" value="<?= $usr['pass'] ?>" disabled="true">
                      </td>
                      <td class="body-item mbr-fonts-style display-7" id="usr-<?=$usr['id']?>">
                        <select name="tipo" id="tipo-<?=$usr['id']?>" disabled="true">
                          <option value="1" <?=($usr['grup'] == "1") ? 'selected' : ''?>>General</option>
                          <option value="2" <?=($usr['grup'] == "2") ? 'selected' : ''?>>Administrador</option>
                        </select>
                      </td>
                      <td class="body-item mbr-fonts-style display-7">
                        <button type="button" class="btn btn-default btn-sm editar-admin" data-usr-id="<?=$usr['id']?>" data-do="e">
                          <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                      </td>
                      <td class="body-item mbr-fonts-style display-7">
                        <button type="button" class="btn btn-default btn-sm borrar-admin" data-is-subusr="no" data-usr-id="<?=$usr['id']?>">
                          <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
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