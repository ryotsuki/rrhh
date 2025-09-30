<?PHP

header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
//include("../validacion/validacion.php");
session_start();
$conn = conectate();

$id_usuario			= $_POST['id_usuario'];
$id_certificado			= $_POST['id_certificado'];
$id_estado          = $_POST['id_estado'];
$solicitud          = "";
$texto              = "";

if($id_estado==2){
    $solicitud = "EN REVISION";
}
if($id_estado==3){
    $solicitud = "APROBADA";
    $texto = "Por favor, ingrese a http://m1.sempersa.com:8080/rrhh/login para descargar su certificado.";
}
if($id_estado==4){
    $solicitud = "DENEGADA";
}

$query = "UPDATE certificado SET id_usuario_aprobador = $id_usuario, fecha_cambio_estado = now(), id_estado_solicitud = $id_estado WHERE id_certificado = $id_certificado";
$res = $conn->query($query);

//echo $query;
//echo $id_permiso;


if ($res){
    echo '1/1';
    include("envia_correo_certificado.php");
    echo '1/1';
	
}else{
	echo 'No se han podido registrar el cambio!/0';
}


?>