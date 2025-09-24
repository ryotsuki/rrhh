<?php
    //ini_set('display_errors', 'Off');
    include("conexion/conexion.php");
    
    session_start();
    $username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
    $cedula = $_SESSION['cedula_usuario'];

    //echo "Username: ".$username;
    $conn = conectate();

    $consulta = "SELECT id_cargo FROM usuario WHERE cedula_usuario = '$cedula'";
    $res2 = $conn->query($consulta);
    while($row=mysqli_fetch_array($res2)) {
        $id_cargo = $row["id_cargo"];
    }

    if($id_cargo == 8 || $id_cargo == 5){
        $sql="SELECT DISTINCT cedula, DATE_FORMAT(fecha, '%m-%Y') AS fecha, nombre, SUM(valor) AS total FROM nomina WHERE cuenta = '999LIQUIDO A RECIBIR' AND YEAR(fecha) = 2025 GROUP BY cedula, fecha, nombre";
    }
    else{
        $sql="SELECT DISTINCT cedula, DATE_FORMAT(fecha, '%m-%Y') AS fecha, nombre, SUM(valor) AS total FROM nomina WHERE cuenta = '999LIQUIDO A RECIBIR' AND cedula = '$cedula' AND YEAR(fecha) = 2025  GROUP BY cedula, fecha, nombre";
    }

    //echo $sql;
    $res = $conn->query($sql);
    //$res=sqlsrv_query($conn,$sql);	

    //echo $sql; 
    //$consulta_descripcion 
?>

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
            <li class="page-item"><a href="#" class="page-link"><span class="mif-dollar2"></span></a></li>
            <li class="page-item"><a href="#" class="page-link">Roles de Pago</a></li>
            <input type="hidden" value="<?php echo $cedula?>" id="txt_cedula">
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
    <th class="sortable-column sort-asc">CEDULA</th>
    <th class="sortable-column sort-asc">NOMBRE</th>
    <th class="sortable-column sort-asc">FECHA</th>
    <th class="sortable-column sort-asc">VALOR</th>
</thead>

<tbody>
    <?php 
        while($row=mysqli_fetch_array($res)) {
    ?>
    <tr>
        <td><?php echo $row["cedula"];?></td>
        <td><?php echo $row["nombre"];?></td>
        <td><a href="roldepago3?fecha=<?php echo $row["fecha"]?>&cedula=<?php echo $row["cedula"]?>" target="_blank"><?php echo $row["fecha"];?></a></td>
        <td><?php echo number_format($row["total"],2,',','.');?></td>
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