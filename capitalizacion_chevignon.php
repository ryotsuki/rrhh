<?php
    include("conexion/conexion.php");
    ini_set('max_execution_time', '0');
    //include("../validacion/validacion.php");
    $conn = conectate();

    $consulta = "SELECT * FROM CAP_FAC_CLIENTES";
    $res=sqlsrv_query($conn,$consulta);	

?>

<html>
<head>

    <script>
        function buscar(){

            var desde = $("#txt_desde").val();
            var hasta = $("#txt_hasta").val();

            if(franquicia == 1){ 
                $.post("datos/consulta_capitalizacion_chevignon.php?desde="+desde+"&hasta="+hasta, function(htmlexterno){
                    $('#tabla_datos').fadeOut('slow');
                    $('#tabla_datos').fadeIn('slow');
                    $("#tabla_datos").html(htmlexterno);
                });
            }
           
        }

        function buscar2(){

            var desde = $("#txt_desde").val();
            var hasta = $("#txt_hasta").val();

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
                <li class="page-item"><a href="#" class="page-link"><span class="mif-users"></span></a></li>
                <li class="page-item"><a href="#" class="page-link">Capitalizacion por Estado</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="cell-4"><div>
            <input data-prepend="Desde:" data-role="calendarpicker" id="txt_desde">
        </div></div>
        <div class="cell-4"><div>
            <input data-prepend="Hasta:" data-role="calendarpicker" id="txt_hasta">
        </div></div>
        <BR>
        <div class="cell-4"><div>
            <button id="btn_buscar" class="button primary cycle" onclick="buscar();"><span class="mif-search"></span></button>
            <button id="btn_buscar2" class="button success cycle" onclick="buscar2();"><span class="mif-search"></span></button>
            <!--<button id="btn_excel" class="button success cycle" onclick="excel();"><span class="mif-file-excel"></span></button>-->
        </div></div>
    </div>

    <div class="container" id="tabla_datos">
        
    </div>
</div>
</body>