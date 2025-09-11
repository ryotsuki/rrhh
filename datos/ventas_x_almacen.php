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

    if($mes == "" && $anio == ""){
        $ventas_x_almacen_dia="SELECT SUM(VTA_NETA) AS VENTA_NETA,SUM(CANTIDAD_VTA) AS UNIDADES,ALMACEN FROM VENTAS WHERE FECHA BETWEEN '".$anio_actual."-".$mes_actual."-".$dia_actual."T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59' $filtro_tienda GROUP BY ALMACEN ORDER BY VENTA_NETA DESC ";
    }
    else{
        $fecha = $anio."-".$mes."-01";
        $dia = date("t", strtotime($fecha));
        $ventas_x_almacen_dia="SELECT SUM(VTA_NETA) AS VENTA_NETA,SUM(CANTIDAD_VTA) AS UNIDADES,ALMACEN FROM VENTAS WHERE FECHA BETWEEN '".$anio."-".$mes."-01T00:00:00' AND '".$anio."-".$mes."-".$dia."T23:59:59' $filtro_tienda GROUP BY ALMACEN ORDER BY VENTA_NETA DESC ";
    }
    //echo $ventas_x_almacen_dia;
    $res_ventas_dia=sqlsrv_query($conn,$ventas_x_almacen_dia);
?>