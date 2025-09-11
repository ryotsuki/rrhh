<?php
    //include("../conexion/conexion.php");
    
    $filtro_tienda = ""; 

    if(strpos($username, "CH") !== false) {
        $filtro_tienda = "AND ALMACEN LIKE 'CH%'";
    }
    if(strpos($username, "SIE") !== false) {
        $filtro_tienda = "AND (ALMACEN LIKE '%SIETE%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%ECOMMERCE%' OR ALMACEN LIKE '%OUTLET%') ";
    }
    if(strpos($username, "NEW") !== false) {
        $filtro_tienda = "AND ALMACEN LIKE 'NEW%'";
    }

    if($mes == "" && $anio == ""){
        $consulta_porcentajes="SELECT
                                    m.monto_meta,
                                    SUM(v.VTA_NETA) AS venta_neta,
                                    v.ALMACEN
                                FROM
                                    metas m,
                                    ventas v
                                WHERE
                                    m.local_meta = v.ALMACEN AND
                                    (m.anio_meta = $anio_actual AND DATEPART(YEAR,v.FECHA) = $anio_actual) AND
                                    (m.mes_meta = $mes_actual AND DATEPART(MONTH,v.FECHA) = $mes_actual)
                                    $filtro_tienda
                                GROUP BY
                                    m.monto_meta, v.ALMACEN
                                ORDER BY
                                    v.ALMACEN";
    }
    else{
        $consulta_porcentajes="SELECT
                                    m.monto_meta,
                                    SUM(v.VTA_NETA) AS venta_neta,
                                    v.ALMACEN
                                FROM
                                    metas m,
                                    ventas v
                                WHERE
                                    m.local_meta = v.ALMACEN AND
                                    (m.anio_meta = $anio_actual AND DATEPART(YEAR,v.FECHA) = $anio) AND
                                    (m.mes_meta = $mes AND DATEPART(MONTH,v.FECHA) = $mes)
                                    $filtro_tienda
                                GROUP BY
                                    m.monto_meta, v.ALMACEN
                                ORDER BY
                                    v.ALMACEN";
    }
    $res_consulta_porcentajes=sqlsrv_query($conn,$consulta_porcentajes);

?>