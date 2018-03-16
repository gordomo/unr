<?php
include_once 'db_connect.php';
include_once 'funciones.php';

require_once('phpmailer/class.phpmailer.php');

sec_session_start(); // Our custom secure way of starting a PHP session.

switch ($_REQUEST["action"]) {
    case 'register':
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $dni = $_POST['dni'];
        $tel = $_POST['tel'];
        $name = $_POST['name'];
        $lastName = $_POST['lastName'];
        $dir = $_POST['dir'];

        $stmt = $mysqli->prepare("SELECT pass, grup FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->bind_param('s', $email);

            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                //If the user exists get variables from result.
                $stmt->bind_result($passwordDB, $grup);
                $stmt->fetch();
                $stmt->close();
                if ($password == $passwordDB) {
                    //Logged In!!!!
                    $_SESSION['user_login_checked'] = true;
                    $_SESSION['user'] = $email;
                    $_SESSION['state'] = 6;
                    $_SESSION['grup'] = $grup;
                    header('Location: ../index.php');
                    exit();
                } else {
                    //Not logged in
                    $_SESSION['user_login_checked'] =  false;
                    $_SESSION['state'] = 7;
                    header("Location: ../index.php");
                }
            } else {
                $code = generateRandomString();

                if ($stmt = $mysqli->prepare("INSERT INTO usuarios (`email`, `pass`, `code`, `dni`, `nombre`, `apellido`, `dir`, `tel`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
                    $stmt->bind_param('ssssssss', $email, $password, $code, $dni, $name, $lastName, $dir, $tel);
                    if (!$stmt->execute()) {
                        $message = "Falló la ejecución: (" . $stmt->errno . ") " . $stmt->error;
                        $_SESSION['state'] = 13;
                        $_SESSION['message'] = $message;
                        header('Location: ../index.php');
                    }

                    $stmt->close();
                    $_SESSION['user_login_checked'] = true;
                    $_SESSION['user'] = $email;

                    $link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . "/includes/process_login.php?action=validarEmail&validationCode=".$code."&email=".$email;
                    $message = "Bienvenido a TusApuntes.com ----- <br><br>Por favor, sigue el link para validar tu correo o copia y pega la dirección en tu navegador <br><a href='".$link."'>".$link."</a>";

                    $sendEmail = enviarMail($message, $email);
                    
                    if ($sendEmail == true) {
                        $_SESSION['state'] = 1;
                        header('Location: ../index.php');
                    } else {
                        $_SESSION['state'] = 9;
                        header('Location: ../index.php');
                    }
                    header('Location: ../index.php');
                } else {
                    $message = "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
                    $_SESSION['state'] = 12;
                    $_SESSION['message'] = $message;
                    header('Location: ../index.php');
                }
            }
        } else {
            $_SESSION['state'] = 2;
            header('Location: ../index.php');
        }
        break;
        case 'login':
        if (isset($_POST['emailUsuario'], $_POST['passwordUsuario'])) {
            $email = $_POST['emailUsuario'];
            $password = $_POST['passwordUsuario'];

            $stmt = $mysqli->prepare("SELECT pass, grup, valid FROM usuarios WHERE email = ? LIMIT 1");
            $stmt->bind_param('s', $email);

            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                //If the user exists get variables from result.
                $stmt->bind_result($passwordDB, $grup, $valid);
                $stmt->fetch();
                if ($password == $passwordDB) {
                    //Logged In!!!!
                    $_SESSION['user_login_checked'] = true;
                    $_SESSION['user'] = $email;
                    $_SESSION['grup'] = $grup;                   

                    if ($grup != 0) {
                        header('Location: ../admin/padmin.php');
                    } 
                    else {                       
                        if(!$valid){    
                            $_SESSION['state'] = 12;                        
                        }
                        header('Location: ../index.php');
                    }    
                    exit();
                } else {
                    //Not logged in
                    $_SESSION['user_login_checked'] =  false;
                    $_SESSION['state'] = 3;
                    header("Location: ../index.php");
                }
            } else {
                //Not logged in
                $_SESSION['user_login_checked'] =  false;
                $_SESSION['state'] = 4;
                header('Location: ../index.php');
            }
        } else {
            //Not logged in
            $_SESSION['user_login_checked'] =  false;
            $_SESSION['state'] = 5;
            header('Location: ../index.php');
        }
        break;
        case "logout":
        $_SESSION['user_login_checked'] =  false;
        $adminIntent = (isset($_SESSION['grup']) && $_SESSION['grup'] != 0) ? true : false;
        if ($adminIntent) {
            header('Location: ../admin/padmin.php');
        } else {
            header('Location: ../index.php');
        }    
        break;
        case "validarEmail":
        if (empty($_GET['validationCode']) || empty($_GET['email'])) {
            $_SESSION['state'] = 8;
            header('Location: ../../../index.php');
        } else {
            $code = $_GET['validationCode'];
            $email = $_GET['email'];

            $stmt = $mysqli->prepare("SELECT code, valid, grup FROM usuarios WHERE email = ? LIMIT 1");

            $stmt->bind_param('s', $email);

            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                //If the user exists get variables from result.
                $stmt->bind_result($codeDB, $valid, $grup);
                $stmt->fetch();
                if($valid == 1) {
                    $_SESSION['user_login_checked'] = true;
                    $_SESSION['user'] = $email;
                    $_SESSION['grup'] = $grup;
                    $_SESSION['state'] = 0;
                    header('Location: ../../../index.php');
                } else if ($code == $codeDB) {
                    //codigo correcto!!!!
                    $_SESSION['user_login_checked'] = true;
                    $_SESSION['grup'] = $grup;
                    $_SESSION['user'] = $email;

                    if ($stmt = $mysqli->prepare("UPDATE usuarios set valid = 1 WHERE email = ?")) {
                        $stmt->bind_param('s', $email);
                        if (!$stmt->execute()) {
                            $_SESSION['user_login_checked'] = false;
                            $_SESSION['user'] = "";
                            $_SESSION['state'] = 9;
                            header('Location: ../../../index.php');
                        }

                        $stmt->close();
                        $_SESSION['user_login_checked'] = true;
                        $_SESSION['user'] = $email;
                        $_SESSION['grup'] = $grup;
                        $_SESSION['state'] = 10;
                        header('Location: ../../../index.php');
                    } else {
                        $message = "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
                        $stmt->close();
                        $_SESSION['state'] = 12;
                        $_SESSION['message'] = $message;
                        header('Location: ../../../index.php');
                    }
                } else {
                    //Not logged in
                    $_SESSION['user_login_checked'] =  false;
                    $_SESSION['state'] = 8;
                    header("Location: ../../../index.php");
                }
            } else {
                    //usuario no encontrado
                $_SESSION['user_login_checked'] =  false;
                $_SESSION['state'] = 11;
                header("Location: ../../../index.php");
            }
        }
        break;
        case "olvideMiContrasena":
        $emailUsuario = (isset($_POST['emailUsuario'])) ? $_POST['emailUsuario'] : '';

        $stmt = $mysqli->prepare("SELECT pass FROM usuarios WHERE email = ? LIMIT 1");

        $stmt->bind_param('s', $emailUsuario);

        $stmt->execute();   // Execute the prepared query.
        $stmt->store_result();

        if ($stmt->num_rows == 1) { //usuario encontrado

            //If the user exists get variables from result.
            $stmt->bind_result($pass);
            $stmt->fetch();

            $message = "Recuperar contraseña de TusApuntes.com ----- <br><br>Hola ".$emailUsuario." <br> Según lo solicitado, te enviamos este correo para recordarte tu contraseña.<br>La misma es: <br>".$pass."<br>Esperamos que sigas utilizando nuestro sistema. Muchas gracias. Saludos";

            $sendEmail = enviarMail($message, $emailUsuario);
            if ($sendEmail == true) {
                header("Location: ../olvideMiContrasena.php?status=0");
            } else {
                header("Location: ../olvideMiContrasena.php?status=2");
            }


        } else { //usuario no encontrado
            header("Location: ../olvideMiContrasena.php?status=1");
        }

        break;
    }


    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!$[]';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function enviarMail($message, $email) {

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

            $smtpHost = "mail.tusapuntes.net";  // Dominio alternativo brindado en el email de alta 
            $smtpUsuario = "confirmation@tusapuntes.net";  // Mi cuenta de correo
            $smtpClave = "Aoi12Jjio92";  // Mi contraseña

            // VALORES A MODIFICAR //
            $mail->Host = $smtpHost;
            $mail->Username = $smtpUsuario;
            $mail->Password = $smtpClave;

            $subject = 'Validar Email para TusApuntes.net';
            $toemail = $email;
            $toname = 'Nuevo Usuario'; 

            $mail->SetFrom($smtpUsuario, "tusApuntes.net");
            $mail->AddAddress($toemail, $toname);
            $mail->Subject = $subject;

            $mail->MsgHTML($message);
            return $mail->Send();
        }