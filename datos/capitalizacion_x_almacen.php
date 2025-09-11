<?PHP
    header("Content-Type: text/html;charset=utf-8");
    //include("../conexion/conexion.php");
    //include("../validacion/validacion.php");
    //$conn = conectate(); 

    $filtro_tienda = ""; 

if(strpos($username, "CH") !== false) {
    $filtro_tienda = "AND tienda LIKE 'CH%'";
}
if(strpos($username, "SIE") !== false) {
    $filtro_tienda = "AND (tienda LIKE '%SIETE%' OR tienda LIKE '%SUR%' OR tienda LIKE '%ECOMMERCE%') ";
}
if(strpos($username, "NEW") !== false) {
    $filtro_tienda = "AND tienda LIKE 'NEW%'";
}

    if($mes == "" && $anio == ""){
        $facturas_nuevos="SELECT facturas FROM CAP_FACT_ESTADO WHERE estado = 'NUEVOS' GROUP BY tienda ORDER BY facturas";
    }
    else{
        $fecha = $anio."-".$mes."-01";
        $dia = date("t", strtotime($fecha));
        $facturas_nuevos="SELECT facturas FROM CAP_FACT_ESTADO WHERE estado = 'NUEVOS' GROUP BY tienda ORDER BY facturas";
    }
    //echo $ventas_x_almacen_dia;
    $res_nuevos=sqlsrv_query($conn,$facturas_nuevos);
?>