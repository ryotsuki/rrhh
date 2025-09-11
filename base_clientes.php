<?php
    include("conexion/conexion.php");
    ini_set('max_execution_time', '0');
    //include("../validacion/validacion.php");
    $conn = conectate2();

    $consulta_almacenes = "SELECT DISTINCT NOMBREALMACEN FROM ALMACEN WHERE 
    CODALMACEN IN('C1','C2','C3','C4','C5','C6','C7','B1','B2','B3','B4','B5','B6','B7','E1','N1','B8','BA','BB','N2','N3','PQ1','A8','OTL') ORDER BY NOMBREALMACEN";
    $res_almacen=sqlsrv_query($conn,$consulta_almacenes);

    $consulta_marcas = "SELECT DISTINCT DESCRIPCION FROM MARCA";
    $res_marcas=sqlsrv_query($conn,$consulta_marcas);

    $consulta_familias = "SELECT DISTINCT DESCRIPCION FROM FAMILIAS";
    $res_familias=sqlsrv_query($conn,$consulta_familias);
    //echo $consulta_almacenes;
?>

<html>
<head>

    <script>
        function buscar(){

            var desde = $("#txt_desde").val();
            var hasta = $("#txt_hasta").val();
            var almacen = $("#cbo_almacen").val();
            var estado = $("#cbo_estado").val();
            var genero = $("#cbo_genero").val();
            var cumple = $("#txt_cumple").val();
            var marca = $("#cbo_marca").val();
            var familia = $("#cbo_familia").val();
            var descuento = $("#cbo_descuento").val();

            $.post("datos/consulta_clientes.php?desde="+desde+"&hasta="+hasta+"&almacen="+almacen+"&estado="+estado+"&genero="+genero+"&cumple="+cumple+"&marca="+marca+"&familia="+familia+"&descuento="+descuento, function(htmlexterno){
                $('#tabla_datos').fadeOut('slow');
                $('#tabla_datos').fadeIn('slow');
                $("#tabla_datos").html(htmlexterno);
            });
           
        }

        function excel(){

            var desde = $("#txt_desde").val();
            var hasta = $("#txt_hasta").val();
            var almacen = $("#cbo_almacen").val();
            var estado = $("#cbo_estado").val();
            var genero = $("#cbo_genero").val();
            var cumple = $("#txt_cumple").val();
            var marca = $("#cbo_marca").val();
            var familia = $("#cbo_familia").val();
            var descuento = $("#cbo_descuento").val();

            window.open("datos/ex_clientes.php?desde="+desde+"&hasta="+hasta+"&almacen="+almacen+"&estado="+estado+"&genero="+genero+"&cumple="+cumple+"&marca="+marca+"&familia="+familia+"&descuento="+descuento, '_blank');
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
                <li class="page-item"><a href="#" class="page-link">Base de clientes</a></li>
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
            <select data-role="select" id="cbo_estado">
                <option value="-1">TODOS LOS ESTADOS</option>
                <option value="1">ACTIVO</option>
                <option value="2">POR INACTIVAR</option>
                <option value="3">INACTIVO</option>
            </select>
        </div></div>
        <BR>
        <div class="cell-4"><div>
            <input type="text" id="txt_cumple" data-role="input" data-prepend="MES CUMPLE: ">
        </div></div>
        <div class="cell-4"><div>
        <select data-role="select" id="cbo_genero">
            <option value="-1">TODOS LOS GENEROS</option>
            <option value="M">MASCULINO</option>
            <option value="F">FEMENINO</option>
        </select>
        </div></div>
        <div class="cell-4"><div>
        <select data-role="select" id="cbo_almacen" multiple>
            <option value="-1">TODOS LOS ALMACENES</option>
            <?php while($row=sqlsrv_fetch_array($res_almacen)) { ?>
            <option value="<?php echo $row["NOMBREALMACEN"]?>"><?php echo $row["NOMBREALMACEN"]?></option>
            <?php } ?>
        </select>
        </div></div>
        <div class="cell-4"><div>
        <select data-role="select" id="cbo_marca">
            <option value="-1">TODOS LAS MARCAS</option>
            <?php while($row=sqlsrv_fetch_array($res_marcas)) { ?>
            <option value="<?php echo $row["DESCRIPCION"]?>"><?php echo $row["DESCRIPCION"]?></option>
            <?php } ?>
        </select>
        </div></div>
        <div class="cell-4"><div>
        <select data-role="select" id="cbo_familia" multiple>
            <option value="-1">TODOS LAS FAMILIAS</option>
            <?php while($row=sqlsrv_fetch_array($res_familias)) { ?>
            <option value="<?php echo $row["DESCRIPCION"]?>"><?php echo $row["DESCRIPCION"]?></option>
            <?php } ?>
        </select>
        </div></div>
        <div class="cell-4"><div>
        <select data-role="select" id="cbo_descuento">
            <option value="-1">TODAS LAS VENTAS</option>
            <option value="1">FULL PRICE</option>
            <option value="2">DESCUENTO</option>
        </select>
        </div></div>
        <div class="cell-4"><div>
            <button id="btn_buscar" class="button primary cycle" onclick="buscar();"><span class="mif-search"></span></button>
            <button id="btn_buscar" class="button success cycle" onclick="excel();"><span class="mif-file-excel"></span></button>
        </div></div>
    </div>

    <div class="container" id="tabla_datos">
        
    </div>
</div>
</body>