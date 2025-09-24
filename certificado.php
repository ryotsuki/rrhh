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

    $fecha = date('Y-m-d');
?>

<script>
    function guardar(){
        //alert("Hola");
        let fecha = $("#txt_fecha").val();
        let motivo = $("#txt_motivo").val();

        if(motivo == ''){
            var notify = Metro.notify;
            notify.create("Debe ingresar todos los datos.", "Informacion", {
                cls: "alert"
            });
            return;
        }
        else{
            $.post("datos/guarda_solicitud.php?fecha="+fecha+"&motivo="+motivo, function(htmlexterno){
            $('#tabla_datos').fadeOut('slow');
            $('#tabla_datos').fadeIn('slow');
            $("#tabla_datos").html(htmlexterno);
        });
        }
        
        //alert(fecha);
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
            <li class="page-item"><a href="#" class="page-link"><span class="mif-libreoffice"></span></a></li>
            <li class="page-item"><a href="#" class="page-link">Certificados laborales</a></li>
        </ul>
    </div>
</div>

<div class="m-3" id="">

<div id="tabla_datos">

</div>

    <div class="social-box">
        <div class="header bg-green fg-white">
            <!--<img src="images/shvarcenegger.jpg" class="avatar">-->
            <div class="title">Ingreso de solicitud de certificado laboral</div>
            <div class="subtitle">Formulario</div>
        </div>
        <ul class="skills">
            <li>
                <div class="text-bold">
                    <input disabled id="txt_fecha" type="text" data-role="calendarpicker" value="<?php echo $fecha;?>">
                </div>
                <div>Fecha de solicitud</div>
            </li>
            <li>
                <div class="text-bold">
                    <textarea id="txt_motivo" data-role="textarea"></textarea>
                </div>
                <div>Motivo solicitud</div>
            </li>
            <li>
                <div class="text-bold">
                    <button class="button success shadowed" onclick="guardar()">Enviar</button>
                </div>
            </li>
        </ul>
    </div>

</div>

<!--<div class="remark primary">
    <a href="#reporte_permisos">Ver mis permisos</a>
</div>-->

</div>

<script src="./js/charts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>