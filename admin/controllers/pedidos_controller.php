<?php
include_once '../../includes/db_connect.php';
include_once '../../includes/funciones.php';
require_once('../../includes/phpmailer/class.phpmailer.php');

switch ($_REQUEST["action"]) {
    case 'nuevoPedido':
    case 'nuevoPedidoDesdeForm':
    sec_session_start();
    if (login_check($mysqli) == true) {
        
        if($_REQUEST["action"] == "nuevoPedidoDesdeForm") {
            $idApunte = 0;
        } else {
            $idApunte = isset($_POST['apunte']) ? $_POST['apunte'] : "a";
        }
        
        if (is_numeric($idApunte)) {
            $simpleFaz = (isset($_POST['simpleFaz'])) ? "1" : "0";
            $anillado = (isset($_POST['anillado'])) ? "1" : "0";


            $user_mail = $_SESSION['user'];
            $user = getUsuarioByEmail($mysqli, $user_mail)['id'];
            $saldo = getSaldo($mysqli, $user);

            if($_REQUEST["action"] == "nuevoPedidoDesdeForm") {
                $apunte["id"] = 0;
                $apunte["name"] = $_POST['ApunteName'];
                $apunte["cat_id"] = 0;
                $apunte["sub_cat_id"] = 0;
                $apunte["subsub_cat_id"] = 0;
                
                if ($_FILES['fileToUpload']['size'] > 58483400) {
                    header('Location: ../../pedidoparticular.php?status=15');
                }
                $uploadStatus = uploadFile($_FILES['fileToUpload'], "custom", "custom", "custom");
                if(!$uploadStatus["ok"]) {
                    header('Location: ../../pedidoparticular.php?status=14');
                }
                $apunte["file"] = $uploadStatus["ruta"];
                $hasta = isset($_POST['hasta']) ? $_POST['hasta'] : 0;
                $desde = isset($_POST['desde']) ? $_POST['desde'] : 0;
                if ($hasta <= $desde) {
                    $hasta = $desde + 1;
                }
                $cantidadDePaginas = $hasta - $desde;
                $apunte["pages"] = $cantidadDePaginas;
                
            } else {
                $apunte = getApunte($mysqli, $idApunte);
            }    

            $configuracion = getPrecios($mysqli);
            $precios = $configuracion->fetch_assoc();

            $cantidad = (isset($_POST['cantidad']) && $_POST['cantidad'] >= 1) ? $_POST['cantidad'] : $_POST['cantidadDeApuntes'];

            $precio = ($apunte['pages'] * $precios['double_fas']) * $cantidad;

            $precioAnilladoTotal = 0;
            if ($anillado) {
                $precioAnilladoTotal = $cantidad * $precios['ringed'];
            }
            if ($simpleFaz) {
                $precio = ($precio / $precios['double_fas']) * $precios['price_pages'];
            }

            $precioFinal = round($precio + $precioAnilladoTotal, 2);

            if($saldo < $precioFinal) {
                header('Location: ../../pedidoparticular.php?status=16');
            }
            else {
                $file = $apunte['file'];
                $estado = 1;
                $date = date('Y-m-d H:i:s');
                $admin = 'root';
                $mov = 'pedido';
                $doblefaz = ($simpleFaz) ? 0 : 1;

                if ($stmt = $mysqli->prepare("INSERT INTO pedidos (`nombre`, `archivo`, `cantidad`, `total`, `estado`, `date`, `usr_id`, `anillado`, `doblefaz`, `desde`, `hasta`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
                    $stmt->bind_param('ssddisiiiii', $apunte['name'], $file, $cantidad, $precioFinal, $estado, $date, $user, $anillado, $doblefaz, $desde, $hasta);
                    if (!$stmt->execute()) {
                        header('Location: ../../mispedidos.php?status=2');
                    } else {                       
                            //insert en historico si sale bien la primer operacion
                        $pedido_id = $stmt->insert_id;
                        if ($stmt2 = $mysqli->prepare("INSERT INTO `historial` (`id_usuario`, `admin`, `mov`, `amount`, `date`, `estado`, `cantidad`, `id_pedido`, `desde`, `hasta`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
                            $stmt2->bind_param('issdsiiiii', $user, $admin, $mov, $precioFinal, $date, $estado, $cantidad, $pedido_id, $desde, $hasta);
                            if (!$stmt2->execute()) {
                                header('Location: ../../mispedidos.php?status=2');
                            } else {
                                if ($stmt3 = $mysqli->prepare("UPDATE `saldos` SET `saldo` = `saldo` - ? WHERE `saldos`.`id_usuario` = ?")) {
                                    $stmt3->bind_param('di', $precioFinal, $user);
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
        $emailUsuario = $_POST['emailUsuario'];
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
                        if($nuevoEstado == 3) {
                            avisarPedidoFinalizado($emailUsuario);
                        }    
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


function avisarPedidoFinalizado($toemail) {

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->CharSet = "utf-8";

    //TODO esto debería ir con variables globales
    $smtpHost = "mail.tusapuntes.net";  // Dominio alternativo brindado en el email de alta
    $smtpUsuario = "confirmation@tusapuntes.net";  // Mi cuenta de correo
    $smtpClave = "Aoi12Jjio92";  // Mi contraseña

    // VALORES A MODIFICAR //
    $mail->Host = $smtpHost;
    $mail->Username = $smtpUsuario;
    $mail->Password = $smtpClave;

    $subject = 'Tu Pedido ya está listo';
    $toname = $toemail;

    $mail->SetFrom($smtpUsuario, "tusApuntes.net");
    $mail->AddAddress($toemail, $toname);
    $mail->Subject = $subject;
    
    $message = "Uno de tus pedidos ya se encuentra listo para ser retirado. <br> Muchas gracias por confiar en nosotros.";
    $mail->MsgHTML($message);
    $sendEmail = $mail->Send();

    return $sendEmail;
}