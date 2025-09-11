<?php
    //ini_set('display_errors', 'Off');
    include("conexion/conexion.php");
    
    session_start();
    $username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
    //echo "Username: ".$username;

    $mes = "";
    $anio = "";
    $filtro_tienda = "AND ALMACEN LIKE 'CH %' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE 'SIE%' OR ALMACEN LIKE 'NEW%'";

    $conn = conectate();

    //echo $consulta_almacenes; 
    //CALCULO DE DIA, MES Y AÑO
	include("datos/dias_meses_anios.php");
	//-------------------

    //VENTAS DE AÑO ACTUAL - MES ACTUAL - DIA ACTUAL
    //include("datos/ventas_anio_actual.php");
    //----------------------

    //VENTAS DE AÑO ANTERIOR - MES ANTERIOR - DIA ANTERIOR
    include("datos/buscar_usuarios.php");
    include("datos/buscar_permisos.php");
    include("datos/buscar_vacaciones.php");
    //----------------------

    //VENTAS DE 2 AÑO ANTERIOR - MES ANTERIOR - DIA ANTERIOR
    //include("datos/ventas_aniomenos2.php");
    //----------------------

    //VENTAS DE 3 AÑO ANTERIOR - MES ANTERIOR - DIA ANTERIOR
    //include("datos/ventas_aniomenostres.php");
    //----------------------

    //CALCULO DE PORCENTAJES
    //include("datos/calculo_porcentajes.php");
    //----------------------

    //CALCULO DE VENTAS X ALMACEN
    //include("datos/ventas_x_almacen.php");
    //----------------------

    //GRAFICOS DE DONA
    //include("datos/graficos_dona.php");
    //----------------------
    //echo $consulta_ventas_mes_grafico_chevignon;

    //TOP 8 VENDEDORES
    //include("datos/top_vendedores.php");
    //----------------------

    //TODOS LOS VENDEDORES
    //include("datos/todos_vendedores.php");
    //----------------------

    //PORCENTAJES DE CUMPLIMIENTO
    //include("datos/porcentaje_cumplimiento.php");
    //----------------------

    //REPORTE DE UNIDADES POR VENDEDOR Y CANTIDAD
    //include("datos/reporte_unidades.php");
    //----------------------

    //CONSULTA DE TRAFICO DEL DIA
    //include("datos/trafico_del_dia.php");
    //----------------------

    //REPORTE DE C/S DESCUENTO POR VENDEDOR
    //include("datos/reporte_cs_descuento.php");
    //----------------------

    //REPORTE DE BONOS 
    //include("datos/reporte_bono.php");
    //----------------------

    //CUMPLEAÑOS
    //include("datos/cumpleanos.php");
    //----------------------
?>

<style>
    .modal-contenido{
    background-color:white;
    width:600px;
    padding: 10px 20px;
    margin: 20% auto;
    position: relative;
    }
    .modal{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    top:0;
    right:0;
    bottom:0;
    left:0;
    opacity:0;
    pointer-events:none;
    transition: all 1s;
    }
    #miModal:target{
    opacity:1;
    pointer-events:auto;
    }
</style>

<script>
</script>

<div class="row border-bottom bd-lightGray m-3">
    <div class="cell-md-4 d-flex flex-align-center">
        <?php //if($logo ==""){ ?>
        <h3 class="dashboard-section-title  text-center text-left-md w-100">Semper CP <small>Version 1.0</small></h3>
        <?php //}else{ ?>
        <!--<img src="<?php echo $logo;?>" width="300" height="80"/>-->
        <?php //} ?>
    </div>

    <div class="cell-md-8 d-flex flex-justify-center flex-justify-end-md flex-align-center">
        <ul class="breadcrumbs bg-transparent">
            <li class="page-item"><a href="#" class="page-link"><span class="mif-meter"></span></a></li>
            <li class="page-item"><a href="#" class="page-link">Dashboard Inicial</a></li>
        </ul>
    </div>
</div>

<div class="m-3">

<div data-role="panel" data-title-caption="" data-collapsible="true" data-title-icon="<span class='mif-user'></span>" class="mt-4">
<div class="row">
    <div data-role="accordion" data-material="true">
        <div class="frame active">
            <div class="heading">RESUMEN GENERAL</div>
            <div class="content">
                <div class="p-2">
                <div class="row">
                    <div class="cell-lg-3 cell-md-6 mt-2">
                        <div class="more-info-box bg-cyan fg-white">
                            <div class="content">
                                <h2 class="text-bold mb-0"><?php echo $usuarios_totales;?></h2>
                                <div>Usuarios totales registrados</div>
                            </div>
                            <div class="icon">
                                <span class="mif-user"></span>
                            </div>
                            <a href="#" class="more"> Más info <span class="mif-arrow-right"></span></a>
                        </div>
                    </div>
                    <div class="cell-lg-3 cell-md-6 mt-2">
                        <div class="more-info-box bg-green fg-white">
                            <div class="content">
                                <h2 class="text-bold mb-0"><?php echo $cantidad_permisos;?></h2>
                                <div>Permisos pendientes</div>
                            </div>
                            <div class="icon">
                                <span class="mif-assignment"></span>
                            </div>
                            <a href="#reporte_permisos" class="more"> Más info <span class="mif-arrow-right"></span></a>
                        </div>
                    </div>
                    <div class="cell-lg-3 cell-md-6 mt-2">
                        <div class="more-info-box bg-orange fg-white">
                            <div class="content">
                                <h2 class="text-bold mb-0"><?php echo $cantidad_vacaciones;?></h2>
                                <div>Vacaciones pendientes</div>
                            </div>
                            <div class="icon">
                                <span class="mif-airplane"></span>
                            </div>
                            <a href="#" class="more"> Más info <span class="mif-arrow-right"></span></a>
                        </div>
                    </div>
                    <!--<div class="cell-lg-3 cell-md-6 mt-2">
                        <div class="more-info-box bg-red fg-white">
                            <div class="content">
                            <h2 class="text-bold mb-0"><?php echo $venta_dia_anterior;?></h2>
                                <div><?php echo $date_future;?> (Ayer)</div>
                            </div>
                            <div class="icon">
                                <span class="mif-dollar2"></span>
                            </div>
                            <a href="#" class="more"> Más info <span class="mif-arrow-right"></span></a>
                        </div>
                    </div>-->
                </div>
                </div>
                </div>
            </div>
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
        data:[<?php echo $grafico_ventas_mes; ?>],
    });

    Morris.Donut({
        element : 'grafico_ventas_mes_siete',
        data:[<?php echo $grafico_ventas_mes_siete; ?>],
    });

    Morris.Donut({
        element : 'grafico_ventas_mes_chevignon',
        data:[<?php echo $grafico_ventas_mes_chevignon; ?>],
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