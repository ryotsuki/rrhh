<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
include_once('PHPMailer/src/Exception.php');
include_once('PHPMailer/src/PHPMailer.php');
include_once('PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//include("../validacion/validacion.php");
session_start();
$conn = conectate();

//CALCULO DE DIA, MES Y AÑO
include("dias_meses_anios.php");
//-------------------

$id_usuario = $_SESSION["id_usuario"];
$fecha = $_GET["fecha"];
$motivo = $_GET["motivo"];


$sql = "INSERT INTO certificado(id_usuario, fecha_registro, motivo_certificado, id_estado_solicitud)
            VALUES($id_usuario, '$fecha', '$motivo', 1)";
//echo $sql;
    $res = $conn->query($sql);

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
    

    if($res){
        echo '<div class="remark primary">
            La solicitud se guardo con exito.
        </div>';

        $mail = new PHPMailer(true);
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'talentohumanosemper@gmail.com';                     //SMTP username
        $mail->Password   = 'llsn ysoh hwfq nnbo';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('talentohumanosemper@gmail.com', 'Talento Humano Semper');
        $mail->addAddress($correo, $nombre);     //Add a recipient
        $mail->addBCC('talentohumanosemper@gmail.com');
        $mail->addBCC('joboa@sempersa.com');
        //$mail->addBCC('talentohumano@hicontab.com');
        $mail->isHTML(true);                                  //Set email format to HTML

        $html = '
        <div>
        Estimado '.$nombre.', tu solicitud de certificiado numero '.$id_permiso.' se encuentra INGRESADA.
        <br>Por favor, no responda. Este es un correo automatico.

        <br><br>
        Departamento de Talento Humano.
        </div>
        ';

        $mail->Subject = 'Nueva solicitud de certificado laboral';
        $mail->Body    = $html;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
    }
    else{
        echo '<div class="remark alert">
            Hubo un problema al guardar.
        </div>';
    }

    //echo $username;

?>