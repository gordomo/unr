<?php

require_once('phpmailer/class.phpmailer.php');

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Port = 587;
$mail->IsHTML(true);
$mail->CharSet = "utf-8";

// Datos de la cuenta de correo utilizada para enviar vía SMTP
$smtpHost = "tusapuntes.net";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "confirmation@tusapuntes.net";  // Mi cuenta de correo
$smtpClave = "Aoi12Jjio92";  // Mi contraseña

// VALORES A MODIFICAR //
$mail->Host = $smtpHost;
$mail->Username = $smtpUsuario;
$mail->Password = $smtpClave;

if (isset($_POST['submit']) and strtolower($_POST['submit']) == 'submit') {
    if ($_POST['template-contactform-name'] != '' and $_POST['template-contactform-email'] != '' and $_POST['template-contactform-message'] != '') {
        $name = $_POST['template-contactform-name'];
        $email = $_POST['template-contactform-email'];
        $phone = $_POST['template-contactform-phone'];
        $message = $_POST['template-contactform-message'];

        $subject = isset($subject) ? $subject : 'New Message From Contact Form';

        $toemail = 'info@muchasiesta.com.ar'; // Your Email Address
        $toname = 'Contacto desde la Web'; // Your Name

        $mail->SetFrom($email, $name);
        $mail->AddReplyTo($email, $name);
        $mail->AddAddress($toemail, $toname);
        $mail->Subject = 'Contacto desde la Web';

        $name = isset($name) ? "Nombre: $name<br><br>" : '';
        $email = isset($email) ? "Email: $email<br><br>" : '';
        $phone = isset($phone) ? "Telefono: $phone<br><br>" : '';
        $message = isset($message) ? "Mensaje: $message<br><br>" : '';

        $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>Mensaje enviado desde: ' . $_SERVER['HTTP_REFERER'] : '';

        $body = "$name $email $phone $message $referrer";

        $mail->MsgHTML($body);
        $sendEmail = $mail->Send();

        if ($sendEmail == true) {
            echo 'Hemos recibido su mensaje <strong>correctamente</strong> le responderemos lo más pronto posible.';
        } else {
            echo 'El mensaje <strong>no</strong> pudo ser enviado. Por favor, intente de nuevo más tarde.<br /><br /><strong>Reason:</strong><br />' . $mail->ErrorInfo . '';
        }
    } else {
        echo 'Por favor <strong>complete todos los campos</strong> e intente de nuevo.';
    }
} else {
    echo 'A ocurrido un <strong>error inesperado</strong> Intente más tarde por favor.';
}

?>