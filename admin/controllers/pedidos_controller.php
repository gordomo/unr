<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/funciones.php';

switch ($_REQUEST["action"]) {
        case 'nuevoPedido':
                
            sec_session_start();
            if (login_check($mysqli) == true) {

                $dobleFaz = $_POST['doble-faz'];
                $anillado = $_POST['anillado'];
                $idApunte = $_POST['apunte'];

                if(is_numeric($dobleFaz) && is_numeric($anillado) && is_numeric($idApunte)){
                    
                    $user_mail = $_SESSION['user'];
                    $user = getUsuarioByEmail($mysqli, $user_mail)['id'];

                    $apunte = getApunte($mysqli, $idApunte);

                    $configuracion = getPrecios($mysqli);
                    $precios = $configuracion->fetch_assoc();

                    $precioFinal = $apunte['pages'] * $precios['price_pages'];

                    if($dobleFaz == 1 && $anillado == 1){
                        $precioFinal = ($precioFinal / 2) + $precios['ringed'] ;
                    }
                    elseif($anillado == 1){
                        $precioFinal = $precioFinal + $precios['ringed'];                      
                    }
                    elseif($dobleFaz == 1){
                        $precioFinal = $precioFinal / 2;
                    }
 
                    $file = $apunte['file'];
                    
                    if ($stmt = $mysqli->prepare("INSERT INTO pedidos (`pedido`, `archivo`, `cantidad`, `total`, `estado`, `date`, `usr_id`, `anillado`, `doblefaz`) VALUES (?,'$file',1,$precioFinal,1,NOW(),$user,?,?)")) {
                            $stmt->bind_param('iii', $idApunte,$anillado, $dobleFaz);
                            if (!$stmt->execute()) {
                                    header('Location: ../../mispedidos.php?status=2');        	
                            }
                            $stmt->close();
                            header('Location: ../../mispedidos.php?status=0');
                    } else {
                            header('Location: ../../mispedidos.php?status=1');
                    }

  
                }
                else{
                    header('Location: ../../compra.php?id=$idApunte');
                }

            }
            else{
                header('Location: ../../mispedidos.php');
            }    

	break;
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
