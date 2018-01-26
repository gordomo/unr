<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/funciones.php';

switch ($_REQUEST["action"]) {
	case 'nuevosPrecios':

		$pricePage = $_POST['price-pages'];
                $ringed = $_POST['ringed'];

		if ($stmt = $mysqli->prepare("INSERT INTO configuracion (`price_pages`, `ringed`) VALUES (?,?)")) {
			$stmt->bind_param('ii', $pricePage,$ringed );
			if (!$stmt->execute()) {
				header('Location: ../configuracion.php?status=2');        	
			}
			$stmt->close();
			header('Location: ../configuracion.php?status=0');
		} else {
			header('Location: ../configuracion.php?status=1');
		}
	break;
	case "editarPrecios":

		$id = 0;
            
                $pricePage = $_GET['pricePage'];           
                $ringed = $_GET['ringed'];

		if ($stmt = $mysqli->prepare("UPDATE configuracion set `price_pages` = ? , `ringed`  = ? WHERE `id` = ?")) {
			$stmt->bind_param('iii', $pricePage, $ringed, $id);
			if (!$stmt->execute()) {
				header('Location: ../configuracion.php?status=2');        	
			}
			$stmt->close();
			header('Location: ../configuracion.php?status=0');
		} else {
			$message = "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
			header('Location: ../configuracion.php?mensaje='.$message);
		}
		
	break;
	case "borrarPrecios":
                
                $id = 0;
            
                $query = "DELETE FROM configuracion WHERE `id` = $id";
           
		if ($mysqli->query($query)) {
			header('Location: ../configuracion.php?status=3');
		} else {
			$message = "Falló la ejecución: (" . $mysqli->errno . ") " . $mysqli->error;
			header('Location: ../configuracion.php?mensaje='.$message);
		}
	break;

	
	
}