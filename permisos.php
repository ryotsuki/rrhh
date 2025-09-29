<?php
    //ini_set('display_errors', 'Off');
    include("conexion/conexion.php");
    
    session_start();
    $username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
    //echo "Username: ".$username;
    $conn = conectate();

    $consulta_tipos = "SELECT * FROM tipo_permiso";
    $res = $conn->query($consulta_tipos);



	include("datos/dias_meses_anios.php");
    include("datos/buscar_usuarios.php");
    include("datos/buscar_permisos.php");
    include("datos/buscar_vacaciones.php");
?>

<script>
    function guardar(){
        //alert("Hola");
        let fecha = $("#txt_fecha").val();
        let inicio = $("#txt_inicio").val();
        let fin = $("#txt_fin").val();
        let observaciones = $("#txt_observacion").val();
        let tipo = $("#cbo_tipo").val();

        if(fecha == '' || inicio == '' || fin == '' || observaciones == ''){
            var notify = Metro.notify;
            notify.create("Debe ingresar todos los datos.", "Informacion", {
                cls: "alert"
            });
            return;
        }
        else{
            $.post("datos/guarda_permiso.php?fecha="+fecha+"&inicio="+inicio+"&fin="+fin+"&observaciones="+observaciones+"&tipo="+tipo, function(htmlexterno){
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
        <h3 class="dashboard-section-title  text-center text-left-md w-100">HITALENT <small>Version 1.0</small></h3>
        <?php //}else{ ?>
        <!--<img src="<?php echo $logo;?>" width="300" height="80"/>-->
        <?php //} ?>
    </div>

    <div class="cell-md-8 d-flex flex-justify-center flex-justify-end-md flex-align-center">
        <ul class="breadcrumbs bg-transparent">
            <li class="page-item"><a href="#" class="page-link"><span class="mif-assignment"></span></a></li>
            <li class="page-item"><a href="#" class="page-link">Permisos</a></li>
        </ul>
    </div>
</div>

<div class="m-3" id="">

<div id="tabla_datos">

</div>

    <div class="social-box">
        <div class="header bg-green fg-white">
            <!--<img src="images/shvarcenegger.jpg" class="avatar">-->
            <div class="title">Ingreso de solicitud de permisos</div>
            <div class="subtitle">Formulario</div>
        </div>
        <ul class="skills">
            <li>
                <div class="text-bold">
                    <input id="txt_fecha" type="text" data-role="calendarpicker">
                </div>
                <div>Fecha de solicitud</div>
            </li>
            <li>
                <div class="text-bold">
                    <input id="txt_inicio" data-role="timepicker" data-seconds="false">
                </div>
                <div>Hora de inicio</div>
            </li>
            <li>
                <div class="text-bold">
                    <input id="txt_fin" data-role="timepicker" data-seconds="false">
                </div>
                <div>Hora de fin</div>
            </li>
        </ul>
        <ul class="skills">
            <li>
                <div class="text-bold">
                    <select data-role="select" id="cbo_tipo">
                        <?php while($row=mysqli_fetch_array($res)) { 
                            $id = $row["id_tipo_permiso"];
                            $descripcion = $row["descripcion_tipo_permiso"];
                        ?>
                        <option value='<?php echo $id;?>'> <?php echo $descripcion;?> </option>
                        <?php } ?>
                        <optgroup label="Permisos">
                            <option value="1">PARTICULAR</option>
                            <option value="2">CITA MEDICA</option>
                        </optgroup>
                        <optgroup label="Licencias">
                            <option value="3">MATRIMONIO O UNION DE HECHO</option>
                            <option value="4">CALAMIDAD DOMESTICA</option>
                            <option value="5">MATERNIDAD O PATERNIDAD</option>
                            <option value="6">ESTUDIOS O VIAJE</option>
                            <option value="7">ENFERMEDAD</option>
                            <option value="9">CRUCE DE HORAS</option>
                        </optgroup>
                        <option value="8">OTRO</option>
                    </select>
                </div>
                <div>Tipo de permiso</div>
            </li>
            <li>
                <div class="text-bold">
                    <textarea id="txt_observacion" data-role="textarea"></textarea>
                </div>
                <div>Observaciones</div>
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