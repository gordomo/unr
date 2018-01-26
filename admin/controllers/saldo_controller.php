<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/funciones.php';

switch ($_REQUEST["action"]) {
	case 'agregarSaldo':
		
		$saldo = $_POST['saldo'];
		$sumar  = $_POST['sumar'];
		$user_id = $_POST['user'];
		$admin = $_POST['admin'];
		$date = date('Y-m-d H:i:s');
		$nuevoTotal = $saldo + $sumar;

		if ($stmt = $mysqli->prepare("INSERT INTO historial (`id_usuario`, `admin`, `mov`, `amount`, `date`) VALUES (?, ?, ?, ?, ?)")) {
			$mov = "acreditacion";
			$stmt->bind_param('issis', $user_id, $admin, $mov, $sumar, $date);
			if (!$stmt->execute()) {
				die(var_dump($stmt));
				header('Location: ../carga.php?status=2');        	
			}
		} else {
			header('Location: ../carga.php?status=1');
		}
		if ($stmt = $mysqli->prepare("INSERT INTO saldos (`id_usuario`, `saldo`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `id_usuario` = VALUES(id_usuario), `saldo` = VALUES(saldo)")) {
			$stmt->bind_param('ii', $user_id, $nuevoTotal);
			if (!$stmt->execute()) {
				die(var_dump($stmt));
				header('Location: ../carga.php?status=2');        	
			} else {
				$stmt->close();
				header('Location: ../carga.php?status=0');	
			}
		} else {
			header('Location: ../carga.php?status=1');
		}
	break;
}
