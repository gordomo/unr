<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/funciones.php';

switch ($_REQUEST["action"]) {
	case 'nuevosPrecios':

		$pricePage = $_POST['price-pages'];
        $ringed = $_POST['ringed'];
        $id = 1;

		if ($stmt = $mysqli->prepare("INSERT INTO configuracion (`id`, `price_pages`, `ringed`) VALUES (?,?,?) ON DUPLICATE KEY UPDATE `price_pages` = VALUES(price_pages), `ringed` = VALUES(ringed)")) {
			$stmt->bind_param('iii', $id, $pricePage, $ringed);
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
        $ringed = $_GET['ringed'];

		if ($stmt = $mysqli->prepare("UPDATE configuracion set `price_pages` = ? , `ringed`  = ? WHERE `id` = ?")) {
			$stmt->bind_param('iii', $pricePage, $ringed, $id);
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