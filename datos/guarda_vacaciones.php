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


$sql = "INSERT INTO vacacion(id_usuario, fecha_solicitud, fecha_inicio, fecha_fin, observaciones, cantidad_dias, id_estado_solicitud, fecha_registro)
            VALUES($id_usuario, '$fecha', '$inicio', '$fin', '$observaciones', DATEDIFF('$fin','$inicio'), 1, now())";
//echo $sql;
    $res = $conn->query($sql);
    

    if($res){
        echo '<div class="remark primary">
            La solicitud se guardo con exito.
        </div>';
    }
    else{
        echo '<div class="remark alert">
            Hubo un problema al guardar.
        </div>';
    }

    //echo $username;

?>