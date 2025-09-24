<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
//include("../validacion/validacion.php");
session_start();
$conn = conectate();

//CALCULO DE DIA, MES Y AÑO
include("dias_meses_anios.php");
//-------------------

$id_usuario = $_SESSION["id_usuario"];
$fecha = $_GET["fecha"];
$inicio = $_GET["inicio"];
$fin = $_GET["fin"];
$observaciones = $_GET["observaciones"];
$tipo = $_GET["tipo"];

$inicio_completo = $fecha." ".$inicio;
$final_completo = $fecha." ".$fin;

$sql = "INSERT INTO permiso(id_usuario, fecha_solicitud, hora_inicio, hora_fin, observaciones, total_tiempo, id_estado_solicitud, fecha_registro, id_tipo_permiso)
            VALUES($id_usuario, '$fecha', '$inicio_completo', '$final_completo', '$observaciones', TIMESTAMPDIFF(HOUR, '$inicio_completo','$final_completo'), 1, now(), $tipo)";
//echo $sql;
$res = $conn->query($sql);    

    if($res){
        echo '<div class="remark primary">
            La solicitud se guardo con exito.
        </div>';
        include("envia_correo_creacion_permiso.php");
        
    }
    else{
        echo '<div class="remark alert">
            Hubo un problema al guardar.
        </div>';
    }

    //echo $username;

?>