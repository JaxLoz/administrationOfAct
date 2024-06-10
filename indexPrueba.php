<?php
require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'adactsup@gmail.com';
    $mail->Password = "6'{5PI9|ZXi%_rZS\}m1{]NpW5aiH@";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Destinatarios
    $mail->setFrom('adactsup@gmail.com', 'Remitente');
    $mail->addAddress('jaxloz2002@gmail.com', 'Destinatario');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'prueba';

    // Contenido HTML personalizado
    $contenidoHTML = '
        <html>
        <head>
            <title>Correo electrónico HTML</title>
        </head>
        <body>
            <h1>¡Hola!</h1>
            <p>Este es un correo electrónico con contenido HTML personalizado.</p>
            <p>Puedes incluir imágenes, estilos CSS, tablas, enlaces y cualquier otro elemento HTML.</p>
        </body>
        </html>
    ';

    $mail->Body = $contenidoHTML;
    $mail->AltBody = 'Este es un correo electrónico con contenido HTML. Si no puedes verlo, asegúrate de habilitar la visualización de HTML.';

    $mail->send();
    echo 'Correo enviado correctamente';
} catch (Exception $e) {
    echo 'Error al enviar el correo: ', $mail->ErrorInfo;
}
