<?PHP
header("Content-Type: text/html;charset=utf-8");
//include("../conexion/conexion.php");
//include("../validacion/validacion.php");
//$conn = conectate();

$filtro_tienda = "";

if(strpos($username, "CH") !== false) {
    $filtro_tienda = "AND ALMACEN LIKE 'CH%'";
}
if(strpos($username, "SIE") !== false || strpos($username, "OUTLET") !== false || strpos($username, "POP") !== false) {
    $filtro_tienda = "AND (ALMACEN LIKE '%SIETE%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%ECOMMERCE%' OR ALMACEN LIKE '%OUTLET%'  OR ALMACEN LIKE '%POP%') ";
}
if(strpos($username, "NEW") !== false) {
    $filtro_tienda = "AND ALMACEN LIKE 'NEW%'";
}

    $sql_ventas_anio_menostres="SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE FECHA BETWEEN '".$anio_menostres."-01-01T00:00:00' AND '".$anio_menostres."-".$mes_actual."-".$dia_actual."T23:59:59' $filtro_tienda";
    $res_ventas_anio_menostres=sqlsrv_query($conn,$sql_ventas_anio_menostres);

    while($row=sqlsrv_fetch_array($res_ventas_anio_menostres)) {
        $venta_anio_menostres = number_format($row["VENTA_NETA"],2,',','.'); 
    }

    $sql_ventas_mes_menostres="SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE FECHA BETWEEN '".$anio_menostres."-".$mes_actual."-01T00:00:00' AND '".$anio_menostres."-".$mes_actual."-".$dia_actual."T23:59:59' $filtro_tienda";
    $res_ventas_mes_menostres=sqlsrv_query($conn,$sql_ventas_mes_menostres);

    while($row=sqlsrv_fetch_array($res_ventas_mes_menostres)) {
        $venta_mes_menostres = number_format($row["VENTA_NETA"],2,',','.');
    }

    $sql_ventas_dia_menostres_2="SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE FECHA BETWEEN '".$anio_menostres."-".$mes_actual."-".$dia_actual."T00:00:00' AND '".$anio_menostres."-".$mes_actual."-".$dia_actual."T23:59:59' $filtro_tienda";
    $res_ventas_dia_menostres_2=sqlsrv_query($conn,$sql_ventas_dia_menostres_2);

    while($row=sqlsrv_fetch_array($res_ventas_dia_menostres_2)) {
        $venta_dia_menostres_2 = number_format($row["VENTA_NETA"],2,',','.');
    }

    $sql_ventas_dia_menostres_menostres="SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE FECHA BETWEEN '".$date_future2."T00:00:00' AND '".$date_future2."T23:59:59' $filtro_tienda";
    $res_ventas_dia_menostres_menostres=sqlsrv_query($conn,$sql_ventas_dia_menostres_menostres);

    while($row=sqlsrv_fetch_array($res_ventas_dia_menostres_menostres)) {
        $venta_dia_menostres_menostres = number_format($row["VENTA_NETA"],2,',','.');
    }

    $sql_ventas_xmes_menostres = "SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE DATEPART(YEAR,FECHA) = $anio_menostres $filtro_tienda GROUP BY DATEPART(MONTH,FECHA)";
    $res_ventas_xmes_menostres = sqlsrv_query($conn,$sql_ventas_xmes_menostres);
    while($row=sqlsrv_fetch_array($res_ventas_xmes_menostres)) {
        $ventas_xmes_menostres[] = $row["VENTA_NETA"];
    }

    
?>