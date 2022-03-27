<?php
require_once("../globals.php");
$SMTP_HOST = $GLOBALS['SMTP_HOST'];
$SMTP_USER = $GLOBALS['SMTP_USER'];
$SMTP_PASS = $GLOBALS['SMTP_PASS'];
$SMTP_PORT = $GLOBALS['SMTP_PORT'];
$SMTP_SECURE = $GLOBALS['SMTP_SECURE'];
$SenderName = $GLOBALS['patient_reminder_sender_name'];
$SenderMail = $GLOBALS['patient_reminder_sender_email'];

//Validacion y phpmailer configuración
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['email_data']))
{

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//require 'class/class.phpmailer.php';
$output = '';
foreach($_POST['email_data'] as $row)
{
$mail = new PHPMailer;
$mail->IsSMTP();//Mailer to send message using SMTP
$mail->Host = $SMTP_HOST;//Sets the SMTP hosts of your Email hosting
$mail->Port = $SMTP_PORT;//the default SMTP server port
$mail->SMTPAuth = true;//SMTP authentication. Utilizes the Username and Password variables
$mail->Username = $SMTP_USER;//SMTP username
$mail->Password = $SMTP_PASS;//SMTP password
$mail->SMTPSecure = $SMTP_SECURE;//Connection prefix. Options are "", "ssl" or "tls"
$mail->From = $SenderMail;//the From email address for the message
$mail->FromName = $SenderName;//Sets the From name of the message
$mail->AddAddress($row["email"], $row["name"]); //Adds a "To" address
$mail->WordWrap = 50; //Sets word wrapping on the body of the message to a given number of characters
$mail->IsHTML(true); //Sets message type to HTML
$mail->Subject = 'Recordatorio de Turno'; // Asunto del mensaje
//An HTML or plain text message body
$mail->Body = '
<p>Sr. paciente.</p>
<p>Venga.</p>';

$mail->AltBody = '';
//Enviar un correo electrónico. Devuelve verdadero en caso de éxito o falso en caso de error
$result = $mail->Send();

if($result["code"] == '400')
{
$output .= html_entity_decode($result['full_error']);
}

}
if($output == '')
{
echo 'ok';
}
else
{
echo $output;
}
}

?>
