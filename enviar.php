<?php
//Validacion y phpmailer configuración

if(isset($_POST['email_data']))
{
require 'class/class.phpmailer.php';
$output = '';
foreach($_POST['email_data'] as $row)
{
$mail = new PHPMailer;
$mail->IsSMTP();//Mailer to send message using SMTP
$mail->Host = 'smtp.fibertel.com.ar';//Sets the SMTP hosts of your Email hosting
$mail->Port = '25';//the default SMTP server port
$mail->SMTPAuth = true;//SMTP authentication. Utilizes the Username and Password variables
$mail->Username = 'miyel@fibertel.com.ar';//SMTP username
$mail->Password = '43miyel21';//SMTP password
$mail->SMTPSecure = '';//Connection prefix. Options are "", "ssl" or "tls"
$mail->From = 'info@origen.com.ar';//the From email address for the message
$mail->FromName = 'Clinica SCC';//Sets the From name of the message
$mail->AddAddress($row["email"], $row["name"]); //Adds a "To" address
$mail->WordWrap = 50; //Sets word wrapping on the body of the message to a given number of characters
$mail->IsHTML(true); //Sets message type to HTML
$mail->Subject = 'LRecordatorio de Turno'; // Asunto del mensaje
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
