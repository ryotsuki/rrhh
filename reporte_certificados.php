<?php
    //ini_set('display_errors', 'Off');
    include("conexion/conexion.php");
    
    session_start();
    $username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
    $id_usuario = $_SESSION['id_usuario'];

    //echo "Username: ".$username;
    $conn = conectate();

    $consulta = "SELECT id_cargo FROM usuario WHERE id_usuario = $id_usuario";
    $res2 = $conn->query($consulta);
    while($row=mysqli_fetch_array($res2)) {
        $id_cargo = $row["id_cargo"];
    }

    $opcion_cambio = "";

    if($id_cargo == 5 || $_SESSION['cargo'] == 6){
        $sql="SELECT * FROM v_certificado";
        $opcion_cambio = "onclick='actualizar($id_certificado)'";
    }
    else{
        $sql="SELECT * FROM v_certificado WHERE id_usuario = $id_usuario";
    }

    
    $res = $conn->query($sql);
    //$res=sqlsrv_query($conn,$sql);	

    //echo $sql; 
    //$consulta_descripcion 
?>

<script src="js/guarda_estado_certificado.js" type="text/javascript"></script>

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
            <li class="page-item"><a href="#" class="page-link"><span class="mif-libreoffice"></span></a></li>
            <li class="page-item"><a href="#" class="page-link">Certificados laborales</a></li>
            <input type="hidden" value="<?php echo $id_usuario?>" id="txt_id_usuario">
        </ul>
    </div>
</div>

<div class="m-3" id="">

<div id="tabla_datos">

</div>

    <table class="table striped table-border mt-4 compact"
       data-role="table"
       data-rows="5"
       data-rows-steps="5, 10"
       data-show-activity="false"
       data-rownum="true"
>

<thead>
    <th>ID</th>
    <th>Usuario</th>
    <th>Identificacion</th>
    <th>Cargo</th>
    <th>Ubicacion</th>
    <th>Fecha certificado</th>
    <th>Motivo</th>
    <th>Fecha elaborado</th>
    <th>Estado</th>
    <th>Aprobado por</th>
</thead>

<tbody>
    <?php 
        while($row=mysqli_fetch_array($res)) {
            $id_certificado = 0;
            $id_certificado = $row["id_certificado"];
            $color = "";
            $estado = $row["descripcion_estado_solicitud"];
            if($estado == "APROBADA"){
                $color = "fg-blue";
            }
            if($estado == "INGRESADA"){
                $color = "fg-warning";
            }
            if($estado == "DENEGADA"){
                $color = "fg-red";
            }
    ?>
    <tr>
        <td><a href="datos/certificado_pdf?id_certificado=<?php echo $row["id_certificado"]?>" target="_blank"><?php echo $row["id_certificado"];?></a></td>
        <td><?php echo $row["nombre_usuario"];?></td>
        <td><?php echo $row["cedula_usuario"];?></td>
        <td><?php echo $row["descripcion_cargo"];?></td>
        <td><?php echo $row["descripcion_ubicacion"];?></td>
        <td><?php echo $row["fecha_registro"];?></td>
        <td><?php echo $row["motivo_certificado"];?></td>
        <td><?php echo $row["fecha_registro"];?></td>
        <td class="<?php echo $color;?>"><a href="#" <?php echo $opcion_cambio; ?> ><?php echo $estado;?></a></td>
        <td><?php echo $row["usuario_aprobador"];?></td>
    </tr>
    <?php 
        }
    ?>
</tbody>

</table>

</div>

</div>

<script src="./js/charts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>