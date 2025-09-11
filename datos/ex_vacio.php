<?PHP
ini_set('max_execution_time', '0');
header("Pragma: public");
header("Expires: 0");
$filename = "segmentos.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../conexion/conexion.php");
$conn = conectate4();

// $consulta_segmentos = "SELECT DISTINCT
//                         T1.CEDULA_CLIENTE,
//                         T1.COD_CLIENTE, 
//                         T1.ESTADO_CLIENTE,
//                         CASE   
//                         WHEN T1.ESTADO_CLIENTE = 'CLIENTE NUEVO' THEN 
//                         CASE   
//                             WHEN SUM(VENTA_NETA) >= 4 AND SUM(VENTA_NETA) <= 211.99 THEN 'Amateur'
//                             WHEN SUM(VENTA_NETA) >= 212 AND SUM(VENTA_NETA) <= 600.99 THEN 'Expert'
//                             WHEN SUM(VENTA_NETA) >= 601 AND SUM(VENTA_NETA) <= 1005.99 THEN 'Believer'
//                             WHEN SUM(VENTA_NETA) > 1006 THEN 'Ambassador'
//                         END
//                         WHEN T1.ESTADO_CLIENTE = 'CLIENTE ANTIGUO' THEN ISNULL(T2.SEGMENTO,'Inactivo')  
//                         END AS SEGMENTO,
//                         SUM(VENTA_NETA) AS VENTA_NETA_ACTUAL,
//                         T1.EMAIL_CLIENTE,
//                         T1.CELULAR_CLIENTE,
//                         CONVERT(VARCHAR,ISNULL(MAX(T1.FECHA_FACTURA),'2010-01-01'),103) AS ULTIMA_FACTURA,
//                         CASE   
//                             WHEN T3.IDTIPOTARJETA = 4 THEN 'Amateur'
//                             WHEN T3.IDTIPOTARJETA = 5 THEN 'Expert'
//                             WHEN T3.IDTIPOTARJETA = 6 THEN 'Believer'
//                             WHEN T3.IDTIPOTARJETA = 7 THEN 'Ambassador'
//                             ELSE 'Sin segmento'
//                         END AS LEGACY
//                         FROM            
//                         VENTAS_MERCADEO_Y_MODA T1 LEFT JOIN 
//                         CLIENTES_SEGMENTADOS T2 ON T1.COD_CLIENTE = T2.COD_CLIENTE LEFT JOIN
//                         [192.168.100.141].[NOVOMODE].dbo.[TARJETAS] AS T3 ON T3.CODCLIENTE = T1.COD_CLIENTE
//                         WHERE 
//                         T1.FECHA_FACTURA BETWEEN DATEADD(YEAR, -1, GETDATE()) AND GETDATE()
//                         GROUP BY
//                         T1.CEDULA_CLIENTE,
//                         T1.COD_CLIENTE,   
//                         T1.ESTADO_CLIENTE,
//                         T2.SEGMENTO,
//                         T1.EMAIL_CLIENTE,
//                         T1.CELULAR_CLIENTE,
//                         T3.IDTIPOTARJETA";

$consulta_segmentos = "SELECT DISTINCT
                        T1.CEDULA_CLIENTE,
                        T3.CODCLIENTE,
                        (SELECT SUM(VENTA_NETA) FROM VENTAS_MERCADEO_Y_MODA WHERE COD_CLIENTE = T3.CODCLIENTE )AS VENTA_NETA_ACTUAL,
                        (SELECT MAX(EMAIL_CLIENTE) FROM VENTAS_MERCADEO_Y_MODA WHERE CEDULA_CLIENTE = T1.CEDULA_CLIENTE ) AS EMAIL_CLIENTE,
                        (SELECT MAX(CELULAR_CLIENTE) FROM VENTAS_MERCADEO_Y_MODA WHERE CEDULA_CLIENTE = T1.CEDULA_CLIENTE ) AS CELULAR_CLIENTE,
                        CASE   
                            WHEN T3.IDTIPOTARJETA = 4 THEN 'Amateur'
                            WHEN T3.IDTIPOTARJETA = 5 THEN 'Expert'
                            WHEN T3.IDTIPOTARJETA = 6 THEN 'Believer'
                            WHEN T3.IDTIPOTARJETA = 7 THEN 'Ambassador'
                            ELSE 'Sin segmento'
                        END AS LEGACY
                        FROM            
                        [192.168.100.141].[NOVOMODE].dbo.[TARJETAS] AS T3 LEFT JOIN 
                        VENTAS_MERCADEO_Y_MODA T1 ON T3.CODCLIENTE = T1.COD_CLIENTE
                        GROUP BY
                        T3.CODCLIENTE, 
                        T1.CEDULA_CLIENTE,
                        T1.EMAIL_CLIENTE,
                        T1.CELULAR_CLIENTE,
                        T3.IDTIPOTARJETA
                        ORDER BY
                        T3.CODCLIENTE";

    $res=sqlsrv_query($conn,$consulta_segmentos);
    
    $amateur = 0;
    $expert = 0;
    $believer = 0;
    $ambassador = 0;
    $inactivo = 0;

?>

<style type="text/css">

.xl65
{
    mso-style-parent:style0;
    mso-number-format:"\@";
}

</style>

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
                <th class="sortable-column sort-asc">SEG. UP</th>
                <th class="sortable-column sort-asc">SEG. DOWN</th>
            </tr>
            </thead>

            <tbody>
            <?php 
                while($row=sqlsrv_fetch_array($res)) { 
                    if($row["LEGACY"] == "Inactivo"){
                        $up = 4 - $row["VENTA_NETA_ACTUAL"];
                        $down = 0;
                        $inactivo++;
                    }
                    if($row["LEGACY"] == "Amateur"){
                        $up = 212 - $row["VENTA_NETA_ACTUAL"];
                        $down = -1*(4 - $row["VENTA_NETA_ACTUAL"]);
                        $amateur++;
                    }
                    if($row["LEGACY"] == "Expert"){
                        $up = 601 - $row["VENTA_NETA_ACTUAL"];
                        $down = -1*(212 - $row["VENTA_NETA_ACTUAL"]);
                        $expert++;
                    }
                    if($row["LEGACY"] == "Believer"){
                        $up = 1006 - $row["VENTA_NETA_ACTUAL"];
                        $down = -1*(601 - $row["VENTA_NETA_ACTUAL"]);
                        $believer++;
                    }
                    if($row["LEGACY"] == "Ambassador"){
                        $up = 0;
                        $down = -1*(1006 - $row["VENTA_NETA_ACTUAL"]);
                        $ambassador++;
                    }

            ?>
            <tr>
                <td class="xl65" data-cls-column="<?php echo $color;?>"><?php echo $row["CEDULA_CLIENTE"]?></td>
                <td><?php echo $row["EMAIL_CLIENTE"]?></td>
                <td><?php echo $row["CELULAR_CLIENTE"]?></td>
                <td><?php echo $row["LEGACY"]?></td>
                <td><?php echo number_format($row["VENTA_NETA_ACTUAL"],2,',','.')?></td>
                <td><?php echo number_format($up,2,',','.')?></td>
                <td><?php echo number_format($down,2,',','.')?></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
            
        </table>

        <!-- <table class="table compact striped table-border">
        <thead>
            <tr>
                <th>INACTIVOS</th>
                <th>AMATEUR</th>
                <th>EXPERT</th>
                <th>BELIEVER</th>
                <th>AMBASSADOR</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $inactivo;?></td>
                <td><?php echo $amateur;?></td>
                <td><?php echo $expert;?></td>
                <td><?php echo $believer;?></td>
                <td><?php echo $ambassador;?></td>
            </tr>
        </tbody> -->