<?php
    include("conexion/conexion.php");
    ini_set('max_execution_time', '0');
    //include("../validacion/validacion.php");
    $conn = conectate();

    $consulta_segmentos = "SELECT * FROM UBICACIONES_ECOMMERCE";
    $res=sqlsrv_query($conn,$consulta_segmentos);	
?>

<script>

    function buscar(){
        var ref = $("#txt_ref").val();

        $.post("datos/buscar_ref.php?ref="+ref, function(htmlexterno){
            $('#tabla_datos').fadeOut('slow');
            $('#tabla_datos').fadeIn('slow');
            $("#tabla_datos").html(htmlexterno);
        });
    }

    $('#txt_ref').keypress(function (e) {
        if (e.which == 13) {
            //alert("prueba");
            buscar();
        }
    });
</script>

<html>

<body>
<div class="container">

    <div class="row border-bottom bd-lightGray m-3">
        <div class="cell-md-4 d-flex flex-align-center">
            <h3 class="dashboard-section-title  text-center text-left-md w-100">Novomode CP <small>Version 1.5</small></h3>
        </div>

        <div class="cell-md-8 d-flex flex-justify-center flex-justify-end-md flex-align-center">
            <ul class="breadcrumbs bg-transparent">
                <li class="page-item"><a href="#" class="page-link"><span class="mif-location"></span></a></li>
                <li class="page-item"><a href="#" class="page-link">Consulta de Referencias Físicas</a></li>
            </ul>
        </div>
    </div>

    <div data-role="panel" data-title-caption="FILTRO DE CODBARRAS" data-collapsible="true" data-title-icon="<span class='mif-calculator'></span>" class="cell-md-5">
    <div class="row">
        <div class="cell-md-5">
            CODIGO BARRAS: 
            <input type="text" id="txt_ref" name="txt_ref">
        </div>
        <div class="cell-md-5">
            <button onclick="buscar()" class="button primary rounded shadowed large"><span class='mif-search'></span> Buscar</button>
        </div>
    </div>
    </div>

    <br></br>

    <div class="container" id="tabla_datos">
    </div>
</div>
</body>