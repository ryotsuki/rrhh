<?php
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
//include("../validacion/validacion.php"); 
session_start();
$conn = conectate();
//require('../fpdf/fpdf.php');
require('mysql_table.php');

$cedula = $_GET["cedula"];
$fecha = $_GET["fecha"];
$fecha2 = explode('-',$fecha);
$anio = $fecha2[1];
$mes = $fecha2[0];

$sql = "SELECT tipo, cuenta, valor FROM nomina WHERE cedula = '$cedula' AND YEAR(fecha) = $anio AND MONTH(fecha) = $mes AND cuenta = '999LIQUIDO A RECIBIR'";
$res = $conn->query($sql);
class PDF extends PDF_MySQL_Table
{
function Header()
{
    // Title
    $this->Image('../images/logos/crocs_logo.png',10,8,33);
    $this->SetFont('Arial','',18);
    $this->Cell(0,6,'Rol de pago',0,1,'C');
    $this->Ln(10);
    // Ensure table header is printed
    parent::Header();
}
}

// Connect to database

$pdf = new PDF();
$pdf->AddPage('0');
// First table: output all columns
$pdf->Table($conn,"SELECT tipo, SUBSTRING(cuenta, 4) as cuenta, valor FROM nomina WHERE cedula = '$cedula' AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$mes' ORDER BY valor");
//$pdf->AddPage();
// Second table: specify 3 columns
$pdf->AddCol('rank',20,'','C');
$pdf->AddCol('name',40,'Country');
$pdf->AddCol('pop',40,'Pop (2001)','R');
$prop = array('HeaderColor'=>array(255,150,100),
            'color1'=>array(210,245,255),
            'color2'=>array(255,255,210),
            'padding'=>2);
//$pdf->Table($link,'select name, format(pop,0) as pop, rank from country order by rank limit 0,10',$prop);
$pdf->Output();
?>
?>