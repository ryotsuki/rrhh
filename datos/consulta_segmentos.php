<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
ini_set('max_execution_time', '0');
//include("../validacion/validacion.php"); 
$conn = conectate4();
$conn2 = conectate();

$mes_actual = date("m");
$mes_anterior = $mes_actual - 1;
$anio_actual = date("Y");
$anio_anterior = $anio_actual - 1;

$desde = $_GET["desde"];
$hasta = $_GET["hasta"];

$newDesde = date("d/m/Y", strtotime($desde)); 
$newHasta = date("d/m/Y", strtotime($hasta)); 

$desde3 = $_GET["desde3"];
$hasta3 = $_GET["hasta3"];

$newDesde2 = date("d/m/Y", strtotime($desde3)); 
$newHasta2 = date("d/m/Y", strtotime($hasta3));

$desde2 = $desde."T00:00:00";
$hasta2 = $hasta."T23:59:59";
$desde4 = $desde3."T00:00:00";
$hasta4 = $hasta3."T23:59:59";

$desdenew = $anio_actual."-".date("m",strtotime($hasta3))."-01T00:00:00";

    $amateur = 0;
    $expert = 0;
    $believer = 0;
    $ambassador = 0;
    $inactivo = 0;
    $nuevo = 0;
    $por_inactivar = 0;
    $color = "";
    $recuperado = 0;
    $mismos = 0;

session_start(); 

    $sql="SELECT DISTINCT
                T1.CEDULA_CLIENTE,
                T1.ESTADO_CLIENTE,
                CASE   
                WHEN T2.SEGMENTO IS NULL OR T2.SEGMENTO = '' THEN 
                CASE   
                    WHEN SUM(VENTA_NETA) >= 4 AND SUM(VENTA_NETA) <= 211.99 THEN 'Amateur'
                    WHEN SUM(VENTA_NETA) >= 212 AND SUM(VENTA_NETA) <= 600.99 THEN 'Expert'
                    WHEN SUM(VENTA_NETA) >= 601 AND SUM(VENTA_NETA) <= 1005.99 THEN 'Believer'
                    WHEN SUM(VENTA_NETA) > 1006 THEN 'Ambassador'
                    ELSE 'No aplica'
                END
                ELSE T2.SEGMENTO
                END AS SEGMENTO,
            SUM(VENTA_NETA) AS VENTA_NETA_ACTUAL,
            T1.EMAIL_CLIENTE,
            T1.CELULAR_CLIENTE,
            CONVERT(VARCHAR,ISNULL(MAX(T1.FECHA_FACTURA),'2010-01-01'),103) AS ULTIMA_FACTURA,
            DATEDIFF(mm,(SELECT MAX(FECHA_FACTURA) FROM VENTAS_MERCADEO_Y_MODA  WHERE T1.CEDULA_CLIENTE = CEDULA_CLIENTE),GETDATE()) AS MESES_SIN_VENTAS,
            CASE
            WHEN (DATEDIFF(mm,(SELECT MAX(FECHA_FACTURA) FROM VENTAS_MERCADEO_Y_MODA  WHERE T1.CEDULA_CLIENTE = CEDULA_CLIENTE),GETDATE()) >= 9 AND DATEDIFF(mm,(SELECT MAX(FECHA_FACTURA) FROM VENTAS_MERCADEO_Y_MODA  WHERE T1.CEDULA_CLIENTE = CEDULA_CLIENTE),GETDATE()) <= 11) THEN 'POR INACTIVAR'
            WHEN (DATEDIFF(mm,(SELECT MAX(FECHA_FACTURA) FROM VENTAS_MERCADEO_Y_MODA  WHERE T1.CEDULA_CLIENTE = CEDULA_CLIENTE),GETDATE()) > 11)  THEN 'INACTIVO'
            WHEN (DATEDIFF(mm,(SELECT MAX(FECHA_FACTURA) FROM VENTAS_MERCADEO_Y_MODA  WHERE T1.CEDULA_CLIENTE = CEDULA_CLIENTE),GETDATE()) < 9)  THEN 'ACTIVO'
            END AS ESTADO,
            CASE
            WHEN FECHA_CREACION BETWEEN '2022-03-01T00:00:00' AND '2022-03-31T23:59:59' THEN 'NUEVO'
            ELSE 'ANTIGUO'
            END AS NUEVO
            FROM            
                VENTAS_MERCADEO_Y_MODA T1
            LEFT JOIN CLIENTES_SEGMENTADOS T2 ON
                T1.COD_CLIENTE = T2.COD_CLIENTE
            WHERE 
                T1.FECHA_FACTURA BETWEEN '$desde2' AND '$hasta4'
            GROUP BY
                T1.CEDULA_CLIENTE, 
                T1.ESTADO_CLIENTE,
                T2.SEGMENTO,
                T1.EMAIL_CLIENTE,
                T1.CELULAR_CLIENTE,
	            T1.FECHA_CREACION";
    $res=sqlsrv_query($conn,$sql);

    //echo $sql;
    
    $sql2 = "SELECT distincT CEDULA_CLIENTE, (
        select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_MERCADEO_Y_MODA]
        where [FECHA_FACTURA] between '$desde2' and '$hasta2'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE
        group by CEDULA_CLIENTE) as Periodo1,
        
        (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_MERCADEO_Y_MODA]
        where [FECHA_FACTURA] between '$desde4' and '$hasta4'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE
        group by CEDULA_CLIENTE) as Periodo2,
        case
        when (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_MERCADEO_Y_MODA]
        where [FECHA_FACTURA] between '$desde2' and '$hasta2'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE
        group by CEDULA_CLIENTE) is not NULL and (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_MERCADEO_Y_MODA]
        where [FECHA_FACTURA] between '$desde4' and '$hasta4'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE
        group by CEDULA_CLIENTE) is not NULL then 'Mismo Cliente'
        when (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_MERCADEO_Y_MODA]
        where [FECHA_FACTURA] between '$desde2' and '$hasta2'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE
        group by CEDULA_CLIENTE) is NULL and (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_MERCADEO_Y_MODA]
        where [FECHA_FACTURA] between '$desde4' and '$hasta4'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE
        group by CEDULA_CLIENTE) is not NULL then 'Nuevo o Recuperado'
        when (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_MERCADEO_Y_MODA]
        where [FECHA_FACTURA] between '$desde2' and '$hasta2'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE
        group by CEDULA_CLIENTE) is not NULL and (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_MERCADEO_Y_MODA]
        where [FECHA_FACTURA] between '$desde4' and '$hasta4'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE
        group by CEDULA_CLIENTE) is NULL then 'Inactivo' end TIPO_CLIENTE
        from [dbo].[VENTAS_MERCADEO_Y_MODA] a
        where [FECHA_FACTURA] between '$desde2' and '$hasta4'";

    //echo $sql2;
    $res2=sqlsrv_query($conn,$sql2);
    while($row2=sqlsrv_fetch_array($res2)) { 
        if($row2["TIPO_CLIENTE"] == "Inactivo"){
            $inactivo++;
        }

        if($row2["TIPO_CLIENTE"] == "Nuevo o Recuperado"){
            $recuperado++;
        }

        if($row2["TIPO_CLIENTE"] == "Mismo Cliente"){
            $mismos++;
        }
    }

    $sql3 = "SELECT COUNT (distinct [CEDULA_CLIENTE]) AS NUEVOS
    from [dbo].[VENTAS_MERCADEO_Y_MODA] 
    where FECHA_CREACION BETWEEN '$desdenew' AND '$hasta4'";
    
    $res3=sqlsrv_query($conn,$sql3);
    while($row3=sqlsrv_fetch_array($res3)) {
        $nuevo = $row3["NUEVOS"];
     }
    

    //echo $sql3; 
    //$consulta_descripcion 

?>

<table class="table compact striped table-border mt-4" data-role="table"
            data-rownum="true"
            data-search-min-length="3"
            data-rows-steps="5,10,20,50,100,200"
            data-table-rows-count-title="Mostrar:"
            data-table-search-title="Buscar:"
            data-table-info-title="Mostrando de $1 a $2 de $3 resultados"
            data-pagination-prev-title="Ant"
            data-pagination-next-title="Sig"
        >
            <thead>
            <tr>
                <th class="sortable-column sort-asc">CEDULA</th>
                <th class="sortable-column sort-asc">EMAIL</th>
                <th class="sortable-column sort-asc">TELEFONO</th>
                <th class="sortable-column sort-asc">SEGMENTO</th>
                <th class="sortable-column sort-asc">VENTA NETA</th>
                <th class="sortable-column sort-asc">ULT. FACTURA</th>
                <th class="sortable-column sort-asc">SEG. UP</th>
                <th class="sortable-column sort-asc">SEG. DOWN</th>
                <th class="sortable-column sort-asc">ESTADO</th>
                <th class="sortable-column sort-asc">NUEVO</th>
            </tr>
            </thead>

            <tbody>
            <?php 
                while($row=sqlsrv_fetch_array($res)) { 
                    // if($row["SEGMENTO"] == "Inactivo"){
                    //     $up = 4 - $row["VENTA_NETA_ACTUAL"];
                    //     $down = 0;
                    //     $inactivo++;
                    // }
                    if($row["SEGMENTO"] == "Amateur"){
                        $up = 212 - $row["VENTA_NETA_ACTUAL"];
                        $down = -1*(4 - $row["VENTA_NETA_ACTUAL"]);
                        $amateur++;
                    }
                    if($row["SEGMENTO"] == "Expert"){
                        $up = 601 - $row["VENTA_NETA_ACTUAL"];
                        $down = -1*(212 - $row["VENTA_NETA_ACTUAL"]);
                        $expert++;
                    }
                    if($row["SEGMENTO"] == "Believer"){
                        $up = 1006 - $row["VENTA_NETA_ACTUAL"];
                        $down = -1*(601 - $row["VENTA_NETA_ACTUAL"]);
                        $believer++;
                    }
                    if($row["SEGMENTO"] == "Ambassador"){
                        $up = 0;
                        $down = -1*(1006 - $row["VENTA_NETA_ACTUAL"]);
                        $ambassador++;
                    }


                    $fecha = $row["ULTIMA_FACTURA"];
                    $fechaComoEntero = strtotime($fecha);
                    $anio_actual = date("Y");
                    $anio_factura = date("Y", $fechaComoEntero);
                    $mes_actual = date("m");
                    $mes_anterior = $mes_actual - 1;
                    $mes_factura = date("m", $fechaComoEntero);

                    if($anio_factura < $anio_actual){
                        if($mes_factura < $mes_actual){
                            $por_inactivar++;
                            $color = "fg-red";
                        }
                    }
            ?>
            <tr>
                <td data-cls-column="<?php echo $color;?>"><?php echo $row["CEDULA_CLIENTE"]?></td>
                <td><?php echo $row["EMAIL_CLIENTE"]?></td>
                <td><?php echo $row["CELULAR_CLIENTE"]?></td>
                <td><?php echo $row["SEGMENTO"]?></td>
                <td><?php echo number_format($row["VENTA_NETA_ACTUAL"],2,',','.')?></td>
                <td><?php echo $row["ULTIMA_FACTURA"]?></td>
                <td><?php echo number_format($up,2,',','.')?></td>
                <td><?php echo number_format($down,2,',','.')?></td>
                <td><?php echo $row["ESTADO"]?></td>
                <td><?php echo $row["NUEVO"]?></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
            
        </table>

        <hr>
        <h4>Resumen por segmentos: Desde <?php echo $desde;?> hasta <?php echo $hasta;?></h4>

        <table class="table compact striped table-border">
        <thead>
            <tr>
                <th>NUEVOS</th>
                <th>INACTIVOS</th>
                <th>RECUPERADOS</th>
                <th>MISMOS</th>
                <th>ACTIVOS CRM</th>
                <th>AMATEUR</th>
                <th>EXPERT</th>
                <th>BELIEVER</th>
                <th>AMBASSADOR</th>
            </tr>
        </thead>
        <tbody>
            <tr> 
                <!-- <td><?php echo $nuevo;?></td> -->
                <!-- <td><?php echo $inactivo;?></td>
                <td><?php echo $por_inactivar;?></td> -->

                <td><?php echo $nuevo;?></td>
                <td><?php echo $inactivo;?></td>
                <td><?php echo ($recuperado-$nuevo);?></td>
                <td><?php echo $mismos;?></td>
                <td><?php echo ($mismos+$nuevo+($recuperado-$nuevo));?></td>
                <td><?php echo $amateur;?></td>
                <td><?php echo $expert;?></td>
                <td><?php echo $believer;?></td>
                <td><?php echo $ambassador;?></td>
            </tr>
        </tbody>
    </table>