<?php 
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
  
    public function __construct(public $email, public $nombre, public $token)
    {
        
    }

    public function enviarConfirmacion(){

        //creando el objeto
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        //Recipients
        $mail->setFrom('cuentas@appsalon.com', 'AppSalon.com');
        $mail->addAddress('cuentas@appsalon.net', 'Appsalon.com');     //Add a recipient
        $mail->Subject = 'Confirma tu cuenta';
        $mail->CharSet="UTF-8";

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
       
        $contenido='<html>';
        $contenido.="<p><strong>Hola ". $this->email. "</strong> Has creado tu cuenta., da click para confirmar";
        $contenido.="<p><a href='" . $_ENV['APP_URL']. "/confirmar-cuenta?token=". $this->token . "'>Confirmar</a>";
        $contenido.="</html>";
        $mail->Body    = $contenido;
        $mail->send();
    }

    public function recuperarCuenta(){

        //creando el objeto
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        //Recipients
        $mail->setFrom('cuentas@appsalon.com', 'AppSalon.com');
        $mail->addAddress('cuentas@appsalon.net', 'Appsalon.com');     //Add a recipient
        $mail->Subject = 'Recupera tu cuenta';
        $mail->CharSet="UTF-8";

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
       
        $contenido='<html>';
        $contenido.="<p><strong>Hola ". $this->email. "</strong> Solicitaste la recuperación de tu cuenta, por favor da click en el siguiente enlace";
        $contenido.="<p><a href='" . $_ENV['APP_URL']. "/recuperar?token=". $this->token . "'>Confirmar</a>";
        $contenido.="</html>";
        $mail->Body    = $contenido;
        $mail->send();
    }


}


?>