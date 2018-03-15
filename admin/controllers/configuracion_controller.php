<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/funciones.php';

switch ($_REQUEST["action"]) {
	case 'nuevosPrecios':

	$pricePage = $_POST['price-pages'];
	$doubleFas = $_POST['double-fas'];    
	$ringed = $_POST['ringed'];
	$id = 1;

	if ($stmt = $mysqli->prepare("INSERT INTO configuracion (`id`, `price_pages`, `ringed` , `double_fas`) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE `price_pages` = VALUES(price_pages), `ringed` = VALUES(ringed)")) {
		$stmt->bind_param('iddd', $id, $pricePage, $ringed,$doubleFas);
		if (!$stmt->execute()) {
			die(var_dump($stmt));
			header('Location: ../configuracion.php?status=2');        	
		} else {
			$stmt->close();
			header('Location: ../configuracion.php?status=0');
		}
	} else {
		header('Location: ../configuracion.php?status=1');
	}
	break;
	case "editarPrecios":

	$id = 1;

	$pricePage = $_GET['pricePage'];
	$doubleFas = $_GET['doubleFas'];
	$ringed = $_GET['ringed'];

	if ($stmt = $mysqli->prepare("UPDATE configuracion set `price_pages` = ? , `ringed`  = ? , `double_fas`  = ? WHERE `id` = ?")) {
		$stmt->bind_param('dddi', $pricePage, $ringed, $doubleFas, $id);
		if (!$stmt->execute()) {
			die(var_dump($stmt));
			header('Location: ../configuracion.php?status=2');        	
		} else {
			$stmt->close();
			header('Location: ../configuracion.php?status=0');
		}
	} else {
		$message = "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
		header('Location: ../configuracion.php?mensaje='.$message);
	}

	break;
	case "borrarPrecios":
	$id = 1;
	if ($stmt = $mysqli->prepare("DELETE FROM configuracion WHERE `id` = ?")) {
		$stmt->bind_param('i', $id);
		if (!$stmt->execute()) {
			die(var_dump($stmt));
			header('Location: ../configuracion.php?status=2');        	
		} else {
			$stmt->close();
			header('Location: ../configuracion.php?status=0');
		}
	} else {
		die(var_dump($stmt));
		$message = "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
		header('Location: ../configuracion.php?mensaje='.$message);
	}
	break;

	
	
}