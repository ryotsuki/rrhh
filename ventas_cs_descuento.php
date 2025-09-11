

<?php
    //ini_set('display_errors', 'Off');
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
                <li class="page-item"><a href="#" class="page-link">Ventas descuento</a></li>
            </ul>
        </div>
    </div> 

    <?php //if($correo_usuario == "programacion@novomode.ec" || $correo_usuario == "operaciones@novomode.ec"){?>
                    <div class="row">
                        <div class="cell"><input type="text" data-role="calendarpicker" data-prepend="Fecha desde:" data-size="280" id="txt_inicio2"></div>
                        <div class="cell"><input type="text" data-role="calendarpicker" data-prepend="Fecha hasta:" data-size="280" id="txt_fin2" value="<?php echo date("Y-m-d")?>"></div>
                        <div class="cell"><div> 
                            <select data-prepend="Almacen:" data-role="select" id="cbo_almacen2" multiple>
                            <?php while($row=sqlsrv_fetch_array($res_almacen2)) { ?>
                            <option value="<?php echo $row["ALMACEN"]?>"><?php echo $row["ALMACEN"]?></option>
                            <?php } ?>
                            </select>
                        </div></div>
                        <div class="cell">
                            <button class="button primary cycle shadowed" onclick="recalcular_cs_descuento();"><span class="mif-search"></span></button>
                            <button class="button success cycle shadowed" onclick="excel();">
                                <span class="mif-file-excel icon"></span>
                            </button>
                        </div>
                    </div>
                <?php //} ?>

    <div class="container" id="datos_descuento">
                
                </div>
</body>