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

    //CALCULO DE VENTAS X ALMACEN
    include("datos/capitalizacion_x_almacen.php");
    //----------------------

    //GRAFICOS DE DONA
    include("datos/donas_capi.php");
    //----------------------

    $ocultar1 = "";
    $ocultar2 = "";
    $ocultar3 = "";
    $logo = "";

    if(strpos($username, "CH") !== false) {
        $ocultar1 = "style='display:none;'";
        $ocultar2 = "style='display:none;'";
        $logo = "images/curvas/CHEVIGNON N.png";
    }
    if(strpos($username, "SIE") !== false) {
        $ocultar1 = "style='display:none;'";
        $ocultar3 = "style='display:none;'";
        $logo = "images/curvas/SIE7E BLACK.png";
    }
    if(strpos($username, "NEW") !== false) {
        $ocultar1 = "style='display:none;'";
        $ocultar2 = "style='display:none;'";
        $ocultar3 = "style='display:none;'";
        $logo = "images/curvas/new-balance-logo.png";
    }
    
?>

<html>
<head>

    <script>
        function buscar(){

            var desde = $("#txt_desde").val();
            var hasta = $("#txt_hasta").val();
            var desde3 = $("#txt_desde2").val();
            var hasta3 = $("#txt_hasta2").val();
            var franquicia = $("#cbo_franquicia").val();

            if(franquicia == 1){ 
                $.post("datos/consulta_capitalizacion.php?desde="+desde+"&hasta="+hasta+"&desde3="+desde3+"&hasta3="+hasta3, function(htmlexterno){
                    $('#tabla_datos').fadeOut('slow');
                    $('#tabla_datos').fadeIn('slow');
                    $("#tabla_datos").html(htmlexterno);
                });
            }

            if(franquicia == 2){ 
                $.post("datos/consulta_capitalizacion_siete.php?desde="+desde+"&hasta="+hasta+"&desde3="+desde3+"&hasta3="+hasta3, function(htmlexterno){
                    $('#tabla_datos').fadeOut('slow');
                    $('#tabla_datos').fadeIn('slow');
                    $("#tabla_datos").html(htmlexterno);
                });
            } 
           
        }

        function buscar2(){

            var desde = $("#txt_desde").val();
            var hasta = $("#txt_hasta").val();
            var desde3 = $("#txt_desde2").val();
            var hasta3 = $("#txt_hasta2").val();
            var franquicia = $("#cbo_franquicia").val();

            if(franquicia == 1){ 
                $.post("datos/consulta_capitalizacion_especial.php?desde="+desde+"&hasta="+hasta+"&desde3="+desde3+"&hasta3="+hasta3, function(htmlexterno){
                    $('#tabla_datos').fadeOut('slow');
                    $('#tabla_datos').fadeIn('slow');
                    $("#tabla_datos").html(htmlexterno);
                });
            }

            if(franquicia == 2){ 
                $.post("datos/consulta_capitalizacion_siete_especial.php?desde="+desde+"&hasta="+hasta+"&desde3="+desde3+"&hasta3="+hasta3, function(htmlexterno){
                    $('#tabla_datos').fadeOut('slow');
                    $('#tabla_datos').fadeIn('slow');
                    $("#tabla_datos").html(htmlexterno);
                });
            } 

            }

        function excel(){

            var desde = $("#txt_desde").val();
            var hasta = $("#txt_hasta").val();
            var desde3 = $("#txt_desde2").val(); 
            var hasta3 = $("#txt_hasta2").val();
            var franquicia = $("#cbo_franquicia").val();

            if(franquicia == 1){
                window.open("datos/ex.php?desde="+desde+"&hasta="+hasta+"&desde3="+desde3+"&hasta3="+hasta3, '_blank');
            }
        }

        $('#txt_desde').keypress(function (e) {
            if (e.which == 13) {
                //alert("prueba");
                buscar();
            }
        });

        $('#txt_hasta').keypress(function (e) {
            if (e.which == 13) {
                //alert("prueba");
                buscar();
            }
        });
    </script>
</head>

<body>
<div class="container">

    <div class="row border-bottom bd-lightGray m-3">
        <div class="cell-md-4 d-flex flex-align-center">
            <h3 class="dashboard-section-title  text-center text-left-md w-100">Novomode CP <small>Version 1.5</small></h3>
        </div>

        <div class="cell-md-8 d-flex flex-justify-center flex-justify-end-md flex-align-center">
            <ul class="breadcrumbs bg-transparent">
                <li class="page-item"><a href="#" class="page-link"><span class="mif-list-numbered"></span></a></li>
                <li class="page-item"><a href="#" class="page-link">Demostración Capitalización</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="cell-4"><div>
            <input data-prepend="Desde P1:" data-role="calendarpicker" id="txt_desde">
        </div></div>
        <div class="cell-4"><div>
            <input data-prepend="Hasta P1:" data-role="calendarpicker" id="txt_hasta">
        </div></div>
        <BR>
        <div class="cell-4"><div>
            <input data-prepend="Desde P2:" data-role="calendarpicker" id="txt_desde2">
        </div></div>
        <div class="cell-4"><div>
            <input data-prepend="Hasta P2:" data-role="calendarpicker" id="txt_hasta2">
        </div></div>
        <BR>
        <div class="cell-4"><div>
        <select data-role="select" id="cbo_franquicia">
            <option value="1">Chevignon</option>
            <option value="2">Sie7e</option>
        </select>
        </div></div>
        <div class="cell-4"><div>
            <button id="btn_buscar" class="button primary cycle" onclick="buscar();"><span class="mif-search"></span></button>
            <button id="btn_buscar2" class="button success cycle" onclick="buscar2();"><span class="mif-search"></span></button>
            <!--<button id="btn_excel" class="button success cycle" onclick="excel();"><span class="mif-file-excel"></span></button>-->
        </div></div>
    </div>

    <div class="container" id="tabla_datos">
        <div data-role="wizard">
            <section><div class="page-content">
                Page 1
            </div></section>
            <section><div class="page-content">Page 2</div></section>
            <section><div class="page-content">Page 3</div></section>
            <section><div class="page-content">Page 4</div></section>
            <section><div class="page-content">Page 5</div></section>
        </div>
    </div>
</div>
</body>