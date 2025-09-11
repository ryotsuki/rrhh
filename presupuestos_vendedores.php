

<?php
    //ini_set('display_errors', 'Off');
    include("conexion/conexion.php");
    
    session_start();
    $username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
    //echo "Username: ".$username;

    //CALCULO DE DIA, MES Y AÑO
    include("datos/dias_meses_anios.php");
    //-------------------


    $mes = "";
    $anio = "";
    $filtro_tienda = "AND ALMACEN LIKE 'CH %' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE 'SIE%' OR ALMACEN LIKE 'NEW%'";

    $conn = conectate();
    $conn2 = conectate2();

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

    $codigoalmacen = "SELECT CODALMACEN FROM ALMACEN WHERE NOMBREALMACEN = '".trim($username)."'";
    $res_codigo = sqlsrv_query($conn2,$codigoalmacen);
    while($row=sqlsrv_fetch_array($res_codigo)) {
        $codalmacen = $row["CODALMACEN"];
    }

    $consulta_vendedores = "SELECT NOMVENDEDOR FROM VENDEDORES WHERE CODALMACEN = '".$codalmacen."' AND DESCATALOGADO = 'F'
    ORDER BY NOMVENDEDOR";
    $res_vendedores = sqlsrv_query($conn2,$consulta_vendedores);

    $consulta_metas = "SELECT * FROM METAS_VENDEDOR WHERE almacen_vendedor = '".trim($username)."' AND mes_meta_vendedor = $mes_actual AND anio_meta_vendedor = $anio_actual";
    $res_metas = sqlsrv_query($conn,$consulta_metas);

    //echo $codigoalmacen;
    //CALCULO DE DIA, MES Y AÑO
	include("datos/dias_meses_anios.php");
	//-------------------

    $correo_usuario = $_SESSION['user_email_address'];

$an = date("Y");
$me = date("m");
$di = date("d");

$filtro_tienda = ""; 

if(strpos($username, "CH") !== false) {
    $filtro_tienda = "AND ALMACEN = '$username'";
}
if(strpos($username, "SIE") !== false || strpos($username, "SUR") !== false) {
    $filtro_tienda = "AND ALMACEN = '$username'";
}
if(strpos($username, "NEW") !== false) {
    $filtro_tienda = "AND ALMACEN LIKE 'NEW%'";
}
 
    $sql_general="SELECT count(distinct numero_documento),vendedor,almacen from v_ventas_por_vendedor_porcentaje where fecha between '".$an."-".$me."-".$di."T00:00:00' and GETDATE() $filtro_tienda group by vendedor,almacen order by almacen, vendedor";
    $res_general=sqlsrv_query($conn,$sql_general);
    //echo $sql_uno;
?>

<script>
    function guardar_meta(){
        let fecha = $("#txt_fecha").val();
        //alert("En construccion");
        //return;
        const fecha2 = fecha.split("-");
        let anio = fecha2[0];
        let mes = fecha2[1];
        let almacen = $("#cbo_almacen2").val();
        let vendedor = $("#cbo_vendedor").val();
        let monto = $("#txt_monto").val();

        if(monto == '' || monto <= 0){
            Metro.infobox.create("<p><strong><h3>Debe colocar un monto valido.</h3></strong></p>", "alert");
            $("#txt_monto").val('');
            $("#txt_monto").focus();
            return;
        }
        //alert(fecha2[1]);
        //window.open("datos/guarda_meta_vendedor.php?anio="+anio+"&mes="+mes+"&almacen="+almacen+"&vendedor="+vendedor+"&monto="+monto, "_blank");
        $.post("datos/guarda_meta_vendedor.php?anio="+anio+"&mes="+mes+"&almacen="+almacen+"&vendedor="+vendedor+"&monto="+monto, function(htmlexterno){
            //$('#datos_metas').fadeOut('slow');
            //$('#datos_metas').fadeIn('slow');
            $("#datos_metas").html(htmlexterno);
        });

        Metro.infobox.create("<p><strong><h3>Meta cargada exitosamente.</h3></strong></p>", "success");
        $("#txt_monto").val('');
        $("#txt_monto").focus();
    }

    function recalcular_unidades_excel(){
        var inicio = $("#txt_inicio").val();
        var fin = $("#txt_fin").val();
        var almacen = $("#cbo_almacen").val();

        window.open("datos/recalcular_unidades_excel.php?inicio="+inicio+"&fin="+fin+"&almacen="+almacen, "_blank");
    }

    function excel(){
        var inicio = $("#txt_inicio2").val();
        var fin = $("#txt_fin2").val();
        var almacen = $("#cbo_almacen2").val();

        //alert(inicio+"-"+fin+"-"+almacen);
        //return;

        window.open("datos/recalcular_descuento_excel.php?inicio="+inicio+"&fin="+fin+"&almacen="+almacen, "_blank");
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

    $(document).ready(function(){
        $("#cbo_almacen2").on('change', function () {
            $("#cbo_almacen2 option:selected").each(function () {
                almacenelegido=$(this).val();
                $.post("datos/buscavendedores.php", { almacenelegido: almacenelegido }, function(data){
                    $("#cbo_vendedor").html(data);
                });         
            });
    });
    });
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
                <li class="page-item"><a href="#" class="page-link">Presupuestos x vendedor</a></li>
            </ul>
        </div>
    </div> 

    <?php //if($correo_usuario == "programacion@novomode.ec" || $correo_usuario == "operaciones@novomode.ec"){?>
                    <div class="row">
                        <div class="cell"><input data-prepend="Fecha:" data-role="datepicker" data-day="false" id="txt_fecha" data-locale="es-ES"></div>
                        <div class="cell"><div> 
                            <select data-prepend="Almacen:" data-role="select" id="cbo_almacen2">
                            <?php while($row=sqlsrv_fetch_array($res_almacen2)) { ?>
                            <option value="<?php echo $row["ALMACEN"]?>"><?php echo $row["ALMACEN"]?></option>
                            <?php } ?>
                            </select>
                        </div></div>
                    </div>
                    <div class="row">
                    <div class="cell"><div> 
                            <select data-prepend="Vendedor:" data-role="select" id="cbo_vendedor" name="cbo_vendedor">
                            <?php while($row=sqlsrv_fetch_array($res_vendedores)) { ?>
                            <option value="<?php echo $row["NOMVENDEDOR"]?>"><?php echo $row["NOMVENDEDOR"]?></option>
                            <?php } ?>
                            </select>
                        </div></div>
                        <div class="cell"><div> 
                            <input type="number" style="text-align:right;" data-prepend="Meta:" id="txt_monto" name="txt_monto" size="7" value="0" placeholder = "10000">
                            <?php while($row=sqlsrv_fetch_array($res_vendedores)) { ?>
                            <option value="<?php echo $row["NOMVENDEDOR"]?>"><?php echo $row["NOMVENDEDOR"]?></option>
                            <?php } ?>
                            </select>
                        </div></div>
                        <div class="cell">
                            <button class="button primary cycle shadowed" onclick="guardar_meta();"><span class="mif-checkmark"></span></button>
                        </div>
                    </div>
                <?php //} ?>

    <hr>

    <div class="container" id="datos_metas">
        <div class="row">
        <table class="table compact table-border striped">
            <tr class="bg-cyan fg-white" style="text-align:center;">
                <th colspan="2">Metas cargadas del mes - <?php echo $mes_letras;?></th>
            </tr>
            <?php 
                while($row=sqlsrv_fetch_array($res_metas)) { 
                    $vendedor = $row["nombre_vendedor"];
            ?>
            <tr>
                <th><?php echo $vendedor?></th>
                <td><input type="number" disabled style="text-align:right;" value="<?php echo $row["monto_meta_vendedor"]?>" id="txt_<?php echo $vendedor?>" size="10"><td>
            </tr>
            <?php } ?>
        </table>
        </div>
    </div>
</body>