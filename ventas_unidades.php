

<?php
    ini_set('display_errors', 'Off');
    include("conexion/conexion.php");
    
    session_start();
    $username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
    //echo "Username: ".$username;

    $mes = "";
    $anio = "";
    $filtro_tienda = "AND ALMACEN LIKE 'CH %' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE 'SIE%' OR ALMACEN LIKE 'NEW%'";

    $conn = conectate();

    if(strpos($username, "CH ") !== false) {
        $filtro_tienda = "AND ALMACEN = '$username'";
    }
    if(strpos($username, "SIE") !== false || strpos($username, "SUR") !== false) {
        $filtro_tienda = "AND ALMACEN = '$username'";
    }
    if(strpos($username, "NEW") !== false) {
        $filtro_tienda = "AND ALMACEN = '$username'";
    }

    $consulta_almacenes = "SELECT DISTINCT ALMACEN FROM VENTAS WHERE 1=1 $filtro_tienda ORDER BY ALMACEN";
    $res_almacen=sqlsrv_query($conn,$consulta_almacenes);
    
    $consulta_almacenes2 = "SELECT DISTINCT ALMACEN FROM VENTAS WHERE 1=1 $filtro_tienda ORDER BY ALMACEN";
    $res_almacen2=sqlsrv_query($conn,$consulta_almacenes2);

    $consulta_almacenes3 = "SELECT DISTINCT ALMACEN FROM VENTAS WHERE 1=1 $filtro_tienda ORDER BY ALMACEN";
    $res_almacen3=sqlsrv_query($conn,$consulta_almacenes3);
    //echo $consulta_almacenes;
    //CALCULO DE DIA, MES Y AÑO
	include("datos/dias_meses_anios.php");
	//-------------------
?>

<script>
    function calcular(){
        var mes = $("#cbo_mes").val();
        var anio = $("#cbo_anio").val();

        $.post("dashboard2.php?mes="+mes+"&anio="+anio, function(htmlexterno){
            $('#datos').fadeOut('slow');
            $('#datos').fadeIn('slow');
            $("#datos").html(htmlexterno);
        });
    }

    function recalcular_unidades(){
        var inicio = $("#txt_inicio").val();
        var fin = $("#txt_fin").val();
        var almacen = $("#cbo_almacen").val();

        $.post("datos/recalcular_unidades.php?inicio="+inicio+"&fin="+fin+"&almacen="+almacen, function(htmlexterno){
            $('#datos_unidades').fadeOut('slow');
            $('#datos_unidades').fadeIn('slow');
            $("#datos_unidades").html(htmlexterno);
        });
    }

    function recalcular_unidades_excel(){
        var inicio = $("#txt_inicio").val();
        var fin = $("#txt_fin").val();
        var almacen = $("#cbo_almacen").val();

        window.open("datos/recalcular_unidades_excel.php?inicio="+inicio+"&fin="+fin+"&almacen="+almacen, "_blank");
    }

    function recalcular_cs_descuento(){
        var inicio = $("#txt_inicio2").val();
        var fin = $("#txt_fin2").val();
        var almacen = $("#cbo_almacen2").val();

        $.post("datos/recalcular_cs_descuento.php?inicio="+inicio+"&fin="+fin+"&almacen="+almacen, function(htmlexterno){
            $('#datos_descuento').fadeOut('slow');
            $('#datos_descuento').fadeIn('slow');
            $("#datos_descuento").html(htmlexterno);
        });
    }

    function recalcular_bono(){
        var inicio = $("#txt_inicio3").val();
        var fin = $("#txt_fin3").val();
        var almacen = $("#cbo_almacen3").val();

        $.post("datos/recalcular_bono.php?inicio="+inicio+"&fin="+fin+"&almacen="+almacen, function(htmlexterno){
            $('#datos_bono').fadeOut('slow');
            $('#datos_bono').fadeIn('slow');
            $("#datos_bono").html(htmlexterno);
        });
    }
</script>

<body>
<div class="container">

    <div class="row border-bottom bd-lightGray m-3">
        <div class="cell-md-4 d-flex flex-align-center">
            <h3 class="dashboard-section-title  text-center text-left-md w-100">Novomode CP <small>Version 1.5</small></h3>
        </div>

        <div class="cell-md-8 d-flex flex-justify-center flex-justify-end-md flex-align-center">
            <ul class="breadcrumbs bg-transparent">
                <li class="page-item"><a href="#" class="page-link"><span class="mif-replay"></span></a></li>
                <li class="page-item"><a href="#" class="page-link">Ventas x unidades</a></li>
            </ul>
        </div>
    </div> 

    

    <div class="container" id="tabla_datos">
    <?php //if($correo_usuario == "programacion@novomode.ec" || $correo_usuario == "operaciones@novomode.ec"){?>
                    <div class="row">
                        <div class="cell"><input type="text" data-role="calendarpicker" data-prepend="Fecha desde:" data-size="280" id="txt_inicio"></div>
                        <div class="cell"><input type="text" data-role="calendarpicker" data-prepend="Fecha hasta:" data-size="280" id="txt_fin" value="<?php echo date("Y-m-d")?>"></div>
                        <div class="cell"><div>
                            <select data-prepend="Almacen:" data-role="select" id="cbo_almacen" multiple>
                            <?php while($row=sqlsrv_fetch_array($res_almacen)) { ?>
                            <option value="<?php echo $row["ALMACEN"]?>"><?php echo $row["ALMACEN"]?></option>
                            <?php } ?>
                            </select>
                        </div></div>
                        <div class="cell">
                            <button class="button primary cycle" onclick="recalcular_unidades();"><span class="mif-search"></span></button>
                            <button class="button success cycle" onclick="recalcular_unidades_excel();"><span class="mif-search"></span></button>
                        </div>
                    </div>
                <?php //} ?>

                <div class="container" id="datos_unidades">
                <table class="table compact table-border striped">
                    <tr class="flex-content-center flex-wrap">
                        <th>ALMACEN</th>
                        <th>VENDEDOR</th>
                        <th>1 UNIDAD</th>
                        <th>2 UNIDADES</th>
                        <th>3 UNIDADES</th>
                        <th>4+ UNIDADES</th>
                        <th>TOTAL</th>
                    </tr>
                    <?php
                        $suma1 = 0;
                        $suma2 = 0;
                        $suma3 = 0;
                        $suma4 = 0;

                        $an = date("Y");
                        $me = date("m");
                        $di = date("d");
                        while($row=sqlsrv_fetch_array($res_uno)) {
                            $almacen = $row["almacen"];
                            $vendedor = $row["vendedor"];
                            //$una_unidad = $row["una_unidad"];


                            $sql1 = "SELECT count(distinct numero_documento) as una_unidad,vendedor,almacen from v_ventas_por_vendedor_unidades_new where fecha between '".$an."-".$me."-".$di."T00:00:00' and GETDATE() AND unidades_vendidas = 1 AND vendedor = '$vendedor' group by vendedor,almacen order by almacen, vendedor";
                            $res1=sqlsrv_query($conn,$sql1);
                            while($row=sqlsrv_fetch_array($res1)) {
                                $uno = $row["una_unidad"];
                            }

                            $sql2 = "SELECT count(distinct numero_documento) as dos_unidades,vendedor,almacen from v_ventas_por_vendedor_unidades_new where fecha between '".$an."-".$me."-".$di."T00:00:00' and GETDATE() AND unidades_vendidas = 2 AND vendedor = '$vendedor' group by vendedor,almacen order by almacen, vendedor";
                            $res2=sqlsrv_query($conn,$sql2);
                            while($row=sqlsrv_fetch_array($res2)) {
                                $dos = $row["dos_unidades"];
                            }

                            $sql3 = "SELECT count(distinct numero_documento) as tres_unidades,vendedor,almacen from v_ventas_por_vendedor_unidades_new where fecha between '".$an."-".$me."-".$di."T00:00:00' and GETDATE() AND unidades_vendidas = 3 AND vendedor = '$vendedor' group by vendedor,almacen order by almacen, vendedor";
                            $res3=sqlsrv_query($conn,$sql3);
                            while($row=sqlsrv_fetch_array($res3)) {
                                $tres = $row["tres_unidades"];
                            }

                            $sql4 = "SELECT count(distinct numero_documento) as mas_unidades,vendedor,almacen from v_ventas_por_vendedor_unidades_new where fecha between '".$an."-".$me."-".$di."T00:00:00' and GETDATE() AND unidades_vendidas >= 4 AND vendedor = '$vendedor' group by vendedor,almacen order by almacen, vendedor";
                            $res4=sqlsrv_query($conn,$sql4);
                            while($row=sqlsrv_fetch_array($res4)) {
                                $mas = $row["mas_unidades"];
                            }

                            $total = ($uno+$dos+$tres+$mas);

                            $suma1+= $uno;
                            $suma2+= $dos;
                            $suma3+= $tres;
                            $suma4+= $mas;

                    ?>
                    <tr>
                    <td><?php echo $almacen;?></td>
                    <td><?php echo utf8_encode($vendedor);?></td>
                    <td style="text-align:center;"><?php if(is_nan($uno)){ echo "0"; }else{ echo $uno; }?></td>
                    <td style="text-align:center;"><?php if(is_nan($dos)){ echo "0"; }else{ echo $dos;}?></td>
                    <td style="text-align:center;"><?php if(is_nan($tres)){ echo "0"; }else{ echo $tres;}?></td>
                    <td style="text-align:center;"><?php if(is_nan($mas)){ echo "0"; }else{ $mas;}?></td>
                    <td style="text-align:center;"><?php echo $total;?></td>
                    </tr>
                    <?php 
                        $uno = 0;
                        $dos = 0;
                        $tres = 0;
                        $mas = 0;

                        } 
                        $suma5 = $suma1+$suma2+$suma3+$suma4;
                        $por1 = ($suma1/$suma5)*100;
                        $por2 = ($suma2/$suma5)*100;
                        $por3 = ($suma3/$suma5)*100;
                        $por4 = ($suma4/$suma5)*100;

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
                    </tr>
                    <tr>
                        <th colspan="2">PORCENTAJE</th>
                        <th><?php if(is_nan($por1)){ echo "0";}else{ echo number_format($por1,2,',','.');}?>%</th>
                        <th class="<?php echo $color;?>"><?php if(is_nan($por2)){ echo "0";}else{ echo number_format($por2,2,',','.');}?>%</th>
                        <th><?php if(is_nan($por3)){ echo "0";}else{ echo number_format($por3,2,',','.');}?>%</th>
                        <th><?php if(is_nan($por4)){ echo "0";}else{ echo number_format($por4,2,',','.');}?>%</th>
                        <th>100%</th>
                    </tr>
                </table>
                </div>
    </div>
</div>
</body>