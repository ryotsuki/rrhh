<?PHP
include_once('PHPMailer/src/Exception.php');
include_once('PHPMailer/src/PHPMailer.php');
include_once('PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
//include("../validacion/validacion.php");
$conn = conectate2();
$conn2 = conectate();


    //echo $sql; 
    //$consulta_descripcion 



$sql = "SELECT * FROM CH_CUPONES_JUEGO WHERE correo_enviado = 0 AND (correo_cliente IS NOT NULL AND correo_cliente <> '') ";
$res=sqlsrv_query($conn,$sql);	
?>


    <?php 
        while($row=sqlsrv_fetch_array($res)) {
            $correo = $row["correo_cliente"];
            $nombre = $row["nombre_cliente"];
            $codigo = $row["numero_cupon"];

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                //$config['protocol'] = "mail";
                //$config['smtp_port'] = 587;
                //$mail->protocol = "mail";
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                //$mail->Host       = 'priva30.privatednsorg.com';
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                //$mail->Username   = 'info@chevignon.ec';                     //SMTP username
                //$mail->Password   = 'Novomode2023'; 
                $mail->Username   = 'digital@novomode.ec';                     //SMTP username
                $mail->Password   = 'Novomode2023';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
                //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('digital@novomode.ec', 'Chevignon');
                $mail->addAddress($correo, $nombre);     //Add a recipient
                //$mail->addAddress('ellen@example.com');               //Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('nightmare178@gmail.com');
                //$mail->addBCC('mercadeo@novomode.ec');
                $mail->addBCC('programacion@novomode.ec');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML

                $html = '
                <div style="background-image: url(https://novomodecol.vtexassets.com/assets/vtex.file-manager-graphql/images/9c72ada9-3e9c-4d70-a0e7-65b8a4a3d713___9832bd8d37d2a5052fc1cefc8ae12756.jpg);
                background-size: cover;background-size: 100% 100%;width:100%;
                background-repeat: no-repeat; text-align:center;color:black; font-family:Ciutadella Bold;">
                    <br><br><br><br><br><br><br>
                                
                    <font style="color:black;">Compite por un viaje a la carrera de automovilismo más prestigiosa de la historia
                    <font style="color:black;">Compite por un viaje a la carrera de automovilismo más prestigiosa de la historia
                    <br><br>CÓDIGO DE JUEGO: 
                    <br><br><strong>'.$codigo.'</strong>
                    <br><br>Ingresa tu código de juego entrando a este link:
                    <br><a href="https://www.chevignon.com.ec/chevignonracing"><img src="https://novomodecol.vtexassets.com/assets/vtex.file-manager-graphql/images/36562c63-ea92-40b1-bd8b-6c54f52a9db9___1eff589284f0de77e7245b2f3b975ece.jpg" width="120" height="39"></a>

                    <br><br>VÁLIDO DEL 24 DE JULIO AL 4 DE OCTUBRE DEL 2023
                    <br>Aplica en tiendas físicas Chevignon en todo el país, WhatsApp y tienda online.

                    <br><br>Por compras entre $50 USD Y $99 USD recibes un código con 1 OPORTUNIDAD DE JUEGO en el video game Chevignon Racing.

                    <br><br>Por compras entre $100 USD Y $249 USD recibes un código con 5 OPORTUNIDADES DE JUEGO en el video game Chevignon Racing.

                    <br><br>Por compras iguales o superiores a $250USD recibes un código con 15 OPORTUNIDADES DE JUEGO en el video game Chevignon Racing.


                    <br><br>¡Registra tus códigos y juega!

                    <br><br>EL 5 DE OCTUBRE PREMIAREMOS EL RANKING CON LOS 10 MEJORES TIEMPOS
                    <br>GANA UNA EXPERIENCIA

                    <br><br>Ubícate en el ranking de los 10 mejores pilotos del video game CHEVIGNON RACING y gana:

                    <br><br>Tiquetes aéreos a Ciudad de México
                    <br>5 días de hospedaje en Ciudad de México
                    <br>3 días en la SUITE Chevignon Racing
                    <br>Kit de bienvenida Chevignon Racing
                    <br>Free Access food & drinks en la SUITE Chevignon Racing
                    <br>3 looks Chevignon</font>

                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                </div>
                ';

                $mail->Subject = 'Chevignon Racing';
                $mail->Body    = $html;
                

                // $mail->Body    = '<div style="background-image: url(https://novomodecol.vtexassets.com/assets/vtex.file-manager-graphql/images/ff852799-d545-468a-93f8-7daa99b888e5___eea7b6371a34c2f532214b557bc08119.jpg);
                //                 background-size: cover;background-size: 100% 100%;width:50%;
                //                 background-repeat: no-repeat; text-align:center;color:black; font-family:Ciutadella Bold;">
                //                 <br><br><br><br><br>
                                
                //                 </div>';

                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                echo 'Message has been sent';

                $sql4 = "UPDATE CH_CUPONES_JUEGO SET correo_enviado = 1 WHERE numero_cupon = '$codigo'";
                $res4=sqlsrv_query($conn,$sql4);
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }
    ?>
