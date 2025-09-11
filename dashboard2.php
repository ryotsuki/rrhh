<?php
    ini_set('display_errors', 'Off');
    include("conexion/conexion.php"); 

    $mes = $_GET["mes"];
    $anio = $_GET["anio"];

    $conn = conectate();
    //CALCULO DE DIA, MES Y AÑO
	include("datos/dias_meses_anios.php");
	//-------------------

    //VENTAS DE AÑO ACTUAL - MES ACTUAL - DIA ACTUAL
    include("datos/ventas_anio_actual.php");
    //----------------------

    //VENTAS DE AÑO ANTERIOR - MES ANTERIOR - DIA ANTERIOR
    include("datos/ventas_anio_anterior.php");
    //----------------------

    //CALCULO DE PORCENTAJES
    include("datos/calculo_porcentajes.php");
    //----------------------

    //CALCULO DE VENTAS X ALMACEN
    include("datos/ventas_x_almacen.php");
    //----------------------

    //GRAFICOS DE DONA
    include("datos/graficos_dona.php");
    //----------------------

    //TOP 8 VENDEDORES
    include("datos/top_vendedores.php");
    //----------------------

    //TODOS LOS VENDEDORES
    include("datos/todos_vendedores.php");
    //----------------------

    //PORCENTAJES DE CUMPLIMIENTO
    include("datos/porcentaje_cumplimiento.php");
    //----------------------
    
?>

<style>
    .modal-contenido{
    background-color:white;
    width:500px;
    padding: 10px 20px;
    margin: 20% auto;
    position: relative;
    }
    .modal{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    top:0;
    right:0;
    bottom:0;
    left:0;
    opacity:0;
    pointer-events:none;
    transition: all 1s;
    }
    #miModal:target{
    opacity:1;
    pointer-events:auto;
    }
</style>

<div id="datos">
<div data-role="panel" data-title-caption="GRAFICOS DE VENTAS" data-collapsible="true" data-title-icon="<span class='mif-chart-line'></span>" class="mt-4">
<div class="row">
    <div class="cell-lg-4 cell-md-6 mt-2">
        <div class="remark primary" style="align:center;">
            Ventas de todos los locales
        </div>
        <div id="grafico_ventas_mes" style="height: 250px;"></div>
        <div>
            <table class="table striped table-border mt-4">
                <tr style="text-align:center;">
                    <th>CHEVIGNON</th>
                    <th>SIETE</th>
                </tr>
                <tr>
                <?php while($row=sqlsrv_fetch_array($res_venta_por_franquicia)) { ?>
                    <td>$ <?php echo number_format($row["CHEVIGNON"],2,',','.')?></td>
                    <td>$ <?php echo number_format($row["SIETE"],2,',','.')?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="cell-lg-4 cell-md-6 mt-2">
        <div class="remark primary" style="align:center;">
            Ventas Chevignon
        </div>
        <div id="grafico_ventas_mes_chevignon" style="height: 250px;"></div>
        <div>
            <table class="table striped table-border mt-4">
                <tr style="text-align:center;">
                    <th>ALMACEN</th>
                    <th>MONTO</th>
                </tr>
                <tr>
                <?php while($row=sqlsrv_fetch_array($res_ventas_mes_chevignon)) { ?>
                    <td><?php echo $row["ALMACEN"]?></td>
                    <td>$ <?php echo number_format($row["VENTA_NETA"],2,',','.')?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="cell-lg-4 cell-md-6 mt-2">
        <div class="remark primary" style="align:center;">
            Ventas Sie7e
        </div>
        <div id="grafico_ventas_mes_siete" style="height: 250px;"></div>
        <div>
            <table class="table striped table-border mt-4">
                <tr style="text-align:center;">
                    <th>ALMACEN</th>
                    <th>MONTO</th>
                </tr>
                <tr>
                <?php while($row=sqlsrv_fetch_array($res_ventas_mes_siete)) { ?>
                    <td><?php echo $row["ALMACEN"]?></td>
                    <td>$ <?php echo number_format($row["VENTA_NETA"],2,',','.')?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</div>

<div data-role="panel" data-title-caption="VENTAS Y CUMPLIMIENTO DE METAS" data-collapsible="true" data-title-icon="<span class='mif-chart-line'></span>" class="mt-4">
    <div class="row">
        <div class="cell-md-8 p-10">
            <h5 class="text-center">Ventas por almacen</h5>
            <!--<canvas id="dashboardChart1"></canvas>-->
            <table class="table striped table-border mt-4" data-role="table"
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
                <tr class="bg-cyan fg-white">
                    <th>ALMACEN</th>
                    <th>UNIDADES</th>
                    <th>MONTO</th>
                </tr>
                </thead>

                <tbody>
                <?php 
                    $suma_venta = 0;
                    $suma_unidades = 0;
                    while($row1=sqlsrv_fetch_array($res_ventas_dia)) {
                         $suma_venta+= $row1["VENTA_NETA"];
                         $suma_unidades+= $row1["UNIDADES"];
                ?>
                <tr>
                    <td><?php echo $row1["ALMACEN"]?></td>
                    <td><?php echo number_format($row1["UNIDADES"],0,',','.')?></td>
                    <td><?php echo number_format($row1["VENTA_NETA"],2,',','.')?></td>
                </tr>
                <?php
                    } 
                ?>
                </tbody>

                <tfoot>
                    <tr class="bg-cyan fg-white">
                        <th>&nbsp;</th>
                        <th>TOTAL</th>
                        <th><?php echo number_format($suma_unidades,0,',','.')?></th>
                        <th><?php echo number_format($suma_venta,2,',','.')?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="cell-md-4 p-10">
            <h5 class="text-center">Cumplimiento de Metas</h5>
            <?php 
                $porcentaje_cumplimiento = 0;
                while($row=sqlsrv_fetch_array($res_consulta_porcentajes)) {
                    $porcentaje_cumplimiento = ($row["venta_neta"]/$row["monto_meta"]) * 100;
                    if($porcentaje_cumplimiento <= 25){
                        $color_cumplimiento = "bg-red";
                    }
                    if($porcentaje_cumplimiento > 25 && $porcentaje_cumplimiento <= 50){
                        $color_cumplimiento = "bg-orange";
                    }
                    if($porcentaje_cumplimiento > 50 && $porcentaje_cumplimiento < 90){
                        $color_cumplimiento = "bg-cyan";
                    }
                    if($porcentaje_cumplimiento >= 90){
                        $color_cumplimiento = "bg-green";
                    }
            ?>
                <div class="mt-6">
                    <div class="clear" data-role="hint" data-hint-text="<?php echo number_format($porcentaje_cumplimiento,2,',','.')?>%" data-cls-hint="<?php echo $color_cumplimiento?> fg-white drop-shadow">
                        <div class="place-left"><?php echo $row["ALMACEN"];?></div>
                        <div class="place-right"><strong><?php echo number_format($row["venta_neta"],2,',','.');?></strong>/<?php echo number_format($row["monto_meta"],2,',','.');?></div>
                    </div>
                    <div data-role="progress" data-value="<?php echo $porcentaje_cumplimiento?>" data-cls-bar="<?php echo $color_cumplimiento?>"></div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="cell-md-5">
        <div data-role="panel" data-title-caption="TRAFICO DEL DIA" data-collapsible="true" data-title-icon="<span class='mif-table'></span>" class="mt-4">
            <div class="p-4">
                <table class="table striped table-border mt-4" data-role="table"
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
                    <th>TIENDA</th>
                    <th>TRAFICO</th>
                </tr>  
                </thead> 
                <tbody>
                    <?php 
                        $total = 0;
                        while($row=sqlsrv_fetch_array($res_trafico)) { 
                            $total+=$row["trafico"];
                    ?>
                    <tr>
                        <td><?php echo $row["tienda"]?></td>
                        <td style="text-align:center;"><?php echo $row["trafico"]?></td>
                    </tr>
                    <?php } ?>
                </tbody> 
                <tfoot>
                    <tr>
                        <th>TOTAL</th>
                        <td style="text-align:center;"><?php echo $total?></td>
                    </tr>
                </tfoot>            
                </table>
            </div>
        </div>
    </div>

    <div class="cell-md-7">
        <div data-role="panel" data-title-caption="TOP VENDEDORES" data-collapsible="true" data-title-icon="<span class='mif-users'></span>" class="mt-4">
            <ul class="user-list">
                <?php 
                    $i = 1;
                    while($row=sqlsrv_fetch_array($res_top_vendedores)) {
                        $color = "#008b8b";
                        $texto = "";

                        if($i==1){
                            $color = "#D1B000";
                            $texto = "text-bold";
                        }
                        if($i==2){
                            $color = "#C0C0C0";
                            $texto = "text-bold";
                        }
                        if($i==3){
                            $color = "#b08d57";
                            $texto = "text-bold";
                        }
                ?>
                    <li>
                        <img src="images/ASESORES/<?php echo $row["VENDEDOR"]?>.jpeg" width="100px" height="128px" style="border-radius: 8px;border-width: 5px;border-style: solid;border-color: <?php echo $color;?>;">
                        <!--<img src="images/user1-128x128.jpg" class="avatar">-->
                        <div class="text-ellipsis"><?php echo utf8_encode($row["VENDEDOR"])?></div>
                        <div class="text-small <?php echo $texto;?>" style="color:<?php echo $color;?>">$<?php echo number_format($row["VENTA_NETA"],2,',','.')?></div>
                        <div class="text-bold"><?php echo utf8_encode($row["ALMACEN"])?></div>
                    </li>
                <?php
                    $i++; 
                    } 
                ?>
            </ul>
            <div class="p-2 border-top bd-default text-center">
                <a href="#miModal">Ver todos</a>
            </div>
            <div id="miModal" class="modal" style="overflow-y: scroll;">
            <div class="modal-contenido" style="overflow-y: scroll;">
                <a href="#">X</a>
                <h2>Todos los vendedores</h2>
                <p>
                    <table class="table striped table-border mt-4" data-role="table"
                            data-rownum="true"
                            data-search-min-length="3"
                            data-rows-steps="5,10"
                            data-table-rows-count-title="Mostrar:"
                            data-table-search-title="Buscar:"
                            data-table-info-title="Mostrando de $1 a $2 de $3 resultados"
                            data-pagination-prev-title="Ant"
                            data-pagination-next-title="Sig"
                    >
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Vendedor</th>
                            <th>Monto</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($row=sqlsrv_fetch_array($res_todos_vendedores)) {?>
                        <tr>
                            <td><img src="images/ASESORES/<?php echo $row["VENDEDOR"]?>.jpeg" width="100px" height="130px" class="avatar"></td>
                            <td><?php echo utf8_encode($row["VENDEDOR"])?></td>
                            <td>$ <?php echo number_format($row["VENTA_NETA"],2,',','.')?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </p>
            </div>  
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script src="./js/charts.js"></script>

<script>
    Morris.Donut({
        element : 'grafico_ventas_mes',
        data:[<?php echo $grafico_ventas_mes; ?>],
    });

    Morris.Donut({
        element : 'grafico_ventas_mes_siete',
        data:[<?php echo $grafico_ventas_mes_siete; ?>],
    });

    Morris.Donut({
        element : 'grafico_ventas_mes_chevignon',
        data:[<?php echo $grafico_ventas_mes_chevignon; ?>],
    });
</script>