<?php
    //ini_set('display_errors', 'Off');
    include("conexion/conexion.php");   

    $conn = conectate2();

    $consulta_almacenes="SELECT * FROM ALMACEN WHERE CODALMACEN IN('C1','C2','C3','C4','C5','C6','B1','B2','B3','B4','B5','B6','N1','E1') ORDER BY NOMBREALMACEN";
    $res_almacenes=sqlsrv_query($conn,$consulta_almacenes);

    $consulta_marcas="SELECT * FROM MARCA WHERE DESCRIPCION = 'NEW BALANCE' ORDER BY DESCRIPCION";
    $res_marcas=sqlsrv_query($conn,$consulta_marcas);

    $consulta_anio="SELECT * FROM TEMPORADAS ORDER BY TEMPORADA";
    $res_anio=sqlsrv_query($conn,$consulta_anio);

    $consulta_coleccion="SELECT DISTINCT DESCRIPCION FROM LINEA ORDER BY DESCRIPCION";
    $res_coleccion=sqlsrv_query($conn,$consulta_coleccion);

    $consulta_familia="SELECT DISTINCT DESCRIPCION FROM FAMILIAS WHERE NUMDPTO = 2 ORDER BY DESCRIPCION";
    $res_familia=sqlsrv_query($conn,$consulta_familia);
?>

<html>
<head> 

    <script>
        function buscarsku(){

            var referencia = $("#txt_referencia").val();
            var fecha = $("#txt_fecha").val();
            var fecha2 = $("#txt_fecha2").val();
            var color = $("#txt_color").val();
            var almacen = $("#cbo_almacen").val();
            var marca = $("#cbo_marca").val();
            var anio = $("#cbo_anio").val();
            var coleccion = $("#cbo_coleccion").val();
            var ciclo = $("#txt_ciclo").val();
            var familia = $("#cbo_familia").val();

            $.post("datos/consulta_rotacion_nb.php?fecha="+fecha+"&fecha2="+fecha2+"&referencia="+referencia+"&color="+color+"&almacen="+almacen+"&marca="+marca+"&anio="+anio+"&coleccion="+coleccion+"&ciclo="+ciclo+"&familia="+familia, function(htmlexterno){
                $('#tabla_datos').fadeOut('slow');
                $('#tabla_datos').fadeIn('slow');
                $("#tabla_datos").html(htmlexterno);
            });

        }

        function excel(){ 

            var referencia = $("#txt_referencia").val();
            var fecha = $("#txt_fecha").val();
            var fecha2 = $("#txt_fecha2").val();
            var color = $("#txt_color").val();
            var almacen = $("#cbo_almacen").val();
            var marca = $("#cbo_marca").val();
            var anio = $("#cbo_anio").val();
            var coleccion = $("#cbo_coleccion").val();
            var ciclo = $("#txt_ciclo").val();
            var familia = $("#cbo_familia").val();

            window.open('datos/exnb.php?fecha='+fecha+'&fecha2='+fecha2+'&referencia='+referencia+'&color='+color+'&almacen='+almacen+'&marca='+marca+'&anio='+anio+'&coleccion='+coleccion+'&ciclo='+ciclo+'&familia='+familia, '_blank');
        }
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
                <li class="page-item"><a href="#" class="page-link"><span class="mif-replay"></span></a></li>
                <li class="page-item"><a href="#" class="page-link">Consulta de Rotacion NB</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="cell-4"><div>
            <input type="text" data-role="input" data-prepend="Referencia: " id="txt_referencia">
        </div></div>
        <div class="cell-4"><div>
            <input type="text" data-role="input" data-prepend="Color: " id="txt_color">
        </div></div>
        <div class="cell-4"><div>
            <select data-role="select" id="cbo_almacen" data-prepend="Almacen:">
                <option value="-1" selected="true">TODOS</option>
                <option value="1" selected="true">SIETE + ECOMMERCE</option>
                <option value="2" selected="true">NEW BALANCE</option>
                <?php //while($row=sqlsrv_fetch_array($res_almacenes)) { ?>
                <!--<option value="<?php echo $row["CODALMACEN"]?>"><?php echo $row["NOMBREALMACEN"]?></option>-->
                <?php //} ?>
            </select>
        </div></div>
        <div class="cell-4"><div>
            <select data-role="select" id="cbo_marca" data-prepend="Marca:">
                <!--<option value="-1" selected="true">TODAS</option>-->
                <?php while($row=sqlsrv_fetch_array($res_marcas)) { ?>
                <option value="<?php echo $row["CODMARCA"]?>"><?php echo $row["DESCRIPCION"]?></option>
                <?php } ?>
            </select>
        </div></div>
        <div class="cell-4"><div>
            <select data-role="select" id="cbo_coleccion" data-prepend="Coleccion:" multiple placeholder="Coleccion">
                <option value="-1" selected="true">COLECCION</option>
                <?php while($row=sqlsrv_fetch_array($res_coleccion)) { ?>
                <option value="<?php echo $row["DESCRIPCION"]?>"><?php echo $row["DESCRIPCION"]?></option>
                <?php } ?>
            </select>
        </div></div>
        <div class="cell-4"><div>
            <select data-role="select" id="cbo_anio" data-prepend="Año:" multiple placeholder="Año">
                <option value="-1" selected="true">AÑO</option>
                <?php while($row=sqlsrv_fetch_array($res_anio)) { ?>
                <option value="<?php echo $row["TEMPORADA"]?>"><?php echo $row["TEMPORADA"]?></option>
                <?php } ?>
            </select>
        </div></div>
        <div class="cell-4"><div>
            <select data-role="select" id="cbo_familia" data-prepend="Familia:" multiple placeholder="Familia">
                <option value="-1" selected="true">FAMILIA</option>
                <?php while($row=sqlsrv_fetch_array($res_familia)) { ?>
                <option value="<?php echo utf8_encode($row["DESCRIPCION"])?>"><?php echo utf8_encode($row["DESCRIPCION"])?></option>
                <?php } ?>
            </select>
        </div></div>
        <div class="cell-4"><div>
            <input type="text" data-role="input" data-prepend="Ciclo: " id="txt_ciclo">
        </div></div>
        <div class="cell-4"><div>
            <input type="text" data-role="calendarpicker" id="txt_fecha" data-prepend="Fecha Inicio:">
        </div></div>
        <div class="cell-4"><div>
            <input type="text" data-role="calendarpicker" id="txt_fecha2" data-prepend="Fecha Fin:">
        </div></div>
        <div class="cell-4"><div>
            <!--<button class="button primary cycle" onclick="buscar();"><span class="mif-search"></span></button>-->
            <button class="image-button primary shadowed" onclick="buscarsku();">
                <span class="mif-search icon"></span>
                <span class="caption"><b>Buscar</b></span>
            </button>
            <button class="image-button success shadowed" onclick="excel();">
                <span class="mif-file-excel icon"></span>
                <span class="caption"><b>Excel</b></span>
            </button>
        </div></div>
    </div> 

    <div class="container" id="tabla_datos"></div>
</div>
</body>
</html>