<?PHP
        include_once('PHPMailer/src/Exception.php');
        include_once('PHPMailer/src/PHPMailer.php');
        include_once('PHPMailer/src/SMTP.php');

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

        $correo = "SELECT * FROM credenciales_correo";
        $res_correo = $conn->query($correo);
        while($row=mysqli_fetch_array($res_correo)) {
            $host = $row["host"];
            $username = $row["username"];
            $password = $row["password"];
        }

        $usuario = "SELECT * FROM usuario WHERE id_usuario = $id_usuario";
        $res2 = $conn->query($usuario);
        while($row=mysqli_fetch_array($res2)) {
            $nombre = $row["nombre_usuario"];
            $cedula = $row["cedula_usuario"];
            $correo = $row["correo_usuario"];
        }

        $maxpermiso = "SELECT MAX(id_certificado) maximo FROM certificado WHERE id_usuario = $id_usuario";
        $res3 = $conn->query($maxpermiso);
        while($row=mysqli_fetch_array($res3)) {
            $id_permiso = $row["maximo"];
        }
        
        $mail = new PHPMailer(true);
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $host;                                //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
        $mail->Username   = $username;                            //SMTP username
        $mail->Password   = $password;                            //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('talentohumanosemper@gmail.com', 'Talento Humano Semper');
        $mail->addAddress($correo, $nombre);     //Add a recipient
        $mail->addBCC('talentohumanosemper@gmail.com');
        $mail->addBCC('jnoboa@sempersa.com');
        $mail->addBCC('sistemas@sempersa.com');
        //$mail->addBCC('talentohumano@hicontab.com');
        $mail->isHTML(true);                                  //Set email format to HTML

        $html = '
        <div>
        Estimado '.$nombre.', tu solicitud de certificado laboral numero '.$id_permiso.' se encuentra INGRESADA.
        <br>Por favor, no responda. Este es un correo automatico.

        <br><br>
        Departamento de Talento Humano.
        </div>
        ';

        $mail->Subject = 'Nueva solicitud de certificado laboral';
        $mail->Body    = $html;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
?>