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

$id_usuario			= $_POST['id_usuario'];
$id_permiso			= $_POST['id_permiso'];
$id_estado          = $_POST['id_estado'];
$solicitud          = "";

if($id_estado==2){
    $solicitud = "EN REVISION";
}
if($id_estado==3){
    $solicitud = "APROBADA";
}
if($id_estado==4){
    $solicitud = "DENEGADA";
}

$query = "UPDATE permiso SET id_usuario_aprobador = $id_usuario, fecha_cambio_estado = now(), id_estado_solicitud = $id_estado WHERE id_permiso = $id_permiso";
$res = $conn->query($query);

//echo $query;
//echo $id_permiso;

$usuario = "SELECT * FROM usuario WHERE id_usuario = (SELECT id_usuario FROM permiso WHERE id_permiso = $id_permiso)";
$res2 = $conn->query($usuario);
while($row=mysqli_fetch_array($res2)) {
    $nombre = $row["nombre_usuario"];
    $cedula = $row["cedula_usuario"];
    $correo = $row["correo_usuario"];
}


if ($res){
    echo '1/1';
    $mail = new PHPMailer(true);
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'talentohumanosemper@gmail.com';                     //SMTP username
    $mail->Password   = 'gzrj egxo ocov urwd';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('talentohumanosemper@gmail.com', 'Talento Humano Semper');
    $mail->addAddress($correo, $nombre);     //Add a recipient
    $mail->addBCC('sistemas@sempersa.com');
    $mail->addBCC('talentohumano@hicontab.com');
    $mail->isHTML(true);                                  //Set email format to HTML

    $html = '
    <div>
    Estimado '.$nombre.', tu solicitud de permiso numero '.$id_permiso.' se encuentra '.$solicitud.'
    <br>Por favor, no responda. Este es un correo automatico.

    <br><br>
    Departamento de Talento Humano.
    </div>
    ';

    $mail->Subject = 'Solicitud de permiso actualizada';
    $mail->Body    = $html;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo '1/1';
	
}else{
	echo 'No se han podido registrar el cambio!/0';
}


?>