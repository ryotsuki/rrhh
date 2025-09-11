<?PHP
ini_set('max_execution_time', '0');
header("Pragma: public");
header("Expires: 0");
$filename = "descuentos.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../conexion/conexion.php");
//include("../validacion/validacion.php");
session_start();
$conn = conectate();

$inicio = $_GET["inicio"];
$fin = $_GET["fin"];
$almacen = $_GET["almacen"];

$username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
$filtro_tienda = ""; 

$new_almacen = "'";
$new_almacen.= str_replace(",", "','", $almacen);
$new_almacen.= "'";

if(strpos($username, "CH") !== false) {
    $filtro_tienda = "AND ALMACEN = '$username'";
}
if(strpos($username, "SIE") !== false || strpos($username, "SUR") !== false) {
    $filtro_tienda = "AND ALMACEN = '$username'";
}
if(strpos($username, "NEW") !== false) {
    $filtro_tienda = "AND ALMACEN LIKE 'NEW%'";
}

if($almacen != ""){
    $consulta_almacen = "AND ALMACEN IN ($new_almacen)";
    $filtro_tienda = "";
}
else{
    $consulta_almacen = "";
}

    $sql_uno="SELECT count(distinct numero_documento),vendedor,almacen from v_ventas_por_vendedor_porcentaje where fecha between '".$inicio."T00:00:00' and '".$fin."T23:59:59' $filtro_tienda $consulta_almacen group by vendedor,almacen order by almacen, vendedor";
    $res_uno=sqlsrv_query($conn,$sql_uno);

    //echo $sql_uno; 
    //$consulta_descripcion 

?>

<table class="table compact table-border striped">
    <tr class="flex-content-center flex-wrap">
        <th>ALMACEN</th>
        <th>VENDEDOR</th>
        <th>FULL PRICE</th>
        <th>DESCUENTO</th>
        <th>TOTAL</th>
    </tr>
    <?php
        $suma1 = 0;
        $suma2 = 0;

        $uno = 0;
        $dos = 0;
        while($row=sqlsrv_fetch_array($res_uno)) {
            $almacen = $row["almacen"];
            $vendedor = $row["vendedor"];
            //$una_unidad = $row["una_unidad"];


            //$sql11 = "SELECT count(distinct numero_documento) as cd,vendedor,almacen from v_ventas_por_vendedor_porcentaje where fecha between '".$an."-".$me."-".$di."T00:00:00' and GETDATE() AND descuento = 0 AND vendedor = '$vendedor' group by vendedor,almacen order by almacen, vendedor";
            $sql11 = "SELECT 
                        sum(CANTIDAD_VTA) AS cd,
                        vendedor,
                        almacen
                    from 
                        ventas 
                    where 
                        fecha between '".$inicio."T00:00:00' and '".$fin."T23:59:59' AND
                        vendedor = '$vendedor' AND 
                        descuento > 0 AND
                        CANTIDAD_VTA > 0  AND
                        TIPO_DOCUMENTO = 'FACTURA'
                        $consulta_almacen
                    group by 
                        vendedor,almacen
                    order by 
                        almacen, vendedor";
            $res11=sqlsrv_query($conn,$sql11);
            //echo $sql11."<br>";
            while($row=sqlsrv_fetch_array($res11)) {
            $uno = $row["cd"];
            }

            //$sql22 = "SELECT count(distinct numero_documento) as sd,vendedor,almacen from v_ventas_por_vendedor_porcentaje where fecha between '".$an."-".$me."-".$di."T00:00:00' and GETDATE() AND descuento > 0 AND vendedor = '$vendedor' group by vendedor,almacen order by almacen, vendedor";
            $sql22 = "SELECT 
                        sum(CANTIDAD_VTA) AS sd,
                        vendedor,
                        almacen
                    from 
                        ventas 
                    where 
                        fecha between '".$inicio."T00:00:00' and '".$fin."T23:59:59' AND
                        vendedor = '$vendedor' AND 
                        descuento = 0 AND
                        CANTIDAD_VTA > 0 AND
                        TIPO_DOCUMENTO = 'FACTURA'
                        $consulta_almacen
                    group by 
                        vendedor,almacen
                    order by 
                        almacen, vendedor";
            $res22=sqlsrv_query($conn,$sql22);
            //echo $sql22."<br>";
            while($row=sqlsrv_fetch_array($res22)) {
                $dos = $row["sd"];
            }
           // echo $sql2;

            $total = ($uno+$dos);

            $suma1+= $uno;
            $suma2+= $dos;
            
            if($total != 0){
                $por11 = ($dos/$total)*100;
                $por22 = ($uno/$total)*100;
            }
            else{
                $por11 = ($dos/1)*100;
                $por22 = ($uno/1)*100;
            }
            

    ?>
    <tr>
    <td><?php echo $almacen;?></td>
    <td><?php echo utf8_encode($vendedor);?></td>
    <td style="text-align:center;"><?php echo number_format($dos,0,',','.')." - ".number_format($por11,2,',','.')."%";?></td>
    <td style="text-align:center;"><?php echo number_format($uno,0,',','.')." - ".number_format($por22,2,',','.')."%";?></td>
    <td style="text-align:center;"><?php echo $total;?></td>
    </tr>
    <?php 
        $uno = 0;
        $dos = 0;
        $total = 0;

        } 
        $suma5 = $suma1+$suma2;
        $por1 = ($suma1/$suma5)*100;
        $por2 = ($suma2/$suma5)*100;

        $color = "";
        if($por2 < $por1){
            $color = "fg-red";
        }
        else{
            $color = "fg-green";
        }
    ?>
    <tr>
        <th colspan="2">TOTALES</th>
        <th><?php echo $suma2;?></th>
        <th><?php echo $suma1;?></th>
        <th><?php echo $suma5;?></th>
    </tr>
    <tr>
        <th colspan="2">PORCENTAJE</th>
        <th class="<?php echo $color;?>"><?php echo number_format($por2,2,',','.');?>%</th>
        <th><?php echo number_format($por1,2,',','.');?>%</th>
        <th>100%</th>
    </tr>
</table>