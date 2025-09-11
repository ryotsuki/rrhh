<?PHP
header("Pragma: public");
header("Expires: 0");
$filename = "rotacion.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../conexion/conexion.php");
ini_set('max_execution_time', '0'); 
//include("../validacion/validacion.php");
$conn = conectate2();

$referencia = strtoupper($_GET["referencia"]);
$color = $_GET["color"];
$fecha = $_GET["fecha"];
$fecha2 = $_GET["fecha2"];
$almacen = $_GET["almacen"];
$marca = $_GET["marca"];
$anio = $_GET["anio"];
$coleccion = $_GET["coleccion"];
$ciclo = $_GET["ciclo"];
$familia = $_GET["familia"];

if($referencia != ""){
    $consulta_referencia = "AND REFERENCIA = '$referencia'";
}
else{
    $consulta_referencia = "";
}

if($color != ""){
    $consulta_color = "AND COLOR = '$color'";
}
else{
    $consulta_color = "";
}

if($marca != -1){
    $consulta_marca = "AND CODMARCA = '$marca'";
    $consulta_marca2 = ",S.CODMARCA";
}
else{
    $consulta_marca = "";
    $consulta_marca2 = "";
}

$new_anio = "'";
$new_anio.= str_replace(",", "','", $anio);
$new_anio.= "'";

if($anio != ""){
    //$consulta_anio = "AND TEMPORADA = '$anio'";
    $consulta_anio = "AND TEMPORADA IN ($new_anio)";
}
else{
    $consulta_anio = "";
}

$new_coleccion = "'";
$new_coleccion.= str_replace(",", "','", $coleccion);
$new_coleccion.= "'";

if($coleccion != ""){
    //$consulta_coleccion = "AND LINEA = '$coleccion'";
    $consulta_coleccion = "AND LINEA IN ($new_coleccion)";
}
else{
    $consulta_coleccion = "";
}

if($ciclo != ""){
    $consulta_ciclo = "AND CODFAB = '$ciclo'";
}
else{
    $consulta_ciclo = "";
}


$new_familia = "'";
$new_familia.= str_replace(",", "','", $familia);
$new_familia.= "'";

if($familia != ""){
    $consulta_familia = "AND FAMILIA IN ($new_familia)";
}
else{
    $consulta_familia = "";
}

if($fecha != ""){
    $consulta_fecha1 = "AND FECHAALBARAN BETWEEN '".$fecha."T00:00:00' AND '".$fecha2."T23:59:59'";
    $consulta_fecha2 = "AND FECHA BETWEEN '".$fecha."T00:00:00' AND '".$fecha2."T23:59:59'";
    $consulta_fecha3 = "AND FECHA BETWEEN '".$fecha."T00:00:00' AND '".$fecha2."T23:59:59'";
    $consulta_fecha4 = "AND FECHA_ENVIO BETWEEN '".$fecha."T00:00:00' AND '".$fecha2."T23:59:59'";
    $consulta_fecha5 = "AND FECHA_RECEPCION BETWEEN '".$fecha."T00:00:00' AND '".$fecha2."T23:59:59'";
}
else{
    $consulta_fecha1 = "";
    $consulta_fecha2 = "";
    $consulta_fecha3 = "";
    $consulta_fecha4 = "";
    $consulta_fecha5 = "";
}

if($almacen != -1){
    $consulta_almacen1 = "AND CODALMACEN = '$almacen'";
    $consulta_almacen2 = "AND CODIGO_ALMACEN = '$almacen'";
    $consulta_almacen3 = "AND CODIGO_ALMACEN <> '$almacen'";
}
else{ 
    $consulta_almacen1 = "AND CODALMACEN IN('C1','C2','C3','C4','C5','C6','C7','B1','B2','B3','B4','B5','B6','B7','B8','BA','BB','N1','N2','N3','E1','OAT','OTC','B9','PQ1')";
    $consulta_almacen2 = "AND CODIGO_ALMACEN IN('C1','C2','C3','C4','C5','C6','C7','B1','B2','B3','B4','B5','B6','B7','B8','BA','BB','N1','N2','N3','E1','A11','PQ1')";
    $consulta_almacen3 = "AND CODIGO_ALMACEN NOT IN('C1','C2','C3','C4','C5','C6','C7','B1','B2','B3','B4','B5','B6','B7','B8','BA','BB','N1','N2','N3','E1','A11','PQ1')";
}
 
   
    $sql = "SELECT 
                S.REFERENCIA,
                REPLACE(S.COLOR,' ','') AS COLOR,
                S.ARTICULO,
                (S.PVP * 1.15) AS PVP,
                S.FAMILIA,
                S.LINEA,
                S.TEMPORADA,
                S.CODFAB,
                (SELECT SUM(UNIDADESTOTAL) AS Expr1 FROM dbo.VIEW_AC AS T1 WHERE 1=1 AND FECHAALBARAN > convert(datetime,(SELECT MIN(FECHAALBARAN) FROM dbo.VIEW_AC AS T1 WHERE REFERENCIA = S.REFERENCIA AND COLOR = S.COLOR AND NUMSERIE IN ('ACAC','ACF','ACI','ACA','A') $consulta_referencia $consulta_color $consulta_marca )) $consulta_referencia $consulta_color $consulta_marca AND (REFERENCIA = S.REFERENCIA AND COLOR = S.COLOR) AND NUMSERIE IN ('ACAC','ACF','ACI','ACA','A') AND ESDEVOLUCION = 'F' AND (NUMALBARAN != 77)) AS UNIDADES_ENTRANTES,
                (SELECT SUM(UNIDADESTOTAL) AS Expr1 FROM dbo.VIEW_AV AS T1 WHERE 1=1 $consulta_referencia $consulta_color $consulta_marca $consulta_fecha2 AND (REFERENCIA = S.REFERENCIA AND COLOR = S.COLOR) AND FACTURADO = 'T' $consulta_almacen1) AS UNIDADES_VENDIDAS,
                (SELECT SUM(STOCK) FROM V_STOCK_CON_DETALLE WHERE REFERENCIA = S.REFERENCIA AND COLOR = S.COLOR $consulta_referencia $consulta_color $consulta_almacen2) AS STOCK_ACTUAL,
                (SELECT SUM(STOCK) FROM V_STOCK_CON_DETALLE WHERE REFERENCIA = S.REFERENCIA AND COLOR = S.COLOR $consulta_referencia $consulta_color $consulta_almacen3) AS STOCK_OTROS,
                convert(datetime,(SELECT MAX(FECHAALBARAN) FROM dbo.VIEW_AC AS T1 WHERE REFERENCIA = S.REFERENCIA AND COLOR = S.COLOR AND NUMSERIE IN ('ACAC','ACF','ACI','ACA','A') $consulta_referencia $consulta_color)) AS FECHA_ULT_COMPRA,
                convert(datetime,(SELECT MIN(FECHAALBARAN) FROM dbo.VIEW_AC AS T1 WHERE REFERENCIA = S.REFERENCIA AND COLOR = S.COLOR AND NUMSERIE IN ('ACAC','ACF','ACI','ACA','A') $consulta_referencia $consulta_color)) AS FECHA_PRI_COMPRA,
                (SELECT SUM(UNIDADESTOTAL) AS EXPR1 FROM dbo.VIEW_AC AS T1 WHERE 1=1 $consulta_referencia $consulta_color $consulta_marca AND REFERENCIA = S.REFERENCIA AND COLOR = S.COLOR AND ESDEVOLUCION = 'F' AND NUMSERIE IN ('ACAC','ACF','ACI','ACA','A') AND T1.FECHAALBARAN = convert(datetime,(SELECT MIN(FECHAALBARAN) FROM dbo.VIEW_AC AS T1 WHERE REFERENCIA = S.REFERENCIA AND COLOR = S.COLOR AND NUMSERIE IN ('ACAC','ACF','ACI','ACA','A') $consulta_referencia $consulta_color $consulta_marca ))) AS PRIMERA_COMPRA
            FROM 
                dbo.V_STOCK_CON_DETALLE AS S 
            WHERE 
                1=1 AND
                (S.ARTICULO NOT LIKE '%PARCHE%' AND S.ARTICULO NOT LIKE '%PINE%')
                $consulta_referencia
                $consulta_color
                $consulta_marca
                $consulta_coleccion
                $consulta_anio
                $consulta_ciclo
                $consulta_familia
            GROUP BY
                S.REFERENCIA,
                S.COLOR,
                S.ARTICULO,
                S.PVP,
                S.FAMILIA,
                S.LINEA,
                S.TEMPORADA,
                S.CODFAB
                $consulta_marca2
            ORDER BY 
                S.REFERENCIA, S.COLOR ";

    $res=sqlsrv_query($conn,$sql);	

    echo $sql;

?>

<table class="table striped table-border mt-4 compact" data-role="table"
        id="tabla"
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
        <th class="sortable-column">SKU</th>
        <th class="sortable-column">REF</th>
        <th class="sortable-column">DESCRIP.</th>
        <th class="sortable-column">FAM.</th>
        <th class="sortable-column">COL</th>
        <th class="sortable-column">AÑO</th>
        <th class="sortable-column">CICLO</th>
        <th class="sortable-column">PVP</th>
        <th class="sortable-column">PRI. COM</th>
        <th class="sortable-column">ULT. COM</th>
        <th class="sortable-column">STOCK INI</th>
        <th class="sortable-column">COMPRAS</th>
        <th class="sortable-column">VENTAS</th>
        <th class="sortable-column sort-desc">STOCK FI</th>
        <th class="sortable-column">STOCK OTROS</th>
        <th class="sortable-column">ROTACION SR</th>
       <!--<th class="sortable-column">ROTACION R</th>-->
        <th class="sortable-column">ROTACION CR</th>
    </tr>
    </thead>

    <tbody>
    <?php 
        $actual = 0;
        $compras = 0;
        $ventas = 0;
        $rotacion = 0;
        $rotacion2 = 0;
        $rotacion3 = 0;

        $sumaactual = 0;
        $sumacompras = 0;
        $sumaventas = 0;
        $sumainicial = 0;
        

        while($row=sqlsrv_fetch_array($res)) { 
            $actual = $row["STOCK_ACTUAL"];
            $compras = $row["UNIDADES_ENTRANTES"];
            $ventas = $row["UNIDADES_VENDIDAS"];
            $ini = $row["PRIMERA_COMPRA"];
            //$salientes = $row["UNIDADES_SALIENTES"];
            //$inicial = $actual+$ventas-$compras;
            $inicial = $ini;
            $sumainicial+= $inicial; 

            //echo $inicial;

            //echo "C: ".$compras." - V: ".$ventas." - A: ".$actual." - I:".$inicial;
            if(($inicial+$compras) > 0){
                if(($inicial+$compras) > 0){
                    //$rotacion = number_format(($ventas/($inicial+$compras))*100,2,',',''); //ROTACION CON REPOSICION
                    $rotacion = number_format(($ventas/($inicial))*100,2,',','');
                    //$rotacion2 = number_format(($ventas/($compras))*100,2,',','');
                    $rotacion3 = number_format(($ventas/($inicial+$compras))*100,2,',','');
                }
                else{
                    $rotacion = 0;
                    //$rotacion2 = 0;
                    $rotacion3 = 0;
                }
                
                if($rotacion < 10){
                    $rotacion = "0".$rotacion." %";
                    //$rotacion2 = "0".$rotacion2." %";
                    $rotacion3 = "0".$rotacion3." %";
                }
                else{
                    $rotacion = $rotacion." %";
                    //$rotacion2 = $rotacion2." %";
                    $rotacion3 = $rotacion3." %";
                }
            }
            else{
                $rotacion = "-";
                //$rotacion2 = "-";
                $rotacion3 = "-";
            }

            $ceroc = "";
            $cerov = "";
            $ceroa = "";
            $ceroi = "";

            if($compras >= 0 && $compras < 10){
                $ceroc = "000";
            }
            if($compras >= 10 && $compras < 100){
                $ceroc = "00";
            }
            if($compras >= 100 && $compras < 1000){
                $ceroc = "0";
            }

            if($ventas >= 0 && $ventas < 10){
                $cerov = "000";
            }
            if($ventas >= 10 && $ventas < 100){
                $cerov = "00";
            }
            if($ventas >= 100 && $ventas < 1000){
                $cerov = "0";
            }

            if($actual >= 0 && $actual < 10){
                $ceroa = "000";
            }
            if($actual >= 10 && $actual < 100){
                $ceroa = "00";
            }
            if($actual >= 100 && $actual < 1000){
                $ceroa = "0";
            }

            if($inicial >= 0 && $inicial < 10){
                $ceroi = "000";
            }
            if($inicial >= 10 && $inicial < 100){
                $ceroi = "00";
            }
            if($inicial >= 100 && $inicial < 1000){
                $ceroi = "0";
            }
            
            //if($row["STOCK_ACTUAL"] > 0){
                $sumaactual+= $row["STOCK_ACTUAL"];
                $sumacompras+= $row["UNIDADES_ENTRANTES"];
                $sumaventas+= $row["UNIDADES_VENDIDAS"];

            $sql_detalle_almacen = "SELECT STOCK, ALMACEN FROM V_STOCK_CON_DETALLE WHERE REFERENCIA = '".$row["REFERENCIA"]."' AND COLOR = '".$row["COLOR"]."' AND CODIGO_ALMACEN IN('B1','B2','B3','B4','B5','B6','C1','C2','C3','C4','C5','C6','N1','E1')";
            $res2=sqlsrv_query($conn,$sql_detalle_almacen);	
    ?>
    <tr>
        <td><?php echo trim($row["REFERENCIA"].$row["COLOR"])?></td>
        <td><?php echo trim($row["REFERENCIA"])?></td>
        <td><?php echo $row["ARTICULO"]?></td>
        <td><?php echo $row["FAMILIA"]?></td>
        <td><?php echo $row["LINEA"]?></td>
        <td><?php echo $row["TEMPORADA"]?></td>
        <td><?php echo $row["CODFAB"]?></td>
        <td><?php echo number_format($row["PVP"],2,',','.')?></td>
        <?php if(is_null($row["FECHA_PRI_COMPRA"])){?>
        <td><?php echo '1989-01-01';?></td>
        <?php }else{ ?>
        <td><?php echo date_format($row["FECHA_PRI_COMPRA"],'Y-m-d');?></td>
        <?php } ?>
        <?php if(is_null($row["FECHA_ULT_COMPRA"])){?>
        <td><?php echo '1989-01-01';?></td>
        <?php }else{ ?>
        <td><?php echo date_format($row["FECHA_PRI_COMPRA"],'Y-m-d');?></td>
        <?php } ?>
        <td><?php if($inicial >= 0){ echo $ceroi.number_format($inicial,0,',',''); } else{ echo $ceroi."0"; }?></td>
        <td><?php echo $ceroc.$row["UNIDADES_ENTRANTES"]?></td>
        <td><?php echo $cerov.$row["UNIDADES_VENDIDAS"]?></td>
        <td><?php echo $ceroa.number_format($row["STOCK_ACTUAL"],0,',','')?></td>
        <td><?php echo $ceroa.number_format($row["STOCK_OTROS"],0,',','')?></td>
        <td><?php echo $rotacion?></td>
        <!--<td><?php echo $rotacion2?></td>-->
        <td><?php echo $rotacion3?></td> 
    </tr>
    <?php
        }//}
    ?>
    </tbody>
    <tfoot>
        <th colspan="9">TOTALES:</th>
        <th><?php echo number_format($sumainicial,0,',','');?></th>
        <th><?php echo $sumacompras;?></th>
        <th><?php echo $sumaventas;?></th>
        <th><?php echo number_format($sumaactual,0,',','');?></th>
        <!--<th><?php echo number_format(($sumaventas/($sumainicial+$sumacompras))*100,2,',','')."%";?></th> ROTACION CON REPOSICION-->
        <th><?php echo number_format(($sumaventas/($sumainicial))*100,2,',','')."%";?></th>
        <!--<th><?php echo number_format(($sumaventas/($sumacompras))*100,2,',','')."%";?></th>-->
        <th><?php echo number_format(($sumaventas/($sumainicial+$sumacompras))*100,2,',','')."%";?></th>
    </tfoot>
    
</table>