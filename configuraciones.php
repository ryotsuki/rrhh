<?php
    //ini_set('display_errors', 'Off');
    include("conexion/conexion.php");
    
    session_start();
    $username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
    //echo "Username: ".$username;
    $conn = conectate();

	include("datos/dias_meses_anios.php");
    include("datos/buscar_usuarios.php");
    include("datos/buscar_permisos.php");
    include("datos/buscar_vacaciones.php");
?>

<script>
    function ubicaciones(){
        $.post("ubicaciones_config", function(htmlexterno){
            $('#tabla_datos').fadeOut('slow');
            $('#tabla_datos').fadeIn('slow');
            $("#tabla_datos").html(htmlexterno);
        })
    }

    function cargos(){
        $.post("cargos", function(htmlexterno){
            $('#tabla_datos').fadeOut('slow');
            $('#tabla_datos').fadeIn('slow');
            $("#tabla_datos").html(htmlexterno);
        })
    }

    function usuarios(){

        alert("No habilitado aun");
        $.post("usuarios", function(htmlexterno){
            $('#tabla_datos').fadeOut('slow');
            $('#tabla_datos').fadeIn('slow');
            $("#tabla_datos").html(htmlexterno);
        })
    }
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
            <li class="page-item"><a href="#" class="page-link"><span class="mif-tools"></span></a></li>
            <li class="page-item"><a href="#" class="page-link">Configuraciones</a></li>
        </ul>
    </div>
</div>

<div class="m-3" id="">

<button class="button success shadowed" onclick="ubicaciones()">Ubicaciones</button>
<button class="button success shadowed" onclick="cargos()">Cargos</button>
<button class="button success shadowed" onclick="usuarios()">Usuarios</button>

<div id="tabla_datos" class="m-3">

</div>

</div>

</div>

<script src="./js/charts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>