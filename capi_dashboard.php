<?php
    ini_set('display_errors', 'Off');
    include("conexion/conexion.php");
    
    session_start();
    $username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
    //echo "Username: ".$username;

    $mes = "";
    $anio = "";
    $filtro_tienda = "AND ALMACEN LIKE 'CH %' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE 'SIE%' OR ALMACEN LIKE 'NEW%'";

    $conn = conectate();

    if(strpos($username, "CH ") !== false) {
        $filtro_tienda = "AND ALMACEN = '$username'";
    }
    if(strpos($username, "SIE") !== false || strpos($username, "SUR") !== false) {
        $filtro_tienda = "AND ALMACEN = '$username'";
    }
    if(strpos($username, "NEW") !== false) {
        $filtro_tienda = "AND ALMACEN = '$username'";
    }

    $consulta_almacenes = "SELECT DISTINCT ALMACEN FROM VENTAS WHERE 1=1 $filtro_tienda ORDER BY ALMACEN";
    $res_almacen=sqlsrv_query($conn,$consulta_almacenes);
    
    $consulta_almacenes2 = "SELECT DISTINCT ALMACEN FROM VENTAS WHERE 1=1 $filtro_tienda ORDER BY ALMACEN";
    $res_almacen2=sqlsrv_query($conn,$consulta_almacenes2);

    $consulta_almacenes3 = "SELECT DISTINCT ALMACEN FROM VENTAS WHERE 1=1 $filtro_tienda ORDER BY ALMACEN";
    $res_almacen3=sqlsrv_query($conn,$consulta_almacenes3);
    //echo $consulta_almacenes;
    //CALCULO DE DIA, MES Y AÑO
	include("datos/dias_meses_anios.php");
	//-------------------

    //CALCULO DE VENTAS X ALMACEN
    include("datos/capitalizacion_x_almacen.php");
    //----------------------

    //GRAFICOS DE DONA
    include("datos/donas_capi.php");
    //----------------------

    $ocultar1 = "";
    $ocultar2 = "";
    $ocultar3 = "";
    $logo = "";

    if(strpos($username, "CH") !== false) {
        $ocultar1 = "style='display:none;'";
        $ocultar2 = "style='display:none;'";
        $logo = "images/curvas/CHEVIGNON N.png";
    }
    if(strpos($username, "SIE") !== false) {
        $ocultar1 = "style='display:none;'";
        $ocultar3 = "style='display:none;'";
        $logo = "images/curvas/SIE7E BLACK.png";
    }
    if(strpos($username, "NEW") !== false) {
        $ocultar1 = "style='display:none;'";
        $ocultar2 = "style='display:none;'";
        $ocultar3 = "style='display:none;'";
        $logo = "images/curvas/new-balance-logo.png";
    }
    
?>

<div class="row border-bottom bd-lightGray m-3">
    <div class="cell-md-4 d-flex flex-align-center">
        <?php if($logo ==""){ ?>
        <h3 class="dashboard-section-title  text-center text-left-md w-100">Novomode CP <small>Version 1.5</small></h3>
        <?php }else{ ?>
        <img src="<?php echo $logo;?>" width="300" height="80"/>
        <?php } ?>
    </div>

    <div class="cell-md-8 d-flex flex-justify-center flex-justify-end-md flex-align-center">
        <ul class="breadcrumbs bg-transparent">
            <li class="page-item"><a href="#" class="page-link"><span class="mif-meter"></span></a></li>
            <li class="page-item"><a href="#" class="page-link">Dashboard CRM</a></li>
        </ul>
    </div>
</div>

<div class="m-3">

<div data-role="panel" data-title-caption="GRAFICOS DE VENTAS" data-collapsible="true" data-title-icon="<span class='mif-chart-line'></span>" class="mt-4">
<div class="row">
    <div class="cell-lg-4 cell-md-6 mt-2" <?php echo $ocultar1;?>>
        <div class="remark primary" style="align:center;">
            Facturas de clientes Nuevos
        </div>
        <div id="grafico_ventas_mes" style="height: 250px;"></div>
        <div>
        <table class="table striped table-border mt-4">
                <tr style="text-align:center;">
                    <th>ALMACEN</th>
                    <th>MONTO</th>
                </tr>
                <tr>
                <?php while($row=sqlsrv_fetch_array($res_ventas_nuevos)) { ?>
                    <td><?php echo $row["tienda"]?></td>
                    <td>$ <?php echo number_format($row["dinero"],2,',','.')?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="cell-lg-4 cell-md-6 mt-2" <?php echo $ocultar3;?>>
        <div class="remark primary" style="align:center;">
            Facturas de mismos clientes
        </div>
        <div id="grafico_ventas_mes_chevignon" style="height: 250px;"></div>
        <div>
            <table class="table striped table-border mt-4">
                <tr style="text-align:center;">
                    <th>ALMACEN</th>
                    <th>MONTO</th>
                </tr>
                <tr>
                <?php while($row=sqlsrv_fetch_array($res_ventas_mismos)) { ?>
                    <td><?php echo $row["tienda"]?></td>
                    <td>$ <?php echo number_format($row["dinero"],2,',','.')?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="cell-lg-4 cell-md-6 mt-2" <?php echo $ocultar2;?>>
        <div class="remark primary" style="align:center;">
            Facturas de Clientes Recuperados
        </div>
        <div id="grafico_ventas_mes_siete" style="height: 250px;"></div>
        <div>
            <table class="table striped table-border mt-4">
                <tr style="text-align:center;">
                    <th>ALMACEN</th>
                    <th>MONTO</th>
                </tr>
                <tr>
                <?php while($row=sqlsrv_fetch_array($res_ventas_recuperados)) { ?>
                    <td><?php echo $row["tienda"]?></td>
                    <td>$ <?php echo number_format($row["dinero"],2,',','.')?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</div>

</div>

<script src="./js/charts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<script>
    Morris.Donut({
        element : 'grafico_ventas_mes',
        data:[<?php echo $grafico_nuevos; ?>],
    });

    Morris.Donut({
        element : 'grafico_ventas_mes_siete',
        data:[<?php echo $grafico_recuperados; ?>],
    });

    Morris.Donut({
        element : 'grafico_ventas_mes_chevignon',
        data:[<?php echo $grafico_mismos; ?>],
    });

    new Chart(document.getElementById("line-chart"), { 
    type: 'line',
    data: {
        labels: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
        datasets: [{ 
            data: <?php echo json_encode($ventas_xmes_actual) ?>,
            label: <?php echo json_encode($anio_actual);?>,
            backgroundColor: "rgba(7, 189, 232, 0.1)",
            borderColor: "#3e95cd",
            fill: true
        }, { 
            data: <?php echo json_encode($ventas_xmes_anterior) ?>,
            label: <?php echo json_encode($anio_anterior);?>,
            backgroundColor: "rgba(133, 8, 255, 0.2)",
            borderColor: "#8e5ea2",
            fill: true
        }, { 
            data: <?php echo json_encode($ventas_xmes_menosdos) ?>,
            label: <?php echo json_encode($anio_menosdos);?>,
            backgroundColor: "rgba(96, 169, 23, 0.2)",
            borderColor: "#60A917",
            fill: true
        }
        , { 
            data: <?php echo json_encode($ventas_xmes_menostres) ?>,
            label: <?php echo json_encode($anio_menostres);?>,
            backgroundColor: "rgba(255, 93, 0, 0.2)",
            borderColor: "#E15D00",
            fill: true
        }
        ]
    },
    options: {
        title: {
        display: true,
        text: 'Comparacion de ventas anio actual y anterior.'
        }
    }
    });
</script>