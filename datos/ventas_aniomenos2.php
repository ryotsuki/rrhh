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
    $filtro_tienda = "AND (ALMACEN LIKE '%SIETE%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%ECOMMERCE%' OR ALMACEN LIKE '%OUTLET%' OR ALMACEN LIKE '%POP%') ";
}
if(strpos($username, "NEW") !== false) {
    $filtro_tienda = "AND ALMACEN LIKE 'NEW%'";
}

    $sql_ventas_anio_menosdos="SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE FECHA BETWEEN '".$anio_menosdos."-01-01T00:00:00' AND '".$anio_menosdos."-".$mes_actual."-".$dia_actual."T23:59:59' $filtro_tienda";
    $res_ventas_anio_menosdos=sqlsrv_query($conn,$sql_ventas_anio_menosdos);

    while($row=sqlsrv_fetch_array($res_ventas_anio_menosdos)) {
        $venta_anio_menosdos = number_format($row["VENTA_NETA"],2,',','.'); 
    }

    $sql_ventas_mes_menosdos="SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE FECHA BETWEEN '".$anio_menosdos."-".$mes_actual."-01T00:00:00' AND '".$anio_menosdos."-".$mes_actual."-".$dia_actual."T23:59:59' $filtro_tienda";
    $res_ventas_mes_menosdos=sqlsrv_query($conn,$sql_ventas_mes_menosdos);

    while($row=sqlsrv_fetch_array($res_ventas_mes_menosdos)) {
        $venta_mes_menosdos = number_format($row["VENTA_NETA"],2,',','.');
    }

    $sql_ventas_dia_menosdos_2="SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE FECHA BETWEEN '".$anio_menosdos."-".$mes_actual."-".$dia_actual."T00:00:00' AND '".$anio_menosdos."-".$mes_actual."-".$dia_actual."T23:59:59' $filtro_tienda";
    $res_ventas_dia_menosdos_2=sqlsrv_query($conn,$sql_ventas_dia_menosdos_2);

    while($row=sqlsrv_fetch_array($res_ventas_dia_menosdos_2)) {
        $venta_dia_menosdos_2 = number_format($row["VENTA_NETA"],2,',','.');
    }

    $sql_ventas_dia_menosdos_menosdos="SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE FECHA BETWEEN '".$date_future2."T00:00:00' AND '".$date_future2."T23:59:59' $filtro_tienda";
    $res_ventas_dia_menosdos_menosdos=sqlsrv_query($conn,$sql_ventas_dia_menosdos_menosdos);

    while($row=sqlsrv_fetch_array($res_ventas_dia_menosdos_menosdos)) {
        $venta_dia_menosdos_menosdos = number_format($row["VENTA_NETA"],2,',','.');
    }

    $sql_ventas_xmes_menosdos = "SELECT SUM(VTA_NETA) AS VENTA_NETA FROM VENTAS WHERE DATEPART(YEAR,FECHA) = $anio_menosdos $filtro_tienda GROUP BY DATEPART(MONTH,FECHA)";
    $res_ventas_xmes_menosdos = sqlsrv_query($conn,$sql_ventas_xmes_menosdos);
    while($row=sqlsrv_fetch_array($res_ventas_xmes_menosdos)) {
        $ventas_xmes_menosdos[] = $row["VENTA_NETA"];
    }
    
?>