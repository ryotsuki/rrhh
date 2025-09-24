<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
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
    

    if($res){
        echo '<div class="remark primary">
            La solicitud se guardo con exito.
        </div>';
        include("envia_correo_creacion_solicitud.php");
    }
    else{
        echo '<div class="remark alert">
            Hubo un problema al guardar.
        </div>';
    }

    //echo $username;

?>