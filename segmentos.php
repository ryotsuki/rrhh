<?php
    include("conexion/conexion.php");
    ini_set('max_execution_time', '0');
    //include("../validacion/validacion.php");
    $conn = conectate4();

    $consulta_segmentos = "SELECT DISTINCT
                                T1.CEDULA_CLIENTE,
                                T1.COD_CLIENTE, 
                                T1.ESTADO_CLIENTE,
                                CASE   
                                WHEN T1.ESTADO_CLIENTE = 'CLIENTE NUEVO' THEN 
                                CASE   
                                    WHEN SUM(VENTA_NETA) >= 4 AND SUM(VENTA_NETA) <= 211.99 THEN 'Amateur'
                                    WHEN SUM(VENTA_NETA) >= 212 AND SUM(VENTA_NETA) <= 600.99 THEN 'Expert'
                                    WHEN SUM(VENTA_NETA) >= 601 AND SUM(VENTA_NETA) <= 1005.99 THEN 'Believer'
                                    WHEN SUM(VENTA_NETA) > 1006 THEN 'Ambassador'
                                END
                                WHEN T1.ESTADO_CLIENTE = 'CLIENTE ANTIGUO' THEN ISNULL(T2.SEGMENTO,'Inactivo')  
                            END AS SEGMENTO,
                            SUM(VENTA_NETA) AS VENTA_NETA_ACTUAL,
                            --T1.FECHA_FACTURA,
                            T1.EMAIL_CLIENTE,
                            T1.CELULAR_CLIENTE,
                            CONVERT(VARCHAR,ISNULL(MAX(T1.FECHA_FACTURA),'2010-01-01'),103) AS ULTIMA_FACTURA
                            FROM            
                                VENTAS_MERCADEO_Y_MODA T1
                            LEFT JOIN CLIENTES_SEGMENTADOS T2 ON
                                T1.COD_CLIENTE = T2.COD_CLIENTE
                            WHERE 
                                T1.FECHA_FACTURA BETWEEN DATEADD(YEAR, -1, GETDATE()) AND GETDATE()
                            GROUP BY
                                T1.CEDULA_CLIENTE,
                                T1.COD_CLIENTE,   
                                T1.ESTADO_CLIENTE,
                                T2.SEGMENTO,
                                --T1.FECHA_FACTURA,
                                T1.EMAIL_CLIENTE,
                                T1.CELULAR_CLIENTE";
    $res=sqlsrv_query($conn,$consulta_segmentos);	

    // $consulta_familias = "SELECT * FROM MARCA ORDER BY DESCRIPCION";
    // $res_marca=sqlsrv_query($conn,$consulta_marcas);}

    $amateur = 0;
    $expert = 0;
    $believer = 0;
    $ambassador = 0;
    $inactivo = 0;
    $nuevo = 0;
    $por_inactivar = 0;
    $color = "";
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
                $.post("datos/consulta_segmentos.php?desde="+desde+"&hasta="+hasta+"&desde3="+desde3+"&hasta3="+hasta3, function(htmlexterno){
                    $('#tabla_datos').fadeOut('slow');
                    $('#tabla_datos').fadeIn('slow');
                    $("#tabla_datos").html(htmlexterno);
                });
            }
            if(franquicia == 3){
                $.post("datos/consulta_segmentos2.php?desde="+desde+"&hasta="+hasta+"&desde3="+desde3+"&hasta3="+hasta3+"&franquicia="+franquicia, function(htmlexterno){
                    $('#tabla_datos').fadeOut('slow');
                    $('#tabla_datos').fadeIn('slow');
                    $("#tabla_datos").html(htmlexterno);
                });
            }
            if(franquicia == 2){
                $.post("datos/consulta_segmentos3.php?desde="+desde+"&hasta="+hasta+"&desde3="+desde3+"&hasta3="+hasta3+"&franquicia="+franquicia, function(htmlexterno){
                    $('#tabla_datos').fadeOut('slow');
                    $('#tabla_datos').fadeIn('slow');
                    $("#tabla_datos").html(htmlexterno);
                });
            }
            if(franquicia == 4){
                $.post("datos/consulta_segmentos4.php?desde="+desde+"&hasta="+hasta+"&desde3="+desde3+"&hasta3="+hasta3+"&franquicia="+franquicia, function(htmlexterno){
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

            if(desde == '' && hasta == ''){
                window.open("datos/ex_vacio.php", '_blank');
            }

            if(franquicia == 1){
                window.open("datos/ex.php?desde="+desde+"&hasta="+hasta+"&desde3="+desde3+"&hasta3="+hasta3, '_blank');
            }
            if(franquicia == 2){
                window.open("datos/ex.php?desde="+desde+"&hasta="+hasta+"&desde3="+desde3+"&hasta3="+hasta3, '_blank');
            }
            if(franquicia == 3){
                window.open("datos/ex_ecommerce.php?desde="+desde+"&hasta="+hasta+"&desde3="+desde3+"&hasta3="+hasta3, '_blank');
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
                <li class="page-item"><a href="#" class="page-link">Consulta de Segmentos</a></li>
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
            <option value="3">Ecommerce</option>
            <option value="4">Sie7e + Ecommerce</option>
        </select>
        </div></div>
        <div class="cell-4"><div>
            <button id="btn_buscar" class="button primary cycle" onclick="buscar();"><span class="mif-search"></span></button>
            <button id="btn_excel" class="button success cycle" onclick="excel();"><span class="mif-file-excel"></span></button>
        </div></div>
    </div>

    <div class="container" id="tabla_datos">
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
                <th class="sortable-column sort-asc">EMAIL</th>
                <th class="sortable-column sort-asc">TELEFONO</th>
                <th class="sortable-column sort-asc">SEGMENTO</th>
                <th class="sortable-column sort-asc">VENTA NETA</th>
                <th class="sortable-column sort-asc">ULT. FACTURA</th>
                <th class="sortable-column sort-asc">SEG. UP</th>
                <th class="sortable-column sort-asc">SEG. DOWN</th>
            </tr>
            </thead>

            <tbody>
            <?php 
                while($row=sqlsrv_fetch_array($res)) { 
                    if($row["SEGMENTO"] == "Inactivo"){
                        $up = 4 - $row["VENTA_NETA_ACTUAL"];
                        $down = 0;
                        $inactivo++;
                    }
                    if($row["SEGMENTO"] == "Amateur"){
                        $up = 212 - $row["VENTA_NETA_ACTUAL"];
                        $down = -1*(4 - $row["VENTA_NETA_ACTUAL"]);
                        $amateur++;
                    }
                    if($row["SEGMENTO"] == "Expert"){
                        $up = 601 - $row["VENTA_NETA_ACTUAL"];
                        $down = -1*(212 - $row["VENTA_NETA_ACTUAL"]);
                        $expert++;
                    }
                    if($row["SEGMENTO"] == "Believer"){
                        $up = 1006 - $row["VENTA_NETA_ACTUAL"];
                        $down = -1*(601 - $row["VENTA_NETA_ACTUAL"]);
                        $believer++;
                    }
                    if($row["SEGMENTO"] == "Ambassador"){
                        $up = 0;
                        $down = -1*(1006 - $row["VENTA_NETA_ACTUAL"]);
                        $ambassador++;
                    }

                    if($row["ESTADO_CLIENTE"] == 'CLIENTE NUEVO'){
                        $nuevo++;
                        $color = "fg-green";
                    }

                    $fecha = $row["ULTIMA_FACTURA"];
                    $fechaComoEntero = strtotime($fecha);
                    $anio_actual = date("Y");
                    $anio_factura = date("Y", $fechaComoEntero);
                    $mes_actual = date("m");
                    $mes_anterior = $mes_actual - 1;
                    $mes_factura = date("m", $fechaComoEntero);

                    if($anio_factura < $anio_actual){
                        if($mes_factura < $mes_actual){
                            $por_inactivar++;
                            $color = "fg-red";
                        }
                    }
            ?>
            <tr>
                <td data-cls-column="<?php echo $color;?>"><?php echo $row["CEDULA_CLIENTE"]?></td>
                <td><?php echo $row["EMAIL_CLIENTE"]?></td>
                <td><?php echo $row["CELULAR_CLIENTE"]?></td>
                <td><?php echo $row["SEGMENTO"]?></td>
                <td><?php echo number_format($row["VENTA_NETA_ACTUAL"],2,',','.')?></td>
                <td><?php echo $row["ULTIMA_FACTURA"]?></td>
                <td><?php echo number_format($up,2,',','.')?></td>
                <td><?php echo number_format($down,2,',','.')?></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
            
        </table>

        <!-- <hr>
        <h4>Resumen por segmentos</h4>

        <table class="table compact striped table-border">
        <thead>
            <tr>
                <th>NUEVOS</th>
                <th>INACTIVOS</th>
                <th>POR INACTIVAR</th>
                <th>AMATEUR</th>
                <th>EXPERT</th>
                <th>BELIEVER</th>
                <th>AMBASSADOR</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $nuevo;?></td>
                <td><?php echo $inactivo;?></td>
                <td><?php echo $por_inactivar;?></td>
                <td><?php echo $amateur;?></td>
                <td><?php echo $expert;?></td>
                <td><?php echo $believer;?></td>
                <td><?php echo $ambassador;?></td>
            </tr>
        </tbody>
    </table> -->
    </div>
</div>
</body>