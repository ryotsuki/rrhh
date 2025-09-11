<?php
    include("conexion/conexion.php");
    //include("../validacion/validacion.php");
    $conn = conectate();

    $consulta_segmentos = "SELECT DISTINCT
                            CEDULA_RUC,
                            MAIL,
                            CELULAR,
                            CLIENTE,
                            CASE   
                            WHEN SUM(VTA_NETA) < 4 THEN 'SIN SEGMENTO'
                            WHEN SUM(VTA_NETA) >= 4 AND SUM(VTA_NETA) <= 211.99 THEN 'AMATEUR'
                            WHEN SUM(VTA_NETA) >= 212 AND SUM(VTA_NETA) <= 600.99 THEN 'EXPERT'
                            WHEN SUM(VTA_NETA) >= 601 AND SUM(VTA_NETA) <= 1005.99 THEN 'BELIEVER'
                            WHEN SUM(VTA_NETA) > 1006 THEN 'AMBASSADOR'
                            END AS SEGMENTO,
                            SUM(VTA_NETA) AS VENTA_NETA,
                            (SELECT TOP (1) ALMACEN FROM VENTAS WHERE CEDULA_RUC = V.CEDULA_RUC AND ALMACEN LIKE 'CH %' ORDER BY FECHA DESC) AS ALMACEN,
                            (SELECT CONVERT(VARCHAR,MAX(FECHA),103) FROM VENTAS WHERE CEDULA_RUC = V.CEDULA_RUC AND ALMACEN LIKE 'CH %') AS ULT_COMPRA,
                            CONVERT(VARCHAR,FECHA_NACIMIENTO,103) AS FECHA_NACIMIENTO
                        FROM 
                            VENTAS V
                        WHERE
                            FECHA BETWEEN DATEADD(YEAR, -1, GETDATE()) AND GETDATE() AND
                            ALMACEN LIKE 'CH %'
                        GROUP BY
                            CEDULA_RUC,
                            MAIL,
                            CELULAR,
                            CLIENTE,
                            CONVERT(VARCHAR,FECHA_NACIMIENTO,103)
                        ORDER BY
                            CEDULA_RUC";
    $res=sqlsrv_query($conn,$consulta_segmentos);
    
    $consulta_segmentos_siete = "SELECT DISTINCT
                            CEDULA_RUC,
                            MAIL,
                            CELULAR,
                            CLIENTE,
                            CASE   
                                WHEN SUM(VTA_NETA) < 4 THEN 'SIN SEGMENTO'
                                WHEN SUM(VTA_NETA) >= 5 AND SUM(VTA_NETA) <= 300.99 THEN 'FRIEND'
                                WHEN SUM(VTA_NETA) >= 301 AND SUM(VTA_NETA) <= 500.99 THEN 'BEST FRIEND'
                                WHEN SUM(VTA_NETA) >= 501 AND SUM(VTA_NETA) <= 899.99 THEN 'PARTNER'
                                WHEN SUM(VTA_NETA) > 900 THEN 'ICON'
                            END AS SEGMENTO,
                            SUM(VTA_NETA) AS VENTA_NETA,
                            (SELECT TOP(1) ALMACEN FROM VENTAS WHERE CEDULA_RUC = V.CEDULA_RUC AND (ALMACEN LIKE 'SIE%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%POP%' OR ALMACEN LIKE '%ECOMMERCE%') ORDER BY FECHA DESC) AS ALMACEN,
                            (SELECT CONVERT(VARCHAR,MAX(FECHA),103) FROM VENTAS WHERE CEDULA_RUC = V.CEDULA_RUC AND (ALMACEN LIKE 'SIE%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%POP%' OR ALMACEN LIKE '%ECOMMERCE%')) AS ULT_COMPRA,
                            CONVERT(VARCHAR,FECHA_NACIMIENTO,103) AS FECHA_NACIMIENTO
                        FROM 
                            VENTAS V
                        WHERE
                            FECHA BETWEEN DATEADD(YEAR, -1, GETDATE()) AND GETDATE() AND
                            (ALMACEN LIKE 'SIE%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%ECOMMERCE%' OR ALMACEN LIKE '%POP%')
                        GROUP BY
                            CEDULA_RUC,
                            MAIL,
                            CELULAR,
                            CLIENTE,
                            CONVERT(VARCHAR,FECHA_NACIMIENTO,103)
                        ORDER BY
                            CEDULA_RUC";
    $res_siete=sqlsrv_query($conn,$consulta_segmentos_siete);

    // $consulta_familias = "SELECT * FROM MARCA ORDER BY DESCRIPCION";
    // $res_marca=sqlsrv_query($conn,$consulta_marcas);
?>

<html>
<head>

    <script>
        function buscar(){

            var desde = $("#txt_desde").val();
            var hasta = $("#txt_hasta").val();

            //alert(marca);

            //alert(referencia);
			
            $.post("datos/consulta_segmentos.php?desde="+desde+"&hasta="+hasta, function(htmlexterno){
                $('#tabla_datos').fadeOut('slow');
                $('#tabla_datos').fadeIn('slow');
                $("#tabla_datos").html(htmlexterno);
            });
 
        }

        function excel(){

            var desde = $("#txt_desde").val();
            var hasta = $("#txt_hasta").val();

            window.open('datos/ex.php?desde='+desde+'&hasta='+hasta, '_blank');
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
                <li class="page-item"><a href="#" class="page-link">Consulta de Segmentos</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="cell-4"><div>
            <input type="text" data-role="calendarpicker" data-prepend="Fecha desde: " id="txt_desde">
        </div></div>
        <div class="cell-4"><div>
        <input type="text" data-role="calendarpicker" data-prepend="Fecha hasta: " id="txt_hasta">
        </div></div>
        <div class="cell-4"><div>
            <button id="btn_buscar" class="button primary cycle" onclick="buscar();"><span class="mif-search"></span></button>
            <button id="btn_excel" class="button success cycle" onclick="excel();"><span class="mif-file-excel"></span></button>
        </div></div>
    </div>

    <div class="container" id="tabla_datos">
        <h2>SEGMENTOS CHEVIGNON:</h2>
        <table class="table compact striped table-border mt-4" data-role="table"
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
                <th class="sortable-column sort-asc">CEDULA</th>
                <th class="sortable-column sort-asc">CLIENTE</th>
                <th class="sortable-column sort-asc">EMAIL</th>
                <th class="sortable-column sort-asc">NAC.</th>
                <th class="sortable-column sort-asc">ALMACEN</th>
                <th class="sortable-column sort-asc">ULT. COMPRA</th>
                <th class="sortable-column sort-asc">CELULAR</th>
                <th class="sortable-column sort-asc">SEGMENTO</th>
                <th class="sortable-column sort-asc">VENTA NETA</th>
                <th class="sortable-column sort-asc">SEG. UP</th>
                <th class="sortable-column sort-asc">SEG. DOWN</th>
            </tr>
            </thead>

            <tbody>
            <?php 
                while($row=sqlsrv_fetch_array($res)) { 
                    if($row["SEGMENTO"] == "INACTIVO"){
                        $up = 4 - $row["VENTA_NETA"];
                        $down = 0;
                    }
                    if($row["SEGMENTO"] == "AMATEUR"){
                        $up = 212 - $row["VENTA_NETA"];
                        $down = -1*(4 - $row["VENTA_NETA"]);
                    }
                    if($row["SEGMENTO"] == "EXPERT"){
                        $up = 601 - $row["VENTA_NETA"];
                        $down = -1*(212 - $row["VENTA_NETA"]);
                    }
                    if($row["SEGMENTO"] == "BELIEVER"){
                        $up = 1006 - $row["VENTA_NETA"];
                        $down = -1*(601 - $row["VENTA_NETA"]);
                    }
                    if($row["SEGMENTO"] == "AMBASSADOR"){
                        $up = 0;
                        $down = -1*(1006 - $row["VENTA_NETA"]);
                    }
            ?>
            <tr>
                <td><?php echo $row["CEDULA_RUC"]?></td>
                <td><?php echo utf8_encode($row["CLIENTE"])?></td>
                <td><?php echo $row["MAIL"]?></td>
                <td><?php echo $row["FECHA_NACIMIENTO"]?></td>
                <td><?php echo $row["ALMACEN"]?></td>
                <td><?php echo $row["ULT_COMPRA"]?></td>
                <td><?php echo $row["CELULAR"]?></td>
                <td><?php echo $row["SEGMENTO"]?></td>
                <td><?php echo number_format($row["VENTA_NETA"],2,',','.')?></td>
                <td><?php echo number_format($up,2,',','.')?></td>
                <td><?php echo number_format($down,2,',','.')?></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
            
        </table>

        <hr>

        <h2>SEGMENTOS SIE7E:</h2>
        <table class="table compact striped table-border mt-4" data-role="table"
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
                <th class="sortable-column sort-asc">CEDULA</th>
                <th class="sortable-column sort-asc">CLIENTE</th>
                <th class="sortable-column sort-asc">EMAIL</th>
                <th class="sortable-column sort-asc">NAC.</th>
                <th class="sortable-column sort-asc">ALMACEN</th>
                <th class="sortable-column sort-asc">ULT. COMPRA</th>
                <th class="sortable-column sort-asc">CELULAR</th>
                <th class="sortable-column sort-asc">SEGMENTO</th>
                <th class="sortable-column sort-asc">VENTA NETA</th>
                <th class="sortable-column sort-asc">SEG. UP</th>
                <th class="sortable-column sort-asc">SEG. DOWN</th>
            </tr>
            </thead>

            <tbody>
            <?php 
                while($row=sqlsrv_fetch_array($res_siete)) { 
                    if($row["SEGMENTO"] == "INACTIVO"){
                        $up = 4 - $row["VENTA_NETA"];
                        $down = 0;
                    }
                    if($row["SEGMENTO"] == "FRIEND"){
                        $up = 212 - $row["VENTA_NETA"];
                        $down = -1*(4 - $row["VENTA_NETA"]);
                    }
                    if($row["SEGMENTO"] == "BEST FRIEND"){
                        $up = 601 - $row["VENTA_NETA"];
                        $down = -1*(212 - $row["VENTA_NETA"]);
                    }
                    if($row["SEGMENTO"] == "PARTNER"){
                        $up = 1006 - $row["VENTA_NETA"];
                        $down = -1*(601 - $row["VENTA_NETA"]);
                    }
                    if($row["SEGMENTO"] == "ICON"){
                        $up = 0;
                        $down = -1*(1006 - $row["VENTA_NETA"]);
                    }
            ?>
            <tr>
                <td><?php echo $row["CEDULA_RUC"]?></td>
                <td><?php echo utf8_encode($row["CLIENTE"])?></td>
                <td><?php echo $row["MAIL"]?></td>
                <td><?php echo $row["FECHA_NACIMIENTO"]?></td>
                <td><?php echo $row["ALMACEN"]?></td>
                <td><?php echo $row["ULT_COMPRA"]?></td>
                <td><?php echo $row["CELULAR"]?></td>
                <td><?php echo $row["SEGMENTO"]?></td>
                <td><?php echo number_format($row["VENTA_NETA"],2,',','.')?></td>
                <td><?php echo number_format($up,2,',','.')?></td>
                <td><?php echo number_format($down,2,',','.')?></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
            
        </table>
    </div>
</div>
</body>