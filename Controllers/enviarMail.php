<?php
require_once('../Models/Usuario.php');
require_once('../Config/db.php');

// Importación de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../Models/PHPMailer/src/Exception.php';
require '../Models/PHPMailer/src/PHPMailer.php';
require '../Models/PHPMailer/src/SMTP.php';

function enviarCorreo($accion, $ticket) {
    // Instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'franrd98@gmail.com';
        $mail->Password   = 'twza ufif aivq jtol';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Configuración de los destinatarios
        $mail->setFrom('franrddaw@gmail.com', 'Fran Riera GMAIL'); // Email desde donde se envia
        $mail->addAddress('franrd98@outlook.com', 'Fran Riera Outlook'); // Email del destinatario

        // Configuración del contenido del correo
        $mail->isHTML(true);
        $mail->Subject = "Helplify - Nueva notificación";
        $mail->Body    = "
        <div style='background-color: white'>
        <div style='width:600px; border: solid #eae8e7 2px; border-radius: 8px; padding-top: 20px; padding-bottom:20px; background-color: white; color: #383736'>
            <h1 style='text-align: center'>HELPLIFY</h1>
            <div style='padding: 20px; background-color: #f8f8f8'>
                    <p style='color: #383736'>Hola! se ha <strong>" . $accion . "</strong> un nuevo ticket.</p>

                    <div style='border: solid #eaeaea 1px; border-radius:8px; margin-bottom: 20px; padding: 20px; background-color: white'>
                        <strong>Título:</strong><br>
                        {$ticket['titulo']}<br>

                        <strong>Descripción:</strong><br>
                        {$ticket['descripcion']}<br>

                        <strong>Prioridad:</strong><br>
                        {$ticket['prioridad']}<br>

                        <strong>Fecha Limite:</strong><br>
                        {$ticket['fecha_limite']}<br>
                    </div>

             <a href='http://localhost/DWES/10.%20Bases%20de%20datos/GestorTareas_SQL_PHPMailer_FranRiera/Dashboard/dashboard.php' style='padding: 10px; background-color: #107c41; color: white; border: none; border-radius: 8px; text-decoration: none'>Ir a la tarea</a>
    </div>
        <p style='color: #8d8c8e; text-align: center; margin-left: 20px; margin-right: 20px'>Este mail se trata de una notificación de una tarea agregada al gestor de tareas de Fran. Si estas recibiendo este email, es porque estas registrado en el gestor de tareas de Fran, si se trata de un error, ponte en contacto con nosotros.</p>
  </div>
   </div>
        ";
        $mail->AltBody = "El ticket {$ticket['titulo']} ha sido $accion. Descripción: {$ticket['descripcion']}. Prioridad: {$ticket['prioridad']}. Fecha límite: {$ticket['fecha_limite']}.";

        $mail->send();
        echo 'Correo enviado con éxito';

    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}


?>