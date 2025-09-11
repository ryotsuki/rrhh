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

    $sql_uno="SELECT count(distinct numero_documento),vendedor,almacen from v_ventas_bono where fecha between '".$an."-".$me."-".$di."T00:00:00' and GETDATE() $filtro_tienda group by vendedor,almacen order by almacen, vendedor";
    $res_bono=sqlsrv_query($conn,$sql_uno);
    //echo $sql_uno;

    // while($row=sqlsrv_fetch_array($res_uno)) {
    //     $almacen = $row["almacen"];
    //     $vendedor = $row["vendedor"];
    //     $una_unidad = $row["una_unidad"];
    // }

    // $sql_dos="SELECT count(numero_documento) as dos_unidades,vendedor,almacen from v_ventas_por_vendedor_unidades where unidades_vendidas = 2 group by vendedor,almacen order by almacen, vendedor";
    // $res_dos=sqlsrv_query($conn,$sql_dos);
    // //echo $sql_ventas_anio_actual;

    // // while($row=sqlsrv_fetch_array($res_dos)) {
    // //     $dos_unidades = $row["dos_unidades"];
    // // }

    // $sql_dos="SELECT count(numero_documento) as dos_unidades,vendedor,almacen from v_ventas_por_vendedor_unidades where unidades_vendidas = 2 group by vendedor,almacen order by almacen, vendedor";
    // $res_dos=sqlsrv_query($conn,$sql_dos);
    // //echo $sql_ventas_anio_actual;

    // // while($row=sqlsrv_fetch_array($res_dos)) {
    // //     $dos_unidades = $row["dos_unidades"];
    // // }

    // $sql_tres="SELECT count(numero_documento) as tres_unidades,vendedor,almacen from v_ventas_por_vendedor_unidades where unidades_vendidas = 3 group by vendedor,almacen order by almacen, vendedor";
    // $res_tres=sqlsrv_query($conn,$sql_tres);
    // //echo $sql_ventas_anio_actual;

    // // while($row=sqlsrv_fetch_array($res_tres)) {
    // //     $tres_unidades = $row["tres_unidades"];
    // // }

    // $sql_mas="SELECT count(numero_documento) as mas_unidades,vendedor,almacen from v_ventas_por_vendedor_unidades where unidades_vendidas > 3 group by vendedor,almacen order by almacen, vendedor";
    // $res_mas=sqlsrv_query($conn,$sql_mas);
    // //echo $sql_ventas_anio_actual;

    // while($row=sqlsrv_fetch_array($res_tres)) {
    //     $mas_unidades = $row["mas_unidades"];
    // }

?>