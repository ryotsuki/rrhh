<?PHP
header("Pragma: public");
header("Expires: 0");
$filename = "rotacion_silueta.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../conexion/conexion.php");
ini_set('max_execution_time', '0'); 
//include("../validacion/validacion.php");
$conn = conectate2();

$referencia = strtoupper($_GET["referencia"]);
$fecha = $_GET["fecha"];
$fecha2 = $_GET["fecha2"];
$almacen = $_GET["almacen"];
$marca = $_GET["marca"];
$anio = $_GET["anio"];
$coleccion = $_GET["coleccion"];
$ciclo = $_GET["ciclo"];
$familia = $_GET["familia"];

if($referencia != ""){
    $consulta_referencia = "AND SILUETA = '$referencia'";
}
else{
    $consulta_referencia = "";
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
}
else{
    $consulta_fecha1 = "";
    $consulta_fecha2 = "";
    $consulta_fecha3 = "";
}

// if($almacen != -1){
//     $consulta_almacen1 = "AND CODALMACEN = '$almacen'";
//     $consulta_almacen2 = "AND CODIGO_ALMACEN = '$almacen'";
// }
// else{
//     $consulta_almacen1 = "AND CODALMACEN IN('C1','C2','C3','C4','C5','C6','B1','B2','B3','B4','B5','B6','N1','E1')";
//     $consulta_almacen2 = "AND CODIGO_ALMACEN IN('C1','C2','C3','C4','C5','C6','B1','B2','B3','B4','B5','B6','N1','E1')";
// }
if($almacen == 1){
    $consulta_almacen1 = "AND CODALMACEN IN('B1','B2','B3','B4','B5','B6','E1')";
    $consulta_almacen2 = "AND CODIGO_ALMACEN IN('B1','B2','B3','B4','B5','B6','E1')";
    $serie = "'B11A','B21A','B31A','B41A','B51A','B61A','B71A','N11A','E11A'";
    $filtro_mayor = "AND S.ALMACEN NOT LIKE '%MAYORISTA%'";
    $sualbaran = "AND SUALBARAN LIKE '%.AVG%'";
}
if($almacen == 2){
    $consulta_almacen1 = "AND CODALMACEN = 'N1'";
    $consulta_almacen2 = "AND CODIGO_ALMACEN = 'N1'";
    $serie = "'B11A','B21A','B31A','B41A','B51A','B61A','B71A','N11A','E11A'";
    $filtro_mayor = "AND S.ALMACEN NOT LIKE '%MAYORISTA%'";
    $sualbaran = "AND SUALBARAN LIKE '%.AVG%'";
}
if($almacen == -1){
    $consulta_almacen1 = "AND CODALMACEN IN('B1','B2','B3','B4','B5','B6','N1','E1')";
    $consulta_almacen2 = "AND CODIGO_ALMACEN IN('B1','B2','B3','B4','B5','B6','N1','E1')";
    $serie = "'B11A','B21A','B31A','B41A','B51A','B61A','B71A','N11A','E11A'";
    $filtro_mayor = "AND S.ALMACEN NOT LIKE '%MAYORISTA%'";
    $sualbaran = "AND SUALBARAN LIKE '%.AVG%'";
}
if($almacen == 3){
    $consulta_almacen1 = "AND CODALMACEN IN ('A6','A1')";
    $consulta_almacen2 = "AND CODIGO_ALMACEN = 'A6'";
    $serie = "'A','AC','ACA','ACAC','ACF','ACI'";
    $filtro_mayor = "";
    $sualbaran = "";
}


 //echo $consulta_almacen1;  
    $sql = "SELECT 
                S.SILUETA, 
                --S.CODFAB,  
                (SELECT SUM(UNIDADESTOTAL) AS Expr1 FROM dbo.VIEW_AC AS T1 WHERE 1=1 AND FECHAALBARAN > CONVERT(VARCHAR,(SELECT MIN(FECHAALBARAN) FROM dbo.VIEW_AC AS T1 WHERE  S.SILUETA = SILUETA AND (NUMSERIE IN ($serie) $sualbaran) $consulta_referencia  $consulta_marca $consulta_almacen1 ),103) $consulta_referencia  $consulta_marca $consulta_almacen1 AND  S.SILUETA = SILUETA AND (NUMSERIE IN ($serie) $sualbaran) AND ESDEVOLUCION = 'F') AS UNIDADES_ENTRANTES,
                (SELECT SUM(UNIDADESTOTAL) AS Expr1 FROM dbo.VIEW_AV AS T1 WHERE 1=1 $consulta_referencia  $consulta_marca $consulta_fecha2 AND  S.SILUETA = SILUETA AND FACTURADO = 'T' $consulta_almacen1) AS UNIDADES_VENDIDAS,
                (SELECT SUM(STOCK) FROM V_STOCK_CON_DETALLE WHERE  S.SILUETA = SILUETA $consulta_referencia  $consulta_almacen2) AS STOCK_ACTUAL,
                CONVERT(VARCHAR,(SELECT MAX(FECHAALBARAN) FROM dbo.VIEW_AC AS T1 WHERE  S.SILUETA = SILUETA AND (NUMSERIE IN ($serie) $sualbaran) $consulta_referencia ),103) AS FECHA_ULT_COMPRA,
                CONVERT(VARCHAR,(SELECT MIN(FECHAALBARAN) FROM dbo.VIEW_AC AS T1 WHERE  S.SILUETA = SILUETA AND (NUMSERIE IN ($serie) $sualbaran) $consulta_referencia ),103) AS FECHA_PRI_COMPRA,
                (SELECT SUM(UNIDADESTOTAL) AS EXPR1 FROM dbo.VIEW_AC AS T1 WHERE 1=1 $consulta_referencia  $consulta_marca $consulta_almacen1 AND  S.SILUETA = SILUETA AND ESDEVOLUCION = 'F' AND (NUMSERIE IN ($serie) $sualbaran) AND T1.FECHAALBARAN = CONVERT(VARCHAR,(SELECT MIN(FECHAALBARAN) FROM dbo.VIEW_AC AS T1 WHERE  S.SILUETA = SILUETA AND (NUMSERIE IN ($serie) $sualbaran) $consulta_referencia  $consulta_marca $consulta_almacen1 ),103)) AS PRIMERA_COMPRA,
                (SELECT SUM(UNIDADESTOTAL) AS Expr1 FROM dbo.VIEW_AC AS T1 WHERE 1=1 AND FECHAALBARAN > CONVERT(VARCHAR,(SELECT MIN(FECHAALBARAN) FROM dbo.VIEW_AC AS T1 WHERE  S.SILUETA = SILUETA AND (NUMSERIE IN ($serie) AND SUALBARAN LIKE '%BAL%') $consulta_referencia  $consulta_marca $consulta_almacen1 ),103) $consulta_referencia  $consulta_marca $consulta_almacen1 AND  S.SILUETA = SILUETA AND (NUMSERIE IN ($serie) AND SUALBARAN LIKE '%BAL%')) AS BALANCEOS,
                (SELECT SUM(CANTIDAD) AS UNIDADES FROM [CADILAC_ICG].[dbo].MOVIMIENTOS2 WHERE TIPO_MOVIMIENTO = 'TRASPASO' AND ALMACEN_RECIBE IN('B1','B2','B3','B4','B5','B6','E1','N1') AND ALMACEN_ENVIA IN('B1','B2','B3','B4','B5','B6','E1','N1') $consulta_referencia  $consulta_marca AND FECHA_ENVIO > CONVERT(VARCHAR,(SELECT MIN(FECHA_ENVIO) FROM [CADILAC_ICG].[dbo].MOVIMIENTOS2 WHERE TIPO_MOVIMIENTO = 'TRASPASO' AND ALMACEN_RECIBE IN('B1','B2','B3','B4','B5','B6','E1','N1') AND ALMACEN_ENVIA IN('B1','B2','B3','B4','B5','B6','E1','N1') $consulta_referencia  $consulta_marca ),103)) AS TRASPASOS                
            FROM 
                dbo.V_STOCK_CON_DETALLE AS S 
            WHERE 
                1=1 AND
                (S.ARTICULO NOT LIKE '%PARCHE%' AND S.ARTICULO NOT LIKE '%PINE%') 
                $filtro_mayor
                AND S.ALMACEN NOT LIKE '%CENTRAL%'
                $consulta_almacen2
                $consulta_referencia
                $consulta_marca
                $consulta_coleccion
                $consulta_anio
                $consulta_ciclo
                $consulta_familia
            GROUP BY 
                S.SILUETA--, 
                --S.CODFAB
                $consulta_marca2
            ORDER BY  
                S.SILUETA ";

    $res=sqlsrv_query($conn,$sql);	

    //echo "<BR>".$sql;
    //echo $fecha2;

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
        <th class="sortable-column">SILUETA</th>
        <!--<th class="sortable-column">CICLO</th>-->
        <th class="sortable-column">PRI. COMPRA</th>
        <th class="sortable-column">ULT. COMPRA</th>
        <th class="sortable-column">STOCK INICIAL</th>
        <th class="sortable-column">COMPRAS</th>
        <th class="sortable-column">VENTAS</th>
        <th class="sortable-column sort-desc">STOCK FINAL</th>
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
            $compras = $row["UNIDADES_ENTRANTES"] + $row["BALANCEOS"] + $row["TRASPASOS"];
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
                    if($inicial > 0){
                        $rotacion = number_format(($ventas/($inicial))*100,2,',','');
                    }
                    else{
                        $rotacion = number_format(($ventas/(1))*100,2,',','');
                    }
                    //$rotacion = number_format(($ventas/($inicial))*100,2,',','');
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

                
    ?>
    <tr>
        <td><?php echo $row["SILUETA"]?></td>
        <!--<td><?php echo $row["CODFAB"]?></td>-->
        <td><?php echo $row["FECHA_PRI_COMPRA"]?></td>
        <td><?php echo $row["FECHA_ULT_COMPRA"]?></td>
        <td><?php if($inicial >= 0){ echo $ceroi.number_format($inicial,0,',',''); } else{ echo $ceroi."0"; }?></td>
        <td><?php echo $ceroc.$row["UNIDADES_ENTRANTES"]?></td>
        <td><?php echo $cerov.$row["UNIDADES_VENDIDAS"]?></td>
        <td><?php echo $ceroa.number_format($row["STOCK_ACTUAL"],0,',','')?></td>
        <td><?php echo $rotacion?></td>
        <!--<td><?php echo $rotacion2?></td>-->
        <td><?php echo $rotacion3?></td>
    </tr>
    <?php
        }//}
    ?>
    </tbody> 
    <tfoot>
        <th colspan="4">TOTALES:</th>
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