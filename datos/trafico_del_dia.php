<?PHP
    header("Content-Type: text/html;charset=utf-8");

    $filtro_tienda = ""; 

    if(strpos($username, "CH") !== false) {
        $filtro_tienda = "AND tienda LIKE 'CH%'";
    }
    if(strpos($username, "SIE") !== false || strpos($username, "OUTLET") !== false || strpos($username, "POP") !== false) {
        $filtro_tienda = "AND (tienda LIKE 'S%' OR tienda LIKE '%SUR%' OR tienda LIKE '%ECOMMERCE%' OR tienda LIKE '%OS%' OR tienda LIKE '%POP%') "; 
    }
    if(strpos($username, "NEW") !== false) {
        $filtro_tienda = "AND tienda LIKE 'NB%'";
    }


    if($mes == "" && $anio == ""){
        $trafico="SELECT COUNT(id) AS trafico, tienda FROM V_TRAFICO WHERE tipo_evento = 'Entrada' AND fecha BETWEEN '".$anio_actual."-".$mes_actual."-".$dia_actual."T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59' $filtro_tienda GROUP BY tienda ORDER BY COUNT(id) DESC";
    }
    else{
        $fecha = $anio."-".$mes."-01";
        $dia = date("t", strtotime($fecha));
        $trafico="SELECT COUNT(id) AS trafico, tienda FROM V_TRAFICO WHERE tipo_evento = 'Entrada' AND fecha BETWEEN '".$anio."-".$mes."-01T00:00:00' AND '".$anio."-".$mes."-".$dia."T23:59:59' $filtro_tienda GROUP BY tienda ORDER BY COUNT(id) DESC";
    }
    //echo "sql: ".$trafico;
    $res_trafico=sqlsrv_query($conn,$trafico);
 
?>