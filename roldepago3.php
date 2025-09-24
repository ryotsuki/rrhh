<?php
header("Content-Type: text/html;charset=utf-8");
include("conexion/conexion.php");
//include("../validacion/validacion.php"); 
session_start();
$conn = conectate();
//require('../fpdf/fpdf.php');
//require('mysql_table.php');

$cedula = $_GET["cedula"];
$fecha = $_GET["fecha"];
$fecha2 = explode('-',$fecha);
$anio = $fecha2[1];
$mes = $fecha2[0];

$sql = "SELECT tipo, cuenta, valor, nombre FROM nomina WHERE cedula = '$cedula' AND YEAR(fecha) = $anio AND MONTH(fecha) = $mes AND cuenta = '999LIQUIDO A RECIBIR'";
$ingresos = "SELECT SUBSTRING(cuenta, 4) as cuenta, valor FROM nomina WHERE cedula = '$cedula' AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$mes' AND tipo = 'I'";
$egresos = "SELECT SUBSTRING(cuenta, 4) as cuenta, valor FROM nomina WHERE cedula = '$cedula' AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$mes' AND tipo = 'D'";


$res = $conn->query($sql);
$numero_filas = mysqli_num_rows($res);
	
	if($numero_filas){
	
		while($row=mysqli_fetch_array($res)) {
            //$usuario = $row["id_certificado"];
            $nombre = $row["nombre"];
            $total = $row["valor"];
        }
    }

$res_ingresos = $conn->query($ingresos);
$filas_ingresos = mysqli_num_rows($res_ingresos);
$res_egresos = $conn->query($egresos);
$filas_egresos = mysqli_num_rows($res_egresos);
?>

<!DOCTYPE html>
<html lang="en" class=" scrollbar-type-1 sb-cyan">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Metro 4 -->
    <link rel="stylesheet" href="vendors/metro4/css/metro-all.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <title>Semper - Roles de pago</title>
</head>
<body class="bg-white">

<div class="social-box">
        <div class="header bg-white fg-black">
            <!--<img src="images/shvarcenegger.jpg" class="avatar">-->
            <div class="title">SEMPER DE ECUADOR S.A.<br></div>
            <div class="subtitle">
                QUITO<br>
                Av.6 de diciembre y Paul Rivet . Edificio Josuet piso 5<br>
            </div>  
            <div class="title">
                PLANILLA INDIVIDUAL AL <?php echo $fecha;?>
            </div>
        </div>
</div>
<table class="table-border table striped">
    <th>
        <?php echo $cedula." - ".$nombre;?>
        <br>
        Provincia: Pichincha
        <br>
        Oficina: Principal
    </th>
</table>

<hr>

<div class="row">
    <div class="cell-3" style="text-align:center"><div>
        <div class="header bg-white fg-black subtitle">INGRESOS</div>
        <div>
            <?php
                if($filas_ingresos){

                    $total_ingresos = 0;
                
                    while($row=mysqli_fetch_array($res_ingresos)) {
                        //$usuario = $row["id_certificado"];
                        $cuenta = $row["cuenta"];
                        $valor = $row["valor"];

                        $total_ingresos+=$valor; 

                        echo $cuenta.": ".number_format($valor,2,',','.')."<br>";
                    }
                }
            ?>
            <hr>
            <strong>Total ingresos: <?php echo number_format($total_ingresos,2,',','.')?></strong>
        </div>
    </div></div>
    <div class="cell-3" style="text-align:center"><div>
        <div class="header bg-white fg-black subtitle">DESCUENTOS</div>
        <div>
            <?php
                if($filas_egresos){

                    $total_egresos = 0;
                
                    while($row=mysqli_fetch_array($res_egresos)) {
                        //$usuario = $row["id_certificado"];
                        $cuenta = $row["cuenta"];
                        $valor = $row["valor"];

                        $total_egresos+=$valor; 

                        echo $cuenta.": ".number_format($valor,2,',','.')."<br>";
                    }
                }
            ?>
            <hr>
            <strong>Total descuentos: <?php echo number_format($total_ingresos,2,',','.')?></strong>
        </div>
    </div></div>
    <div class="cell-6" style="text-align:center"><div>
        <div class="header bg-white fg-black subtitle">NETO A RECIBIR</div>
        <div class="header bg-white fg-black subtitle"><strong><?php echo number_format($total,2,',','.')?></strong></div>
    </div></div>
</div>

<br><br><br>
<br><br><br>

<div class="row">
    <div class="cell-3" style="text-align:center"><div>
        <div>
            <hr>
        </div>
        <div class="header bg-white fg-black">ELABORADO</div>
    </div></div>
    <div class="cell-3" style="text-align:center"><div>
        <div>
            <hr>
        </div>
        <div class="header bg-white fg-black">AUTORIZADO</div>
    </div></div>
    <div class="cell-6" style="text-align:center"><div>
        <div>
            <hr>
        </div>
        <div class="header bg-white fg-black">RECIBO CONFORME</div>
        <div>
            <?php echo "C.I. ".$cedula; ?>
        </div>
    </div></div>
</div>

<!-- jQuery first, then Metro UI JS -->
<script src="vendors/jquery/jquery-3.4.1.min.js"></script>
<script src="vendors/chartjs/Chart.bundle.min.js"></script>
<script src="vendors/qrcode/qrcode.min.js"></script>
<script src="vendors/jsbarcode/JsBarcode.all.min.js"></script>
<!--<script src="vendors/ckeditor/ckeditor.js"></script>-->
<script src="vendors/metro4/js/metro.min.js"></script>
<script src="js/index.js"></script>

</body>
</html>