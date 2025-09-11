<?PHP
header("Content-Type: text/html;charset=utf-8");
//include("../conexion/conexion.php");
//include("../validacion/validacion.php");
//$conn = conectate();
//echo $username;
$correo_usuario = $_SESSION['user_email_address'];

$an = date("Y");
$me = date("m");
$di = date("d");

$filtro_tienda = ""; 

if(strpos($username, "CH") !== false) {
    $filtro_tienda = "AND ALMACEN = '$username'";
}
if(strpos($username, "SIE") !== false || strpos($username, "SUR") !== false) {
    $filtro_tienda = "AND ALMACEN = '$username'";
}
if(strpos($username, "NEW") !== false) {
    $filtro_tienda = "AND ALMACEN LIKE 'NEW%'";
}
 
    $sql_general="SELECT count(distinct numero_documento),vendedor,almacen from v_ventas_por_vendedor_porcentaje where fecha between '".$an."-".$me."-".$di."T00:00:00' and GETDATE() $filtro_tienda group by vendedor,almacen order by almacen, vendedor";
    $res_general=sqlsrv_query($conn,$sql_general);
    //echo $sql_uno;

?>