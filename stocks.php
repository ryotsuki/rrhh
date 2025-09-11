<?php
    include("conexion/conexion.php");
    //include("../validacion/validacion.php");
    $conn = conectate2();

    $consulta_marcas = "SELECT * FROM MARCA ORDER BY DESCRIPCION";
    $res_marca=sqlsrv_query($conn,$consulta_marcas);	

    // $consulta_familias = "SELECT * FROM MARCA ORDER BY DESCRIPCION";
    // $res_marca=sqlsrv_query($conn,$consulta_marcas);
?>

<html>
<head>

    <script>
        function buscar(){

            var referencia = $("#txt_referencia").val();
            var barras = $("#txt_barras").val();
            var familia = $("#txt_familia").val();
            var marca = $("#cbo_marca").val();

            //alert(marca);

            //alert(referencia);
			
            $.post("datos/consulta_stocks.php?marca="+marca+"&referencia="+referencia+"&barras="+barras+"&familia="+familia, function(htmlexterno){
                $('#tabla_datos').fadeOut('slow');
                $('#tabla_datos').fadeIn('slow');
                $("#tabla_datos").html(htmlexterno);
            });
 
        }

        $('#txt_referencia').keypress(function (e) {
            if (e.which == 13) {
                //alert("prueba");
                buscar();
            }
        });

        $('#txt_barras').keypress(function (e) {
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
                <li class="page-item"><a href="#" class="page-link">Consulta de Stocks</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="cell"><div>
            <input type="text" data-role="input" data-prepend="Referencia: " id="txt_referencia">
        </div></div>
        <div class="cell"><div>
            <input type="text" data-role="input" data-prepend="Cod. Barras: " id="txt_barras">
        </div></div>
        <!--<div class="cell-3"><div>
            <select data-prepend="Marca:" data-role="select" id="cbo_marca" multiple>
            <option value="TODAS">TODAS</option>
            <?php while($row=sqlsrv_fetch_array($res_marca)) { ?>
            <option value="<?php echo $row["CODMARCA"]?>"><?php echo $row["DESCRIPCION"]?></option>
            <?php } ?>
            </select>
        </div></div>
        <div class="cell-3"><div>
            <input type="text" data-role="input" data-prepend="Familia: " id="txt_familia">
        </div></div>-->
        <div class="cell"><div>
            <button id="btn_buscar" class="button primary cycle" onclick="buscar();"><span class="mif-search"></span></button>
        </div></div>
    </div>

    <div class="container" id="tabla_datos"></div>
</div>
</body>