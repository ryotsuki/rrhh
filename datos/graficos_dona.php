<?PHP
    header("Content-Type: text/html;charset=utf-8");
    //include("../conexion/conexion.php");
    //include("../validacion/validacion.php");
    //$conn = conectate();

    if($mes == "" && $anio == ""){
        $consulta_ventas_mes_grafico="SELECT SUM(VTA_NETA) AS VENTA_NETA,ALMACEN FROM VENTAS WHERE FECHA BETWEEN '".$anio_actual."-".$mes_actual."-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59' GROUP BY ALMACEN ORDER BY VENTA_NETA DESC ";
        //echo $ventas_x_almacen_dia;
        $res_ventas_mes_grafico=sqlsrv_query($conn,$consulta_ventas_mes_grafico);

        $grafico_ventas_mes = '';
        while($row=sqlsrv_fetch_array($res_ventas_mes_grafico)) {
            $grafico_ventas_mes.= "{ label:'".$row["ALMACEN"]."', value:".$row["VENTA_NETA"]."}, ";
        }
        $grafico_ventas_mes = substr($grafico_ventas_mes, 0, -2);

        //VENTAS POR FRANQUICIA
        $consulta_por_franquicia = "SELECT TOP (1) 
                                        (SELECT SUM(VTA_NETA) FROM VENTAS WHERE ALMACEN LIKE '%CH %' AND FECHA BETWEEN '".$anio_actual."-".$mes_actual."-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59') AS CHEVIGNON,
                                        (SELECT SUM(VTA_NETA) FROM VENTAS WHERE (ALMACEN LIKE '%SIETE%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%POP UP%' OR ALMACEN LIKE '%ECOMMERCE%' OR ALMACEN LIKE '%OUTLET%') AND FECHA BETWEEN '".$anio_actual."-".$mes_actual."-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59') AS SIETE,
                                        (SELECT SUM(VTA_NETA) FROM VENTAS WHERE ALMACEN LIKE '%NEW %' AND FECHA BETWEEN '".$anio_actual."-".$mes_actual."-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59') AS NEWBALANCE
                                    FROM
                                        VENTAS
                                    WHERE FECHA BETWEEN '".$anio_actual."-".$mes_actual."-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59'";
        $res_venta_por_franquicia = sqlsrv_query($conn,$consulta_por_franquicia);

        $consulta_ventas_mes_grafico_siete="SELECT SUM(VTA_NETA) AS VENTA_NETA,ALMACEN FROM VENTAS WHERE FECHA BETWEEN '".$anio_actual."-".$mes_actual."-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59' AND (ALMACEN LIKE '%SIETE%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%POP UP%' OR ALMACEN LIKE '%ECOMMERCE%' OR ALMACEN LIKE '%OUTLET%') GROUP BY ALMACEN ORDER BY VENTA_NETA DESC ";
        //echo $ventas_x_almacen_dia;
        $res_ventas_mes_grafico_siete=sqlsrv_query($conn,$consulta_ventas_mes_grafico_siete);
        $res_ventas_mes_siete=sqlsrv_query($conn,$consulta_ventas_mes_grafico_siete);

        $grafico_ventas_mes_siete = '';
        while($row=sqlsrv_fetch_array($res_ventas_mes_grafico_siete)) {
            $grafico_ventas_mes_siete.= "{ label:'".$row["ALMACEN"]."', value:".$row["VENTA_NETA"]."}, ";
        }
        $grafico_ventas_mes_siete = substr($grafico_ventas_mes_siete, 0, -2);

        $consulta_ventas_mes_grafico_chevignon="SELECT SUM(VTA_NETA) AS VENTA_NETA,ALMACEN FROM VENTAS WHERE FECHA BETWEEN '".$anio_actual."-".$mes_actual."-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59' AND (ALMACEN LIKE 'CH %' OR ALMACEN = 'CHEVIGNON ONLINE') GROUP BY ALMACEN ORDER BY VENTA_NETA DESC ";
        //echo $ventas_x_almacen_dia;
        $res_ventas_mes_grafico_chevignon=sqlsrv_query($conn,$consulta_ventas_mes_grafico_chevignon);
        $res_ventas_mes_chevignon=sqlsrv_query($conn,$consulta_ventas_mes_grafico_chevignon);

        $grafico_ventas_mes_chevignon = '';
        while($row=sqlsrv_fetch_array($res_ventas_mes_grafico_chevignon)) {
            $grafico_ventas_mes_chevignon.= "{ label:'".$row["ALMACEN"]."', value:".$row["VENTA_NETA"]."}, ";
        }
        $grafico_ventas_mes_chevignon = substr($grafico_ventas_mes_chevignon, 0, -2);
    }
    else{
        $fecha = $anio."-".$mes."-01";
        $dia = date("t", strtotime($fecha));
        $consulta_ventas_mes_grafico="SELECT SUM(VTA_NETA) AS VENTA_NETA,ALMACEN FROM VENTAS WHERE FECHA BETWEEN '".$anio."-".$mes."-01T00:00:00' AND '".$anio."-".$mes."-".$dia."T23:59:59' GROUP BY ALMACEN ORDER BY VENTA_NETA DESC ";
        //echo $ventas_x_almacen_dia;
        $res_ventas_mes_grafico=sqlsrv_query($conn,$consulta_ventas_mes_grafico);

        $grafico_ventas_mes = '';
        while($row=sqlsrv_fetch_array($res_ventas_mes_grafico)) {
            $grafico_ventas_mes.= "{ label:'".$row["ALMACEN"]."', value:".$row["VENTA_NETA"]."}, ";
        }
        $grafico_ventas_mes = substr($grafico_ventas_mes, 0, -2);

        //VENTAS POR FRANQUICIA
        $consulta_por_franquicia = "SELECT TOP (1) 
                                        (SELECT SUM(VTA_NETA) FROM VENTAS WHERE ALMACEN LIKE '%CH %' AND FECHA BETWEEN '".$anio."-".$mes."-01T00:00:00' AND '".$anio."-".$mes."-".$dia."T23:59:59') AS CHEVIGNON,
                                        (SELECT SUM(VTA_NETA) FROM VENTAS WHERE (ALMACEN LIKE '%SIETE%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%POP UP%' OR ALMACEN LIKE '%ECOMMERCE%' OR ALMACEN LIKE '%OUTLET%') AND FECHA BETWEEN '".$anio_actual."-".$mes_actual."-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59') AS SIETE,
                                        (SELECT SUM(VTA_NETA) FROM VENTAS WHERE ALMACEN LIKE '%NEW %' AND FECHA BETWEEN '".$anio_actual."-".$mes_actual."-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59') AS NEWBALANCE
                                    FROM
                                        VENTAS
                                    WHERE FECHA BETWEEN '".$anio."-".$mes."-01T00:00:00' AND '".$anio."-".$mes."-".$dia."T23:59:59'";
        $res_venta_por_franquicia = sqlsrv_query($conn,$consulta_por_franquicia);

        $consulta_ventas_mes_grafico_siete="SELECT SUM(VTA_NETA) AS VENTA_NETA,ALMACEN FROM VENTAS WHERE FECHA BETWEEN '".$anio."-".$mes."-01T00:00:00' AND '".$anio."-".$mes."-".$dia."T23:59:59' AND (ALMACEN LIKE '%SIETE%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%POP UP%' OR ALMACEN LIKE '%ECOMMERCE%' OR ALMACEN LIKE '%OUTLET%') GROUP BY ALMACEN ORDER BY VENTA_NETA DESC ";
        //echo $ventas_x_almacen_dia;
        $res_ventas_mes_grafico_siete=sqlsrv_query($conn,$consulta_ventas_mes_grafico_siete);
        $res_ventas_mes_siete=sqlsrv_query($conn,$consulta_ventas_mes_grafico_siete);

        $grafico_ventas_mes_siete = '';
        while($row=sqlsrv_fetch_array($res_ventas_mes_grafico_siete)) {
            $grafico_ventas_mes_siete.= "{ label:'".$row["ALMACEN"]."', value:".$row["VENTA_NETA"]."}, ";
        }
        $grafico_ventas_mes_siete = substr($grafico_ventas_mes_siete, 0, -2);

        $consulta_ventas_mes_grafico_chevignon="SELECT SUM(VTA_NETA) AS VENTA_NETA,ALMACEN FROM VENTAS WHERE FECHA BETWEEN '".$anio."-".$mes."-01T00:00:00' AND '".$anio."-".$mes."-".$dia."T23:59:59' AND ALMACEN LIKE '%CH %' GROUP BY ALMACEN ORDER BY VENTA_NETA DESC ";
        //echo $ventas_x_almacen_dia;
        $res_ventas_mes_grafico_chevignon=sqlsrv_query($conn,$consulta_ventas_mes_grafico_chevignon);
        $res_ventas_mes_chevignon=sqlsrv_query($conn,$consulta_ventas_mes_grafico_chevignon);

        $grafico_ventas_mes_chevignon = '';
        while($row=sqlsrv_fetch_array($res_ventas_mes_grafico_chevignon)) {
            $grafico_ventas_mes_chevignon.= "{ label:'".$row["ALMACEN"]."', value:".$row["VENTA_NETA"]."}, ";
        }
        $grafico_ventas_mes_chevignon = substr($grafico_ventas_mes_chevignon, 0, -2);

        
    }
?>