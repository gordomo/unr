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
$mensaje = '';
if(isset($_GET['status'])) {
  switch ($_GET['status']) {
    case '0':
    $mensaje = 'Sub sub Categoria agregada/editada correctamente';
    break;
    case '1':
    $mensaje = 'Error preparando la carga. Intente de nuevo';
    break;
    case '2':
    $mensaje = 'Error ejecuntando la consulta. Intente de nuevo';
    break; 
    case '3':
    $mensaje = 'Sub sub Categoria borrada correctamente';
    break; 
    default:

    break;
  }
}

$categorias = getCategorias($mysqli, true);
$subCategorias = getSubCategorias($mysqli, true);
$subsubCategorias = getSubSubCategorias($mysqli, true);

?>

<!DOCTYPE html>
<html >
<head>
  <?php include_once("includes/headerlinks.html"); ?>
  <title>sub</title>
  
  
  
  
</head>
<body>
  <?php include_once("includes/navbar.php") ?>

  <section class="engine"><a href="https://mobirise.co/m">bootstrap table</a></section><section class="mbr-section form1 cid-qFMRtK6Fwd" id="form1-59" data-rv-view="3325">




    <div class="container">
      <div class="row justify-content-center">
        <div class="title col-12 col-lg-8">
          <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">AGREGAR SUB-SUB-CATEGORÍA</h2>
          <p><?= $mensaje ?></p>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="media-container-column col-lg-8">
          <form class="mbr-form" action="controllers/categorias_controller.php" method="post" >
            <input name="action" type="hidden" value="agragarSubSubCategoria">
            <div class="row row-sm-offset">
              <div class="col-md-4 multi-horizontal" data-for="name">
                <div class="form-group">
                  <label class="form-control-label mbr-fonts-style display-7" for="name-form1-59">Nombre</label>
                  <input type="text" class="form-control" name="name" data-form-field="Name" required="" id="name">
                </div>
              </div>
              <div class="col-md-4 multi-horizontal" data-for="email">
                <div class="form-group">
                  <label class="form-control-label mbr-fonts-style display-7" for="email-form1-59">Categoría</label>
                  <select class="form-control" name="catId" required id="categoria">
                    <option value="0">Categorías</option>
                    <?php foreach ($categorias as $cat) { ?>
                    <option value="<?=$cat['id']?>"><?=$cat['name']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4 multi-horizontal" data-for="email">
                <div class="form-group">
                  <label class="form-control-label mbr-fonts-style display-7" for="email-form1-59">Sub Categoría</label>
                  <select class="form-control" name="subcatId" required id="subcat">
                    <option value="">Sub-Categorías</option>
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
  </section>

  <section class="table1 section-table cid-qGqL87yH3z" id="table1-67" data-rv-view="3328">




    <div class="">
      <div class="media-container-row align-center">
        <div class="col-12 col-md-12">
          <h2 class="mbr-section-title mbr-fonts-style mbr-black display-2">SUB SUB CATEGORÍAS</h2>
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
                      <strong>CATEGORIA</strong>
                    </th>
                    <th class="head-item mbr-fonts-style display-4">
                      <strong>SUB CATEGORIA</strong>  
                    </th>
                    <th class="head-item mbr-fonts-style display-4"></th>
                    <th class="head-item mbr-fonts-style display-4"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($subsubCategorias as $subsubCat) { ?>
                  <tr>
                    <td class="body-item mbr-fonts-style display-7" id="cat-<?=$subsubCat['id']?>">
                      <?= $subsubCat['name'] ?>
                    </td>
                    <td class="body-item mbr-fonts-style display-7" id="cat-<?=$subsubCat['id']?>">
                      <select id="selectedCatId-cat-<?=$subsubCat['id']?>" disabled="true" class="selectCat" data-subsub-id="<?=$subsubCat['id']?>">
                        <option>sin categoria</option>
                        <?php foreach ($categorias as $cat) { ?>
                          <option value="<?=$cat['id']?>" <?=($cat['id'] == $subsubCat['cat_id']) ? 'selected' : ''?>><?=$cat['name']?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td class="body-item mbr-fonts-style display-7" id="cat-<?=$subsubCat['id']?>">
                      <select id="selectedSubCatId-cat-<?=$subsubCat['id']?>" disabled="true" class="selectSubCat">
                        <option>sin sub categoria</option>
                        <?php foreach ($subCategorias as $sub) { ?>
                          <option value="<?=$sub['id']?>" <?=($sub['id'] == $subsubCat['sub_cat_id']) ? 'selected' : ''?>><?=$sub['name']?></option>
                        <?php } ?>
                      </select>
                    </td>
                    <td class="body-item mbr-fonts-style display-7">
                      <button type="button" class="btn btn-default btn-sm editar" data-cat-id="cat-<?=$subsubCat['id']?>" data-is-subcat="si2" data-do="e">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                      </button>
                    </td>
                    <td class="body-item mbr-fonts-style display-7">
                      <button type="button" class="btn btn-default btn-sm borrarSubsub" data-is-subcat="si2" data-cat-id="cat-<?=$subsubCat['id']?>">
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