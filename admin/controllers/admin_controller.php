<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/funciones.php';

switch ($_REQUEST["action"]) {
	case 'nuevoAdmin':
		$name = $_POST['name'];
		$pass = $_POST['pass'];
		$tipo = $_POST['tipo'];
		// die(var_dump($_POST));
		if ($stmt = $mysqli->prepare("INSERT INTO usuarios (`email`, `pass`, `grup`, `code`, `valid`) VALUES (?, ?, ?, ?, ?)")) {
			$fix = 1;
			$stmt->bind_param('ssiii', $name, $pass, $tipo, $fix, $fix);
			if (!$stmt->execute()) {
				die(var_dump($stmt));
				header('Location: ../admin.php?status=2');        	
			} else {
				$stmt->close();
				header('Location: ../admin.php?status=0');	
			}
		} else {
			header('Location: ../admin.php?status=1');
		}
	break;
	case "editarAdmin":
		$id = $_GET['id'];
		$name = $_GET['name'];
		$pass = $_GET['pass'];
		$tipo = $_GET['tipo'];

		if ($stmt = $mysqli->prepare("UPDATE usuarios set `email` = ?, `pass` = ?, `grup` = ? WHERE `id` = ?")) {
			$stmt->bind_param('ssii', $name, $pass, $tipo, $id);
			if (!$stmt->execute()) {
				die(var_dump($stmt));
				header('Location: ../admin.php?status=2');        	
			}
			else {
				$stmt->close();
				header('Location: ../admin.php?status=0');	
			}
		} else {
			$message = "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
			header('Location: ../admin.php?mensaje='.$message);
		}
		
	break;

	case "borrarAdmin":
		$id = str_replace("user-", '', $_GET['id']);
		
		if ($stmt = $mysqli->prepare("DELETE FROM usuarios WHERE `id` = ?")) {
			$stmt->bind_param('i', $id);
			if (!$stmt->execute()) {
				header('Location: ../admin.php?status=2');        	
			} else {
				$stmt->close();
				header('Location: ../admin.php?status=3');	
			}
		} else {
			$message = "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
			header('Location: ../admin.php?mensaje='.$message);
		}
	break;
}
