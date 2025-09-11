<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
ini_set('max_execution_time', '0');
//include("../validacion/validacion.php");
$conn = conectate();

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

$desdenew = $anio_anterior."-".date("m",strtotime($hasta3))."-01T00:00:00";

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
                T1.COD_CLIENTE, 
                T1.ESTADO_CLIENTE,
                CASE   
                WHEN T1.ESTADO_CLIENTE = 'CLIENTE NUEVO' THEN 
                CASE   
                    WHEN SUM(VENTA_NETA) >= 5 AND SUM(VENTA_NETA) <= 300.99 THEN 'Friend'
                    WHEN SUM(VENTA_NETA) >= 301 AND SUM(VENTA_NETA) <= 500.99 THEN 'Best Friend'
                    WHEN SUM(VENTA_NETA) >= 501 AND SUM(VENTA_NETA) <= 899.99 THEN 'Partner'
                    WHEN SUM(VENTA_NETA) > 900 THEN 'Icon'
                END
                WHEN T1.ESTADO_CLIENTE = 'CLIENTE ANTIGUO' THEN 
                CASE   
                    WHEN SUM(VENTA_NETA) >= 5 AND SUM(VENTA_NETA) <= 300.99 THEN 'Friend'
                    WHEN SUM(VENTA_NETA) >= 301 AND SUM(VENTA_NETA) <= 500.99 THEN 'Best Friend'
                    WHEN SUM(VENTA_NETA) >= 501 AND SUM(VENTA_NETA) <= 899.99 THEN 'Partner'
                    WHEN SUM(VENTA_NETA) > 900 THEN 'Icon'
                END 
                END AS SEGMENTO,
            SUM(VENTA_NETA) AS VENTA_NETA_ACTUAL,
            T1.EMAIL_CLIENTE,
            T1.CELULAR_CLIENTE,
            CONVERT(VARCHAR,ISNULL(MAX(T1.FECHA_FACTURA),'2010-01-01'),103) AS ULTIMA_FACTURA
            FROM            
                VENTAS_ECOMMERCE T1
            WHERE 
                T1.FECHA_FACTURA BETWEEN '$desde4' AND '$hasta4'
            GROUP BY
                T1.CEDULA_CLIENTE,
                T1.COD_CLIENTE,   
                T1.ESTADO_CLIENTE,
                T1.EMAIL_CLIENTE,
                T1.CELULAR_CLIENTE";
    $res=sqlsrv_query($conn,$sql);
    
    $sql2 = "SELECT distincT CEDULA_CLIENTE, (
        select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_ECOMMERCE]
        where [FECHA_FACTURA] between '$newDesde' and '$newHasta'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE 
        group by CEDULA_CLIENTE) as Periodo1,
        
        (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_ECOMMERCE]
        where [FECHA_FACTURA] between '$newDesde2' and '$newHasta2'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE 
        group by CEDULA_CLIENTE) as Periodo2,
        case
        when (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_ECOMMERCE]
        where [FECHA_FACTURA] between '$newDesde' and '$newHasta'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE 
        group by CEDULA_CLIENTE) is not NULL and (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_ECOMMERCE]
        where [FECHA_FACTURA] between '$newDesde2' and '$newHasta2'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE 
        group by CEDULA_CLIENTE) is not NULL then 'Mismo Cliente'
        when (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_ECOMMERCE]  
        where [FECHA_FACTURA] between '$newDesde' and '$newHasta'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE 
        group by CEDULA_CLIENTE) is NULL and (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_ECOMMERCE]
        where [FECHA_FACTURA] between '$newDesde2' and '$newHasta2'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE 
        group by CEDULA_CLIENTE) is not NULL then 'Nuevo o Recuperado'
        when (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_ECOMMERCE]
        where [FECHA_FACTURA] between '$newDesde' and '$newHasta'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE 
        group by CEDULA_CLIENTE) is not NULL and (select COUNT(distincT (NUMERO_FACTURA))
        from [dbo].[VENTAS_ECOMMERCE]
        where [FECHA_FACTURA] between '$newDesde2' and '$newHasta2'
        and CEDULA_CLIENTE = a.CEDULA_CLIENTE 
        group by CEDULA_CLIENTE) is NULL then 'Inactivo' end TIPO_CLIENTE
        from [dbo].[VENTAS_ECOMMERCE] a
        where [FECHA_FACTURA] between '$newDesde' and '$newHasta2' ";

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

        if($recuperado <= 0){
            $recuperado = $recuperado;
        }
        else{
            $recuperado = $recuperado - $nuevo;
        }
    }

    $sql3 = "SELECT COUNT (distinct [CEDULA_CLIENTE]) AS NUEVOS
    from [dbo].[VENTAS_ECOMMERCE] 
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
                    if($row["SEGMENTO"] == "Friend"){
                        $up = 212 - $row["VENTA_NETA_ACTUAL"];
                        $down = -1*(4 - $row["VENTA_NETA_ACTUAL"]);
                        $amateur++;
                    }
                    if($row["SEGMENTO"] == "Best Friend"){
                        $up = 601 - $row["VENTA_NETA_ACTUAL"];
                        $down = -1*(212 - $row["VENTA_NETA_ACTUAL"]);
                        $expert++;
                    }
                    if($row["SEGMENTO"] == "Partner"){
                        $up = 1006 - $row["VENTA_NETA_ACTUAL"];
                        $down = -1*(601 - $row["VENTA_NETA_ACTUAL"]);
                        $believer++;
                    }
                    if($row["SEGMENTO"] == "Icon"){
                        $up = 0;
                        $down = -1*(1006 - $row["VENTA_NETA_ACTUAL"]);
                        $ambassador++;
                    }

                    // if($row["ESTADO_CLIENTE"] == 'CLIENTE NUEVO'){
                    //     $nuevo++;
                    //     $color = "fg-green";
                    // }

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
                <th>FRIEND</th>
                <th>BEST FRIEND</th>
                <th>PARTNER</th>
                <th>ICON</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $nuevo;?></td>
                <td><?php echo $inactivo;?></td>
                <td><?php echo $recuperado;?></td>
                <td><?php echo $mismos;?></td>
                <td><?php echo ($mismos+$nuevo+$recuperado);?></td>
                <td><?php echo $amateur;?></td>
                <td><?php echo $expert;?></td>
                <td><?php echo $believer;?></td>
                <td><?php echo $ambassador;?></td>
            </tr>
        </tbody>
    </table>