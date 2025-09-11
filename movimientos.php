<?php
    include("conexion/conexion.php");
    //include("../validacion/validacion.php");
    $conn = conectate();

    $consulta_movimientos = "SELECT 
                                S.ALMACEN_RECIBE, 
                                (SELECT SUM(V.STOCK) FROM [NOVOMODE].dbo.[V_STOCK_CON_DETALLE] V WHERE V.CODIGO_ALMACEN COLLATE Modern_Spanish_CI_AS = S.ALMACEN_RECIBE COLLATE Modern_Spanish_CI_AS) AS STOCK_ACTUAL, 
                                (SELECT SUM(V.CANTIDAD) FROM MOVIMIENTOS2 V WHERE V.CANTIDAD < 0 AND FECHA_ENVIO BETWEEN '2022-02-01T00:00:00' AND GETDATE() AND S.ALMACEN_RECIBE = V.ALMACEN_RECIBE) AS SALIDAS,
                                (SELECT SUM(V.CANTIDAD) FROM MOVIMIENTOS2 V WHERE V.CANTIDAD > 0 AND FECHA_ENVIO BETWEEN '2022-02-01T00:00:00' AND GETDATE() AND S.ALMACEN_RECIBE = V.ALMACEN_RECIBE) AS ENTRADAS 
                            FROM 
                                MOVIMIENTOS2 AS S 
                            WHERE 
                                S.ALMACEN_RECIBE IN ('C1','C2','C3','C4','C5','C6','B1','B2','B3','B4','B5','E1','B6','N1') 
                            GROUP BY 
                                S.ALMACEN_RECIBE 
                            ORDER BY 
                                S.ALMACEN_RECIBE";
    //echo $consulta_movimientos;
    $res_movimientos=sqlsrv_query($conn,$consulta_movimientos);	

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

        $( document ).ready(function() {
            $('[contenteditable]').on('paste', function(e) {
                //strips elements added to the editable tag when pasting
                var $self = $(this);
                setTimeout(function() {$self.html($self.text());}, 0);
            }).on('keypress', function(e) {
                //ignores enter key
                if(e.which != 13){
                    return e.which != 13;
                }
                else{
                    //alert("Se va a recalcular");
                    var $self = $(this);
                    //var num = $(this).html();
                    //recalcular(num);
                    this.blur();
                    return e.which != 13;
                }
            });
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
                <li class="page-item"><a href="#" class="page-link"><span class="mif-replay"></span></a></li>
                <li class="page-item"><a href="#" class="page-link">Consulta de Movimientos</a></li>
            </ul>
        </div>
    </div>

    <div class="remark primary">
        <b><u>Información de uso</u></b>: Para realizar el respectivo cálculo deseado, debe seleccionar la <b>fecha de inicio del inventario abajo (Fecha Inicial)</b>. El sistema hará el cálculo desde esa fecha <b>a la fecha actual</b>.
    </div>
    <div class="row">
        <div class="cell-3"><div>
            <input type="text" data-role="calendarpicker" data-prepend="Fecha inicial: " id="txt_fecha">
        </div></div>
        <div class="cell-3"><div>
            <button class="button primary cycle" onclick="buscar();"><span class="mif-search"></span></button>
        </div></div>
    </div>

    <div class="container" id="tabla_datos">
    <table class="table striped table-border mt-4">
    
    <thead>
    <tr>
        <th>ALMACEN</th>
        <th>STOCK INICIAL</th>
        <th>UNIDADES ENTRANTES</th>
        <th>UNIDADES SALIENTES</th>
        <th>STOCK ACTUAL</th>
        <th>STOCK FISICO</th>
        <th>DIFERENCIA</th>
    </tr>
    </thead>

    <tbody>
    <?php 
        $stock_inicial = 0;
        $stock_actual = 0;
        $compradas = 0;
        $vendidas = 0;
        while($row=sqlsrv_fetch_array($res_movimientos)) { 
            $stock_actual = $row["STOCK_ACTUAL"];
            $compradas = $row["ENTRADAS"];
            $vendidas = $row["SALIDAS"];
            $stock_inicial = $stock_actual + $vendidas - $compradas;
    ?>
    <tr style="text-align:center;">
        <td><?php echo $row["ALMACEN_RECIBE"]?></td>
        <td><?php echo $stock_inicial;?></td>
        <td><?php echo $compradas;?></td>
        <td><?php echo $vendidas;?></td>
        <td><?php echo $stock_actual;?></td>
        <td contenteditable="true">0</td>
        <td contenteditable="true">0</td>
    </tr>
    <?php
        }
    ?>
    </tbody>
    
    </table>
    </div>
</div>
</body>