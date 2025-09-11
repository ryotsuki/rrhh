<?PHP
header("Content-Type: text/html;charset=utf-8");
//include("../conexion/conexion.php");
//include("../validacion/validacion.php");
//$conn = conectate();
//echo $username;

$filtro_tienda = ""; 

if(strpos($username, "CH") !== false) {
    $filtro_tienda = "AND ALMACEN LIKE 'CH%'";
}
if(strpos($username, "SIE") !== false || strpos($username, "OUTLET") !== false || strpos($username, "POP") !== false) {
    $filtro_tienda = "AND (ALMACEN LIKE '%SIETE%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%ECOMMERCE%' OR ALMACEN LIKE '%OUTLET%' OR ALMACEN LIKE '%POP%') ";
}
if(strpos($username, "NEW") !== false) {
    $filtro_tienda = "AND ALMACEN LIKE 'NEW%'";
}

    $sql_ventas_anio_actual="SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE FECHA BETWEEN '".$anio_actual."-01-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59' $filtro_tienda";
    $res_ventas_anio_actual=sqlsrv_query($conn,$sql_ventas_anio_actual);
    //echo $sql_ventas_anio_actual;

    while($row=sqlsrv_fetch_array($res_ventas_anio_actual)) {
        $venta_anio_actual = number_format($row["VENTA_NETA"],2,',','.');
    }

    $sql_ventas_mes_actual="SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE FECHA BETWEEN '".$anio_actual."-".$mes_actual."-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59' $filtro_tienda";
    $res_ventas_mes_actual=sqlsrv_query($conn,$sql_ventas_mes_actual);

    while($row=sqlsrv_fetch_array($res_ventas_mes_actual)) {
        $venta_mes_actual = number_format($row["VENTA_NETA"],2,',','.');
    }

    $sql_ventas_dia_actual="SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE FECHA BETWEEN '".$anio_actual."-".$mes_actual."-".$dia_actual."T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59' $filtro_tienda";
    $res_ventas_dia_actual=sqlsrv_query($conn,$sql_ventas_dia_actual);

    while($row=sqlsrv_fetch_array($res_ventas_dia_actual)) {
        $venta_dia_actual = number_format($row["VENTA_NETA"],2,',','.');
    }

    $sql_ventas_dia_anterior="SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE FECHA BETWEEN '".$date_future."T00:00:00' AND '".$date_future."T23:59:59' $filtro_tienda";
    //echo $sql_ventas_dia_anterior;
    $res_ventas_dia_anterior=sqlsrv_query($conn,$sql_ventas_dia_anterior);

    while($row=sqlsrv_fetch_array($res_ventas_dia_anterior)) {
        $venta_dia_anterior = number_format($row["VENTA_NETA"],2,',','.');
    }

    $sql_ventas_xmes_actual = "SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE DATEPART(YEAR,FECHA) = $anio_actual $filtro_tienda GROUP BY DATEPART(MONTH,FECHA)";
    $res_ventas_xmes_actual = sqlsrv_query($conn,$sql_ventas_xmes_actual);
    while($row=sqlsrv_fetch_array($res_ventas_xmes_actual)) {
        $ventas_xmes_actual[] = $row["VENTA_NETA"];
    }
?>