<?php
require_once('../../Config/db.php');

// Importación de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../Models/PHPMailer/src/Exception.php';
require '../../Models/PHPMailer/src/PHPMailer.php';
require '../../Models/PHPMailer/src/SMTP.php';

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
        $mail->CharSet = 'UTF-8';

        // Configuración de los destinatarios
        $mail->setFrom('info@helplify.com', 'Helplify'); // Email desde donde se envia
        $mail->addAddress($ticket['email'], $ticket['usuario']); // Email del destinatario

        // Configuración del contenido del correo
        $mail->isHTML(true);
        $mail->Subject = "Helplify - Nueva notificación";

        if($accion == 'nuevaRespuesta') {
            $mail->Body    = "
            <div style='background-color: white'>
            <div style='width:600px; border: solid #eae8e7 2px; border-radius: 8px; padding-top: 20px; padding-bottom:20px; background-color: white; color: #383736'>
                <h1 style='text-align: center'>HELPLIFY</h1>
                <div style='padding: 20px; background-color: #f8f8f8'>
                    <p style='color: #383736'>Hola! alguien ha dejado un comentario en uno de los tickets.</p>
    
                        <div style='border: solid #eaeaea 1px; border-radius:8px; margin-bottom: 20px; padding: 20px; background-color: white'>
                            <strong>#Ticket:</strong><br>
                            {$ticket['idticket']}<br>

                            <strong>#Usuario:</strong><br>
                            {$ticket['usuario']}<br>
                        
                            <strong>Mensaje:</strong><br>
                            {$ticket['mensaje']}<br>
    
                            <strong>Hora:</strong><br>
                            {$ticket['created_at']}<br>
                        </div>
    
                 <a href='http://localhost/DWES/Helplify' style='padding: 10px; background-color: #107c41; color: white; border: none; border-radius: 8px; text-decoration: none'>Ir al ticket</a>
        </div>
            <p style='color: #8d8c8e; text-align: center; margin-left: 20px; margin-right: 20px'>Este mail se trata de una notificación de un ticket creado en la herramienta de ticketing 'Helplify' de Fran. Si estas recibiendo este email, es porque estas registrado en la herramienta, si se trata de un error, ponte en contacto con nosotros.</p>
      </div>
       </div>
            "; 
        }
        else if($accion == 'modificado') {
            $mail->Body    = "
            <div style='background-color: white'>
            <div style='width:600px; border: solid #eae8e7 2px; border-radius: 8px; padding-top: 20px; padding-bottom:20px; background-color: white; color: #383736'>
                <h1 style='text-align: center'>HELPLIFY</h1>
                <div style='padding: 20px; background-color: #f8f8f8'>
                        <p style='color: #383736'>Hola! alguien ha modificado un ticket.</p>
    
                        <div style='border: solid #eaeaea 1px; border-radius:8px; margin-bottom: 20px; padding: 20px; background-color: white'>
                            <strong>#Ticket:</strong><br>
                            {$ticket['id']}<br>
                        
                            <strong>Ticket:</strong><br>
                            {$ticket['titulo']}<br>
    
                            <strong>Descripción:</strong><br>
                            {$ticket['descripcion']}<br>
    
                            <strong>Estado:</strong><br>
                            {$ticket['estado']}<br>
    
                            <strong>Prioridad:</strong><br>
                            {$ticket['prioridad']}<br>
    
                            <strong>Asignado a:</strong><br>
                            {$ticket['usuario']}<br>
    
                            <strong>Categoria:</strong><br>
                            {$ticket['categoria']}<br>
    
                            <strong>Hora:</strong><br>
                            {$ticket['created_at']}<br>
                        </div>
    
                 <a href='http://localhost/DWES/Helplify' style='padding: 10px; background-color: #107c41; color: white; border: none; border-radius: 8px; text-decoration: none'>Ir al ticket</a>
        </div>
            <p style='color: #8d8c8e; text-align: center; margin-left: 20px; margin-right: 20px'>Este mail se trata de una notificación de un ticket creado en la herramienta de ticketing 'Helplify' de Fran. Si estas recibiendo este email, es porque estas registrado en la herramienta, si se trata de un error, ponte en contacto con nosotros.</p>
      </div>
       </div>
            ";
        }
        
        else {
                $mail->Body    = "
        <div style='background-color: white'>
        <div style='width:600px; border: solid #eae8e7 2px; border-radius: 8px; padding-top: 20px; padding-bottom:20px; background-color: white; color: #383736'>
            <h1 style='text-align: center'>HELPLIFY</h1>
            <div style='padding: 20px; background-color: #f8f8f8'>
                    <p style='color: #383736'>Hola! alguien ha creado un ticket.</p>

                    <div style='border: solid #eaeaea 1px; border-radius:8px; margin-bottom: 20px; padding: 20px; background-color: white'>
                        <strong>#Ticket:</strong><br>
                        {$ticket['id']}<br>
                    
                        <strong>Ticket:</strong><br>
                        {$ticket['titulo']}<br>

                        <strong>Descripción:</strong><br>
                        {$ticket['descripcion']}<br>

                        <strong>Estado:</strong><br>
                        {$ticket['estado']}<br>

                        <strong>Prioridad:</strong><br>
                        {$ticket['prioridad']}<br>

                        <strong>Asignado a:</strong><br>
                        {$ticket['usuario']}<br>

                        <strong>Categoria:</strong><br>
                        {$ticket['categoria']}<br>

                        <strong>Hora:</strong><br>
                        {$ticket['created_at']}<br>
                    </div>

             <a href='http://localhost/DWES/Helplify' style='padding: 10px; background-color: #107c41; color: white; border: none; border-radius: 8px; text-decoration: none'>Ir al ticket</a>
    </div>
        <p style='color: #8d8c8e; text-align: center; margin-left: 20px; margin-right: 20px'>Este mail se trata de una notificación de un ticket creado en la herramienta de ticketing 'Helplify' de Fran. Si estas recibiendo este email, es porque estas registrado en la herramienta, si se trata de un error, ponte en contacto con nosotros.</p>
  </div>
   </div>
        ";
            }
        
        
        $mail->AltBody = "El ticket {$ticket['titulo']} ha sido $accion. Descripción: {$ticket['descripcion']}. Prioridad: {$ticket['prioridad']}. Estado: {$ticket['estado']}.";
        $mail->send();
        var_dump($ticket);

        echo 'Correo enviado con éxito';

    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}


?>