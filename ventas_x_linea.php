<?php
    include("conexion/conexion.php");
    //include("../validacion/validacion.php");
    $conn = conectate();

    $conn2 = conectate2();

    $consulta_marcas = "SELECT M.DESCRIPCION AS MARCA, L.DESCRIPCION AS LINEA FROM LINEA AS L, MARCA AS M WHERE M.CODMARCA = L.CODMARCA ORDER BY M.DESCRIPCION,L.DESCRIPCION";
    $res_marca=sqlsrv_query($conn2,$consulta_marcas);

    $consulta_movimientos = "SELECT sum(VTA_NETA) AS VENTA_NETA, sum(CANTIDAD_VTA) AS UNIDADES,MARCA,ALMACEN,VENDEDOR,COLECCION  from ventas where datepart(year,fecha) = 2021 and datepart(month,fecha) = 6 AND VENDEDOR IS NOT NULL AND ALMACEN IS NOT NULL GROUP BY MARCA,ALMACEN,VENDEDOR,COLECCION";
    $res_movimientos=sqlsrv_query($conn,$consulta_movimientos);	

    // $consulta_familias = "SELECT * FROM MARCA ORDER BY DESCRIPCION";
    // $res_marca=sqlsrv_query($conn,$consulta_marcas);
?>

<html>
<head>

    <script>
        function buscar(){

            var desde = $("#txt_desde").val();
            var hasta = $("#txt_hasta").val();
            var coleccion = $("#cbo_coleccion").val();

            //alert(marca);

            //alert(referencia);
			
            $.post("datos/consulta_x_linea.php?coleccion="+coleccion+"&desde="+desde+"&hasta="+hasta, function(htmlexterno){
                $('#tabla_datos').fadeOut('slow');
                $('#tabla_datos').fadeIn('slow');
                $("#tabla_datos").html(htmlexterno);
            });
 
        }
    </script>
</head>

<body>
<div class="container">

    <div class="row border-bottom bd-lightGray m-3">
        <div class="cell-md-4 d-flex flex-align-center">
            <h3 class="dashboard-section-title  text-center text-left-md w-100">Novomode CP <small>Version 1.0</small></h3>
        </div>

        <div class="cell-md-8 d-flex flex-justify-center flex-justify-end-md flex-align-center">
            <ul class="breadcrumbs bg-transparent">
                <li class="page-item"><a href="#" class="page-link"><span class="mif-chevron-thin-right"></span></a></li>
                <li class="page-item"><a href="#" class="page-link">Ventas por Linea</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="cell-3"><div>
            <input type="text" data-role="calendarpicker" data-prepend="Fecha inicial: " id="txt_desde">
        </div></div>
        <div class="cell-3"><div>
            <input type="text" data-role="calendarpicker" data-prepend="Fecha final: " id="txt_hasta">
        </div></div>
        <div class="cell-3"><div>
            <select data-role="select" multiple id="cbo_coleccion">
                <option value="TODAS">TODAS</option>
                <?php while($row=sqlsrv_fetch_array($res_marca)) { ?>
                <option value="<?php echo $row["MARCA"]."-".$row["LINEA"]?>"><?php echo $row["MARCA"]." - ".$row["LINEA"]?></option>
                <?php } ?>
            </select>
        </div></div>
        <div class="cell-3"><div>
            <button class="button primary cycle" onclick="buscar();"><span class="mif-search"></span></button>
        </div></div>
    </div>

    <div class="container" id="tabla_datos">
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
        <th class="sortable-column sort-asc">ALMACEN</th>
        <th class="sortable-column sort-asc">VENDEDOR</th>
        <th class="sortable-column sort-asc">MARCA</th>
        <th class="sortable-column sort-asc">LINEA</th>
        <th class="sortable-column sort-asc">VENTA NETA</th>
        <th class="sortable-column sort-asc">UNIDADES</th>
    </tr>
    </thead>

    <tbody>
    <?php 
        while($row=sqlsrv_fetch_array($res_movimientos)) { 
    ?>
    <tr>
        <td><?php echo $row["ALMACEN"]?></td>
        <td><?php echo utf8_encode($row["VENDEDOR"])?></td>
        <td><?php echo $row["MARCA"]?></td>
        <td><?php echo $row["COLECCION"]?></td>
        <td><?php echo number_format($row["VENTA_NETA"],2,',','.')?></td>
        <td><?php echo number_format($row["UNIDADES"],0,',','.')?></td>
    </tr>
    <?php
        }
    ?>
    </tbody>
    
    </table>
    </div>
</div>
</body>