<?PHP
header("Pragma: public");
header("Expires: 0");
$filename = "giftcards.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../conexion/conexion.php");
ini_set('max_execution_time', '0'); 
//include("../validacion/validacion.php");
$conn = conectate2();

$consulta = "SELECT 
            T.IDTARJETA,
            T.OBSERVACIONES AS ADICIONAL,
            TE.IMPORTE,
            T.SALDOTARJETA,
            CONVERT(VARCHAR,F.FECHACREACION,103) AS FECHA,
            F.NUMSERIE,
            F.NUMFACTURA,
            C.NOMBRECLIENTE,
            T.ALIAS
            FROM
            TARJETAS T LEFT JOIN TESORERIA TE ON SUBSTRING(TE.SUDOCUMENTO,1,8) = CAST(T.IDTARJETA AS VARCHAR) LEFT JOIN
            FACTURASVENTA F ON TE.SERIE = F.NUMSERIE AND TE.NUMERO = F.NUMFACTURA LEFT JOIN
            CLIENTES C ON F.CODCLIENTE = C.CODCLIENTE
            WHERE
            T.IDTIPOTARJETA = 2
            ORDER BY 
            T.IDTARJETA";

    $res=sqlsrv_query($conn,$consulta);	

    //echo $sql;

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
            <th class="sortable-column sort-asc">TARJETA</th>
            <th class="sortable-column sort-asc">ADICIONAL</th>
            <th class="sortable-column sort-asc">OBS.</th>
            <th class="sortable-column sort-asc">IMPORTE</th>
            <th class="sortable-column sort-asc">SALDO</th>
            <th class="sortable-column sort-asc">FECHA</th>
            <th class="sortable-column sort-asc">FACTURA</th>
            <th class="sortable-column sort-asc">ALMACEN</th>
            <th class="sortable-column sort-asc">CLIENTE</th>
        </tr>
        </thead>

        <tbody>

        <?php
        $almacen = "";

        $res_consulta=sqlsrv_query($conn,$consulta);
        while($row=sqlsrv_fetch_array($res_consulta)) { 
            $fac = $row["NUMSERIE"];
            if($fac == 'C11F'){
                $almacen = 'CH QUICENTRO';
            }
            if($fac == 'C21F'){
                $almacen = 'CH JARDIN';
            }
            if($fac == 'C31F'){
                $almacen = 'CH MALL DEL RIO';
            }
            if($fac == 'C41F'){
                $almacen = 'CH SAN MARINO';
            }
            if($fac == 'C51F'){
                $almacen = 'CH MALL DEL SOL';
            }
            if($fac == 'C61F'){
                $almacen = 'CH MALL DEL PACIFICO';
            }
            if($fac == 'C71F'){
                $almacen = 'CH CEIBOS';
            }
            if($fac == 'B11F'){
                $almacen = 'SIETE QUICENTRO';
            }
            if($fac == 'B21F'){
                $almacen = 'SIETE JARDIN';
            }
            if($fac == 'B31F'){
                $almacen = 'QUICENTRO SUR';
            }
            if($fac == 'B41F'){
                $almacen = 'SIETE MALL DEL PACIFICO';
            }
            if($fac == 'B51F'){
                $almacen = 'SIETE MALL DEL RIO';
            }
            if($fac == 'B71F'){
                $almacen = 'SIETE RIOCENTRO';
            }
            if($fac == 'B81F'){
                $almacen = 'SIETE MALL DEL SOL';
            }
            if($fac == 'BA1F'){
                $almacen = 'OUTLET CHILLOS';
            }
            if($fac == 'BB1F'){
                $almacen = 'OUTLET MALL DEL NORTE';
            }
            if($fac == 'N11F'){
                $almacen = 'NB SCALA';
            }
            if($fac == 'N21F'){
                $almacen = 'NB QUICENTRO';
            }
            if($fac == 'N31F'){
                $almacen = 'NB MALL DEL RIO';
            }
            if($fac == 'E11F'){
                $almacen = 'ECOMMERCE';
            }

        ?>
            <tr>
            <td><?php echo $row["IDTARJETA"]?></td>
            <td><?php echo $row["ADICIONAL"]?></td>
            <td><?php echo $row["ALIAS"]?></td>
            <td><?php echo $row["IMPORTE"]?></td>
            <td><?php echo number_format($row["SALDOTARJETA"],2,',','.')?></td>
            <td><?php echo $row["FECHA"]?></td>
            <td><?php echo $row["NUMSERIE"]."-".$row["NUMFACTURA"]?></td>
            <td><?php echo $almacen;?></td>
            <td><?php echo $row["NOMBRECLIENTE"]?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
    </table>