<?PHP
header("Content-Type: text/html;charset=utf-8");
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

    $sql_uno="SELECT count(distinct numero_documento),vendedor,almacen from v_ventas_por_vendedor_unidades_new where fecha between '".$inicio."T00:00:00' and '".$fin."T23:59:59' $filtro_tienda $consulta_almacen group by vendedor,almacen order by almacen, vendedor";
    $res_uno=sqlsrv_query($conn,$sql_uno);

    //echo $sql_uno; 
    //$consulta_descripcion 

?>

<table class="table compact table-border striped">
    <tr class="flex-content-center flex-wrap">
        <th>ALMACEN</th>
        <th>VENDEDOR</th>
        <th>1 UNIDAD</th>
        <th>2 UNIDADES</th>
        <th>3 UNIDADES</th>
        <th>4 UNIDADES</th>
        <th>5+ UNIDADES</th>
        <th>TOTAL</th>
    </tr>
    <?php
        $suma1 = 0;
        $suma2 = 0;
        $suma3 = 0;
        $suma4 = 0;
        $suma5 = 0;

        $uno = 0;
        $dos = 0;
        $tres = 0;
        $cuatro = 0;
        $mas = 0;
        while($row=sqlsrv_fetch_array($res_uno)) {
            $almacen = $row["almacen"];
            $vendedor = $row["vendedor"];
            //$una_unidad = $row["una_unidad"];


            $sql1 = "SELECT count(distinct numero_documento) as una_unidad,vendedor,almacen from v_ventas_por_vendedor_unidades_new where fecha between '".$inicio."T00:00:00' and '".$fin."T23:59:59' AND unidades_vendidas = 1 AND vendedor = '$vendedor' group by vendedor,almacen order by almacen, vendedor";
            $res1=sqlsrv_query($conn,$sql1);
            while($row=sqlsrv_fetch_array($res1)) {
                $uno = $row["una_unidad"];
            }
            //echo $sql1."<br>";

            $sql2 = "SELECT count(distinct numero_documento) as dos_unidades,vendedor,almacen from v_ventas_por_vendedor_unidades_new where fecha between '".$inicio."T00:00:00' and '".$fin."T23:59:59' AND unidades_vendidas = 2 AND vendedor = '$vendedor' group by vendedor,almacen order by almacen, vendedor";
            $res2=sqlsrv_query($conn,$sql2);
            while($row=sqlsrv_fetch_array($res2)) {
                $dos = $row["dos_unidades"];
            }
           // echo $sql2;

            $sql3 = "SELECT count(distinct numero_documento) as tres_unidades,vendedor,almacen from v_ventas_por_vendedor_unidades_new where fecha between '".$inicio."T00:00:00' and '".$fin."T23:59:59' AND unidades_vendidas = 3 AND vendedor = '$vendedor' group by vendedor,almacen order by almacen, vendedor";
            $res3=sqlsrv_query($conn,$sql3);
            while($row=sqlsrv_fetch_array($res3)) {
                $tres = $row["tres_unidades"];
            }
            //echo $sql3;

            $sql4 = "SELECT count(distinct numero_documento) as cuatro_unidades,vendedor,almacen from v_ventas_por_vendedor_unidades_new where fecha between '".$inicio."T00:00:00' and '".$fin."T23:59:59' AND unidades_vendidas = 4 AND vendedor = '$vendedor' group by vendedor,almacen order by almacen, vendedor";
            $res4=sqlsrv_query($conn,$sql4);
            while($row=sqlsrv_fetch_array($res4)) {
                $cuatro = $row["cuatro_unidades"];
            }
            //echo $sql4;

            $sql5 = "SELECT count(distinct numero_documento) as mas_unidades,vendedor,almacen from v_ventas_por_vendedor_unidades_new where fecha between '".$inicio."T00:00:00' and '".$fin."T23:59:59' AND unidades_vendidas >= 5 AND vendedor = '$vendedor' group by vendedor,almacen order by almacen, vendedor";
            $res5=sqlsrv_query($conn,$sql5);
            while($row=sqlsrv_fetch_array($res5)) {
                $mas = $row["mas_unidades"];
            }
            //echo $sql4;

            $total = ($uno+$dos+$tres+$cuatro+$mas);

            $suma1+= $uno;
            $suma2+= $dos;
            $suma3+= $tres;
            $suma4+= $cuatro;
            $suma5+= $mas;

    ?>
    <tr>
    <td><?php echo $almacen;?></td>
    <td><?php echo utf8_encode($vendedor);?></td>
    <td style="text-align:center;"><?php echo $uno;?></td>
    <td style="text-align:center;"><?php echo $dos;?></td>
    <td style="text-align:center;"><?php echo $tres;?></td>
    <td style="text-align:center;"><?php echo $cuatro;?></td>
    <td style="text-align:center;"><?php echo $mas;?></td>
    <td style="text-align:center;"><?php echo $total;?></td>
    </tr>
    <?php 
        $uno = 0;
        $dos = 0;
        $tres = 0;
        $cuatro = 0;
        $mas = 0;
        $total = 0;

        } 
        $suma6 = $suma1+$suma2+$suma3+$suma4+$suma5;
        $por1 = ($suma1/$suma6)*100;
        $por2 = ($suma2/$suma6)*100;
        $por3 = ($suma3/$suma6)*100;
        $por4 = ($suma4/$suma6)*100;
        $por5 = ($suma5/$suma6)*100;

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
        <th><?php echo $suma1;?></th>
        <th><?php echo $suma2;?></th>
        <th><?php echo $suma3;?></th>
        <th><?php echo $suma4;?></th>
        <th><?php echo $suma5;?></th>
        <th><?php echo $suma6;?></th>
    </tr>
    <tr>
        <th colspan="2">PORCENTAJE</th>
        <th><?php echo number_format($por1,2,',','.');?>%</th>
        <th class="<?php echo $color;?>"><?php echo number_format($por2,2,',','.');?>%</th>
        <th><?php echo number_format($por3,2,',','.');?>%</th>
        <th><?php echo number_format($por4,2,',','.');?>%</th>
        <th><?php echo number_format($por5,2,',','.');?>%</th>
        <th>100%</th>
    </tr>
</table>