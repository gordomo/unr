<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/funciones.php';

switch ($_REQUEST["action"]) {
	case 'nuevoApunte':
	$name = $_POST['name'];
	$cat_id = $_POST['categoria'];
	$sub_cat_id = $_POST['subcat'];
	$file = $_FILES['fileToUpload'];
	$cat_name = getCategoria($mysqli, $cat_id)[0]["name"];
	$sub_cat_name = getSubCategoria($mysqli, $cat_id)[0]["name"];

	$uploadStatus = uploadFile($file, $cat_name, $sub_cat_name);
	if(isset($uploadStatus['ok']) && $uploadStatus['ok']) {
		if ($stmt = $mysqli->prepare("INSERT INTO apuntes (`name`, `cat_id`, `sub_cat_id`, `file`) VALUES (?, ?, ?, ?)")) {
			$stmt->bind_param('siis', $name, $cat_id, $sub_cat_id, $uploadStatus['ruta']);
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
		$file = $_FILES;
		$id = $_POST['id'];
		$cat_name = $_POST['cat_name'];
		$sub_cat_name = $_POST['sub_cat_name'];

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
			$query = "UPDATE apuntes set `name` = ?, `cat_id` = ?, `sub_cat_id` = ? WHERE `id` = ?";
		} else {
			$query = "UPDATE apuntes set `name` = ?, `cat_id` = ?, `sub_cat_id` = ?, `file` = ? WHERE `id` = ?";
		}
		
		if ($stmt = $mysqli->prepare($query)) {
			if(empty($_FILES)) {
				$stmt->bind_param('siii', $name, $cat_id, $sub_cat_id, $id);
			} else {
				$uploadStatus = uploadFile($_FILES['file'], $cat_name, $sub_cat_name);
				if(isset($uploadStatus['ok']) && $uploadStatus['ok']) {
					$stmt->bind_param('siisi', $name, $cat_id, $sub_cat_id, $uploadStatus['ruta'], $id);
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
		echo json_encode(getSubCategoriasFromCat($mysqli, $idCat));
	exit();
}