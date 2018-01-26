<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/funciones.php';

switch ($_REQUEST["action"]) {
	case 'cambiarEstado':

	$nuevoEstado = $_POST['nuevoEstado'];
	$pedidoId  = $_POST['pedidoId'];
	$usrId = $_POST['usrId'];
	$date = date('Y-m-d H:i:s');
	$admin = $_POST['admin'];
	$mov = "estado-pedido";
	$amount = 0;
	$cant = 0;

	if ($stmt = $mysqli->prepare("UPDATE pedidos set `estado` = ?, `date` = ? WHERE id = ?")) {
		$stmt->bind_param('isi', $nuevoEstado, $date, $pedidoId);
		if (!$stmt->execute()) {
			echo json_encode(array("status"=>2, "mensaje"=>"fallo la ejecucion"));
			exit();
		} else {
			if ($stmt = $mysqli->prepare("UPDATE historial set `estado` = ?, `date` = ? WHERE id_pedido = ?")) {
				$stmt->bind_param('isi', $nuevoEstado, $date, $pedidoId);
				if (!$stmt->execute()) {
					echo json_encode(array("status"=>2, "mensaje"=>"fallo la ejecucion"));
					exit();
				} else {
					echo json_encode(array("status"=>0, "mensaje"=>""));
					exit();
				}
			} else {
				echo json_encode(array("status"=>1, "mensaje"=>"fallo la preparacion"));
				exit();
			}
		}
	} else {
		echo json_encode(array("status"=>1, "mensaje"=>"fallo la preparacion"));
		exit();
	}
	break;
}
