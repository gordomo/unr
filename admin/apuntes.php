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
    $mensaje = 'Apunte agregada/editada correctamente';
    break;
    case '1':
    $mensaje = 'Error preparando la carga. Intente de nuevo';
    break;
    case '2':
    $mensaje = 'Error ejecuntando la consulta. Intente de nuevo';
    break; 
    case '3':
    $mensaje = 'Apunte borrada correctamente';
    break; 
    case '4':
    $mensaje = 'No se pudo subir el archivo, intente de nuevo más tarde';
    break; 
    default:

    break;
  }
}

$categorias = getCategorias($mysqli, true);
$subCategorias = getSubCategorias($mysqli, true);
$apuntes = getApuntes($mysqli, true);

?>

<!DOCTYPE html>
<html >
<head>
  <title>apuntes</title>
  <?php include_once("includes/headerlinks.html"); ?>
</head>
<body>
  <?php include_once("includes/navbar.php") ?>
  <section class="mbr-section form1 cid-qFMJ4c68y8">
    <div class="container">
      <div class="row justify-content-center">
        <div class="title col-12 col-lg-8">
          <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">NUEVO APUNTE</h2>
          <p><?=$mensaje?></p>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="media-container-column col-lg-8">
          <form class="mbr-form" action="controllers/apuntes_controller.php" method="post" enctype="multipart/form-data">
            <input type="hidden" value="nuevoApunte" name="action">
            <div class="row row-sm-offset">
              <div class="col-md-4 multi-horizontal" data-for="name">
                <div class="form-group">
                  <label class="form-control-label mbr-fonts-style display-7" for="name">Nombre</label>
                  <input type="text" class="form-control" name="name" required="" id="name-form1-5m">
                </div>
              </div>
              <div class="col-md-4 multi-horizontal" data-for="email">
                <div class="form-group">
                  <label class="form-control-label mbr-fonts-style display-7" for="categoria">Categoría</label>
                  <select class="form-control" name="categoria" required="true" id="categoria">
                    <option value="">Categorías</option>
                    <?php foreach ($categorias as $cat) { ?>
                    <option value="<?=$cat['id']?>"><?=$cat['name']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4 multi-horizontal" data-for="phone">
                <div class="form-group">
                  <label class="form-control-label mbr-fonts-style display-7" for="subcat">Sub-Categoría</label>
                  <select class="form-control" name="subcat" required="true" id="subcat">
                    <option value="">Sub-Categorías</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4 multi-horizontal" data-for="pages">
                <div class="form-group">
                  <label class="form-control-label mbr-fonts-style display-7" for="pages">Cantidad de Páginas</label>
                  <input type="number" class="form-control" name="pages" required="" id="pages">
                </div>
              </div>  
            </div>
            <div class="form-group" data-for="message">
              <label class="form-control-label mbr-fonts-style display-7" for="message-form1-5m">Apunte .PDF</label>
              <input type="file" name="fileToUpload" id="fileToUpload" required="true">
            </div>
            
            <span class="input-group-btn"><button href="" type="submit" class="btn btn-primary btn-form display-4">Agregar</button></span>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section class="table1 section-table cid-qGqJGwS4sW" id="table1-63" data-rv-view="3360">
    <div class="">
      <div class="media-container-row align-center">
        <div class="col-12 col-md-12">
          <h2 class="mbr-section-title mbr-fonts-style mbr-black display-2">APUNTES</h2>
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

          <div class="">
          
            <div class="scroll">
              <table class="table table-striped isSearch" cellspacing="0">
                <thead>
                  <tr class="table-heads">
                    <th class="head-item mbr-fonts-style display-4" hidden="true"></th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>NOMBRE</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">Cat</th>
                    <th class="head-item mbr-fonts-style display-4">Sub-Cat</th>
                    <th class="head-item mbr-fonts-style display-4">Páginas</th>
                    <th class="head-item mbr-fonts-style display-4">File</th>
                    <th class="head-item mbr-fonts-style display-4"></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($apuntes as $apunte) { ?>
                    <tr id="form-apunte-<?=$apunte['id']?>">
                      <td class="body-item mbr-fonts-style display-7" hidden="true"><?= $apunte['name'] ?></td>
                      <td class="body-item mbr-fonts-style display-7">
                        <input type="text" name="name" id="name-<?=$apunte['id']?>" value="<?= $apunte['name'] ?>" class="ab" disabled="true">
                      </td>
                      <td class="body-item mbr-fonts-style display-7" id="cat-<?=$apunte['cat_id']?>">
                        <select id="categoria-<?=$apunte['id'] ?>" class="ab selectCategorias" disabled="true" data-apunte-id="<?=$apunte['id']?>">
                          <option value="0">sin categoria</option>
                          <?php foreach ($categorias as $cat) { ?>
                            <option value="<?=$cat['id']?>" <?=($cat['id'] == $apunte['cat_id']) ? 'selected' : ''?>><?=$cat['name']?></option>
                          <?php } ?>
                        </select>
                      </td>
                      <td class="body-item mbr-fonts-style display-7">
                        <select id="sub-categoria-<?=$apunte['id'] ?>" class="ab" disabled="true">
                          <option value="0">sin sub categoria</option>
                          <?php foreach (getSubCategoriasFromCat($mysqli, $apunte['cat_id']) as $subcat) { ?>
                            <option value="<?=$subcat['id']?>" <?=($subcat['id'] == $apunte['sub_cat_id']) ? 'selected' : ''?>><?=$subcat['name']?></option>
                          <?php } ?>
                        </select>
                      </td>
                      <td class="body-item mbr-fonts-style display-7" >
                        <input type="number" name="pages" id="pages-<?=$apunte['id']?>" value="<?= $apunte['pages'] ?>" class="ab" disabled="true">
                      </td>
                      <td class="body-item mbr-fonts-style display-7" >
                        <input type="file" name="fileToUpload" required="true" id="file-apunte-<?=$apunte['id']?>" value="" class="ab" disabled="true">
                      </td>
                      <td class="body-item mbr-fonts-style display-7">
                        <button type="button" class="btn btn-default btn-sm editar-apunte" data-apunte-id="<?=$apunte['id']?>" data-id-form="form-apunte-<?=$apunte['id']?>" data-do="e">
                          <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm borrar-apunte" data-apunte-id="<?=$apunte['id']?>">
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