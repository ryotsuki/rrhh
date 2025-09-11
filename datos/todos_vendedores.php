<?php

$filtro_tienda = "AND ALMACEN NOT LIKE '%MAYORISTA%' AND ALMACEN NOT LIKE '%ECOMMERCE%'"; 

    if(strpos($username, "CH") !== false) {
        $filtro_tienda = "AND ALMACEN LIKE 'CH%'";
    }
    if(strpos($username, "SIE") !== false || strpos($username, "OUTLET") !== false || strpos($username, "POP") !== false) {
        $filtro_tienda = "AND (ALMACEN LIKE '%SIETE%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%POP%' OR ALMACEN LIKE '%OUTLET%') ";
    }
    if(strpos($username, "NEW") !== false) {
        $filtro_tienda = "AND ALMACEN LIKE 'NEW%'";
    }

    if($mes == "" && $anio == ""){
        $todos_vendedores="SELECT SUM(VTA_NETA) AS VENTA_NETA,VENDEDOR FROM VENTAS WHERE FECHA BETWEEN '".$anio_actual."-".$mes_actual."-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59' AND VENDEDOR IS NOT NULL $filtro_tienda GROUP BY VENDEDOR ORDER BY VENTA_NETA DESC ";
    }
    else{
        $fecha = $anio."-".$mes."-01";
        $dia = date("t", strtotime($fecha));
        $todos_vendedores="SELECT SUM(VTA_NETA) AS VENTA_NETA,VENDEDOR FROM VENTAS WHERE FECHA BETWEEN '".$anio."-".$mes."-01T00:00:00' AND '".$anio."-".$mes."-".$dia."T23:59:59' AND VENDEDOR IS NOT NULL $filtro_tienda GROUP BY VENDEDOR ORDER BY VENTA_NETA DESC ";
    }
    $res_todos_vendedores=sqlsrv_query($conn,$todos_vendedores);
    //echo $todos_vendedores;
?>