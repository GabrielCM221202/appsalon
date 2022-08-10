<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'ac00915a14666f';
        $mail->Password = '5ccc0c4ca5ad5b';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com' , 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';
        $mail->isHTML(true);
        $contenido = "<html>";
        $contenido.="<p>Hola: <strong>$this->nombre</strong>, 
            Has creado tu cuenta en AppSalon, solo debes confirmarla en el siguiente enlace:</p>";
        $contenido.= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token ."' >Confirma tu cuenta</a></p>";
        $contenido.= "<p>Si tu no solicitaste esta cuenta ignora este mensaje</p> </html>";

        $mail->Body = $contenido;

        $mail->send();
    }

    public function enviarInstrucciones(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'ac00915a14666f';
        $mail->Password = '5ccc0c4ca5ad5b';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com' , 'AppSalon.com');
        $mail->Subject = 'Reestablece tu password';
        $mail->isHTML(true);
        $contenido = "<html>";
        $contenido.="<p>Hola: <strong>$this->nombre</strong>, 
            Has solicitado reestablecer tu password sigue el siguiente enlace para hacerlo:</p>";
        $contenido.= "<p>Presiona aqui: <a href='http://localhost:3000/recuperar?token=" . $this->token ."' >Reestablecer Password</a></p>";
        $contenido.= "<p>Si tu no solicitaste esta cuenta ignora este mensaje</p> </html>";

        $mail->Body = $contenido;

        $mail->send();
    }
}
