<?php
    include("conexion/conexion.php");
    //include("../validacion/validacion.php");
    $conn = conectate();
    //CALCULO DE DIA, MES Y AÑO
	include("datos/dias_meses_anios.php");
	//-------------------

    $consulta_metas = "SELECT * FROM METAS WHERE mes_meta = $mes_actual AND anio_meta = $anio_actual ORDER BY local_meta";
    $res_metas=sqlsrv_query($conn,$consulta_metas);	

    //echo $consulta_metas;

    // $consulta_familias = "SELECT * FROM MARCA ORDER BY DESCRIPCION";
    // $res_marca=sqlsrv_query($conn,$consulta_marcas);
?>

<html>
<head>

    <script>
        function guardar(){

            
 
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
                <li class="page-item"><a href="#" class="page-link"><span class="mif-checkmark"></span></a></li>
                <li class="page-item"><a href="#" class="page-link">Control de Metas</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <table class="table compact table-border striped">
            <tr class="bg-cyan fg-white" style="text-align:center;">
                <th colspan="2">CARGA/MODIFICACION DE METAS DEL MES - <?php echo $mes_letras;?></th>
            </tr>
            <?php 
                while($row=sqlsrv_fetch_array($res_metas)) { 
                    $tienda = str_replace(" ", "_", $row["local_meta"]);
            ?>
            <tr>
                <th><?php echo $tienda?></th>
                <td><input type="number" style="text-align:right;" value="<?php echo $row["monto_meta"]?>" id="txt_<?php echo $tienda?>" size="10"><td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <div class="container" id="tabla_datos"></div>
</div>
</body>