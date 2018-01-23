<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/funciones.php';

switch ($_REQUEST["action"]) {
	case 'nuevaCategoria':

		$name = $_POST['name'];

		if ($stmt = $mysqli->prepare("INSERT INTO categorias (`name`) VALUES (?)")) {
			$stmt->bind_param('s', $name);
			if (!$stmt->execute()) {
				header('Location: ../categorias.php?status=2');        	
			}
			$stmt->close();
			header('Location: ../categorias.php?status=0');
		} else {
			header('Location: ../categorias.php?status=1');
		}
	break;
	case "editarCategoria":
		$id = str_replace("cat-", '', $_GET['id']);
		$val = $_GET['val'];

		if ($stmt = $mysqli->prepare("UPDATE categorias set `name` = ? WHERE `id` = ?")) {
			$stmt->bind_param('si', $val, $id);
			if (!$stmt->execute()) {
				header('Location: ../categorias.php?status=2');        	
			}
			$stmt->close();
			header('Location: ../categorias.php?status=0');
		} else {
			$message = "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
			header('Location: ../categorias.php?mensaje='.$message);
		}
		
	break;

	case "borrarCategoria":
		$id = str_replace("cat-", '', $_GET['id']);
		
		if ($stmt = $mysqli->prepare("DELETE FROM categorias WHERE `id` = ?")) {
			$stmt->bind_param('i', $id);
			if (!$stmt->execute()) {
				header('Location: ../categorias.php?status=2');        	
			}
			$stmt->close();
			header('Location: ../categorias.php?status=3');
		} else {
			$message = "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
			header('Location: ../categorias.php?mensaje='.$message);
		}
	break;

	case "agragarSubCategoria":
		$name = $_POST['name'];
		$catId = $_POST['catId'];

		if ($stmt = $mysqli->prepare("INSERT INTO subcategorias (`name`, `cat_id`) VALUES (?, ?)")) {
			$stmt->bind_param('si', $name, $catId);
			if (!$stmt->execute()) {
				header('Location: ../sub.php?status=2');        	
			}
			$stmt->close();
			header('Location: ../sub.php?status=0');
		} else {
			header('Location: ../sub.php?status=1');
		}
	break;

	case "editarSubCategoria":
		$name = $_GET['name'];
		$catId = $_GET['catId'];
		$id = str_replace("cat-", '', $_GET['id']);
		
		if ($stmt = $mysqli->prepare("UPDATE subcategorias set `name` = ? , `cat_id` = ? WHERE `id` = ?")) {
			$stmt->bind_param('sii', $name, $catId, $id);
			if (!$stmt->execute()) {
				header('Location: ../sub.php?status=2');        	
			}
			$stmt->close();
			header('Location: ../sub.php?status=0');
		} else {
			header('Location: ../sub.php?status=1');
		}
	break;

	case "borrarSubCategoria":
		$id = str_replace("cat-", '', $_GET['id']);
		
		if ($stmt = $mysqli->prepare("DELETE FROM subcategorias WHERE `id` = ?")) {
			$stmt->bind_param('i', $id);
			if (!$stmt->execute()) {
				header('Location: ../sub.php?status=2');        	
			}
			$stmt->close();
			header('Location: ../sub.php?status=3');
		} else {
			$message = "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
			header('Location: ../sub.php?mensaje='.$message);
		}
	break;
	
}