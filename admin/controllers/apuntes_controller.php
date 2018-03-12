<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/funciones.php';

switch ($_REQUEST["action"]) {
	case 'nuevoApunte':
	$name = $_POST['name'];
	$cat_id = $_POST['categoria'];
	$sub_cat_id = $_POST['subcat'];
        $subsub_cat_id = $_POST['subsubcat'];
        $pages = $_POST['pages'];
	$file = $_FILES['fileToUpload'];
	$cat_name = limpiarString(getCategoria($mysqli, $cat_id)["name"]);
	$sub_cat_name = limpiarString(getSubCategoria($mysqli, $sub_cat_id)["name"]);
    $subsub_cat_name = limpiarString(getSubSubCategoria($mysqli, $subsub_cat_id)["name"]); 
        
	$uploadStatus = uploadFile($file, $cat_name, $sub_cat_name, $subsub_cat_name);
	if(isset($uploadStatus['ok']) && $uploadStatus['ok']) {
		if ($stmt = $mysqli->prepare("INSERT INTO apuntes (`name`, `cat_id`, `sub_cat_id`, `file`, `pages`, `subsub_cat_id` ) VALUES (?, ?, ?, ?, ?, ?)")) {
			$stmt->bind_param('siisii', $name, $cat_id, $sub_cat_id, $uploadStatus['ruta'], $pages, $subsub_cat_id);
			if (!$stmt->execute()) {
				header('Location: ../apuntes.php?status=2');        	
			}
			$stmt->close();
			header('Location: ../apuntes.php?status=0');
		} else {
			header('Location: ../apuntes.php?status=1');
		}
	} else {
		header('Location: ../apuntes.php?status=4');
	}

	break;
	case "editarApunte":
		$name = $_POST['name'];
		$cat_id = $_POST['id_cat'];
		$sub_cat_id = $_POST['sub_cat_id'];
                $subsub_cat_id = $_POST['subsub_cat_id'];
		$file = $_FILES;
		$id = $_POST['id'];
		$cat_name = limpiarString($_POST['cat_name']);
		$sub_cat_name = limpiarString($_POST['sub_cat_name']);
        $subsub_cat_name = limpiarString($_POST['subsub_cat_name']);
        $pages = $_POST['pages'];
                              
		if (!empty($_FILES) && $stmt = $mysqli->prepare("SELECT file FROM apuntes WHERE id=?")) {
			/* ligar parámetros para marcadores */
			$stmt->bind_param("s", $id);
			/* ejecutar la consulta */
			if (!$stmt->execute()) {
				echo json_encode (array("result"=>"ko", "status"=>2));
				exit();
			}
			/* ligar variables de resultado */
			$stmt->bind_result($file);
			/* obtener valor */
			$stmt->fetch();
			/* cerrar sentencia */
			$stmt->close();
			if (file_exists($file)) {
                unlink($file);
            }
		}
		
		if(empty($_FILES)) {
			$query = "UPDATE apuntes set `name` = ?, `cat_id` = ?, `sub_cat_id` = ? , `pages` = ?, `subsub_cat_id` = ? WHERE `id` = ?";
		} else {
			$query = "UPDATE apuntes set `name` = ?, `cat_id` = ?, `sub_cat_id` = ?, `pages` = ?, `file` = ?, `subsub_cat_id` = ? WHERE `id` = ?";
		}
		
		if ($stmt = $mysqli->prepare($query)) {
			if(empty($_FILES)) {
				$stmt->bind_param('siiiii', $name, $cat_id, $sub_cat_id, $pages, $subsub_cat_id, $id);
			} else {
				$uploadStatus = uploadFile($_FILES['file'], $cat_name, $sub_cat_name, $subsub_cat_name);
				if(isset($uploadStatus['ok']) && $uploadStatus['ok']) {
					$stmt->bind_param('siiisii', $name, $cat_id, $sub_cat_id, $pages, $uploadStatus['ruta'], $subsub_cat_id, $id);
				} else {
					echo json_encode (array("result"=>"ko", "status"=>4));
				}
			}
				
			if (!$stmt->execute()) {
				echo json_encode (array("result"=>"ko", "status"=>2));
				exit();
			}
			$stmt->close();
                    
			echo json_encode (array("result"=>"ok", "status"=>0));
			exit();
		} else {
			die(var_dump($stmt));
			echo json_encode (array("result"=>"ko", "status"=>4));
			exit();
		}

	break;
	case "borrarApunte":
		$id = $_GET['id'];

		if ($stmt = $mysqli->prepare("SELECT file FROM apuntes WHERE id=?")) {
			/* ligar parámetros para marcadores */
			$stmt->bind_param("s", $id);
			/* ejecutar la consulta */
			if (!$stmt->execute()) {
				header('Location: ../apuntes.php?status=2');
			}
			/* ligar variables de resultado */
			$stmt->bind_result($file);
			/* obtener valor */
			$stmt->fetch();
			/* cerrar sentencia */
			$stmt->close();
			
			if (file_exists($file)) {
	            unlink($file);
	        }
		}

		if ($stmt = $mysqli->prepare("DELETE FROM apuntes WHERE `id` = ?")) {
			$stmt->bind_param('i', $id);
			if (!$stmt->execute()) {
				header('Location: ../apuntes.php?status=2');        	
			}
			$stmt->close();
			header('Location: ../apuntes.php?status=3');
		} else {
			$message = "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
			header('Location: ../apuntes.php?mensaje='.$message);
		}
	break;

	case "getSubCategoriasFromCat":
		$idCat = $_POST['idCat'];
                $resultado = getSubCategoriasFromCat($mysqli, $idCat);
                $subcategorias = array();
                while ($respuesta = $resultado->fetch_assoc()) {
                  $subcategorias[] = $respuesta;
                }
                if ($resultado) {
                  $resultado->free();
                }
		echo json_encode($subcategorias);
	exit();
        
        case "getSubSubCategoriasFromSubCat":
		$idSubCat = $_POST['idSubCat'];
                $resultado = getSubSubCategoriasFromSubCat($mysqli, $idSubCat);
                $subsubcategorias = array();
                while ($respuesta = $resultado->fetch_assoc()) {
                  $subsubcategorias[] = $respuesta;
                }
                if ($resultado) {
                  $resultado->free();
                }
		echo json_encode($subsubcategorias);
	exit();
}

function limpiarString($texto)
{
      $textoLimpio = preg_replace('([^A-Za-z0-9])', '', $texto);	     					
      return $textoLimpio;
}