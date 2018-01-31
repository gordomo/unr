<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/funciones.php';

switch ($_REQUEST["action"]) {
    case 'nuevoPedido':
        sec_session_start();
        if (login_check($mysqli) == true) {
            $idApunte = $_POST['apunte'];

            if (is_numeric($idApunte)) {
                $doblefaz = (isset($_POST['dobleFaz'])) ? "1" : "0";
                $anillado = (isset($_POST['anillado'])) ? "1" : "0";
                

                $user_mail = $_SESSION['user'];
                $user = getUsuarioByEmail($mysqli, $user_mail)['id'];
                $saldo = getSaldo($mysqli, $user);

                $apunte = getApunte($mysqli, $idApunte);
                $configuracion = getPrecios($mysqli);
                $precios = $configuracion->fetch_assoc();
                
                $cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : 1;
                $precio = $apunte['pages'] * $precios['price_pages'] * $cantidad;

                $precioAnilladoTotal = 0;
                if ($anillado) {
                    $precioAnilladoTotal = $cantidad * $precios['ringed'];
                }
                if ($doblefaz) {
                    $precio = $precio / 2;
                }

                $precioFinal = $precio + $precioAnilladoTotal;

                if($saldo < $precioFinal) {
                    header('Location: ../../compra.php?id='.$apunte['id'] . "&status=5");
                }
                else {
                    $file = $apunte['file'];
                    $estado = 1;
                    $date = date('Y-m-d H:i:s');
                    $admin = 'root';
                    $mov = 'pedido';

                    if ($stmt = $mysqli->prepare("INSERT INTO pedidos (`nombre`, `archivo`, `cantidad`, `total`, `estado`, `date`, `usr_id`, `anillado`, `doblefaz`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
                        $stmt->bind_param('ssiiisiii', $apunte['name'], $file, $cantidad, $precioFinal, $estado, $date, $user, $anillado, $doblefaz);
                        if (!$stmt->execute()) {
                            header('Location: ../../mispedidos.php?status=2');
                        } else {
                            //insert en historico si sale bien la primer operacion
                            $pedido_id = $stmt->insert_id;
                            if ($stmt2 = $mysqli->prepare("INSERT INTO `historial` (`id_usuario`, `admin`, `mov`, `amount`, `date`, `estado`, `cantidad`, `id_pedido`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
                                $stmt2->bind_param('issisiii', $user, $admin, $mov, $precioFinal, $date, $estado, $cantidad, $pedido_id);
                                if (!$stmt2->execute()) {
                                    header('Location: ../../mispedidos.php?status=2');
                                } else {
                                    if ($stmt3 = $mysqli->prepare("UPDATE `saldos` SET `saldo` = `saldo` - ? WHERE `saldos`.`id_usuario` = ?")) {
                                        $stmt3->bind_param('ii', $precioFinal, $user);
                                        if (!$stmt3->execute()) {
                                            die(var_dump($stmt3));
                                            header('Location: ../../mispedidos.php?status=2');
                                        } else {
                                            $stmt->close();
                                            $stmt2->close();
                                            $stmt3->close();
                                            header("Location: ../../categorias.php?id=".$apunte['cat_id']."&status=3");
                                        }
                                    }
                                }
                            } else {
                                $stmt->close();
                                $stmt2->close();
                                header("Location: ../../categorias.php?id=".$apunte['cat_id']."&status=2");
                            }
                        }
                    } else {
                        header('Location: ../../mispedidos.php?status=1');
                    }
                }
            } else {
                header('Location: ../../categorias.php');
            }
        } else {
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
