<?php
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
//include("../validacion/validacion.php");
session_start();
$conn = conectate();
require('../fpdf/fpdf.php');

$cedula = $_GET["cedula"];
$fecha = $_GET["fecha"];
$fecha2 = explode('-',$fecha);
$anio = $fecha2[1];
$mes = $fecha2[0];

$sql = "SELECT * FROM nomina WHERE cedula = '$cedula' AND YEAR(fecha) = $anio AND MONTH(fecha) = $mes AND cuenta = '999LIQUIDO A RECIBIR'";
$res = $conn->query($sql);
$numero_filas = mysqli_num_rows($res);
	
	if($numero_filas){
	
		while($row=mysqli_fetch_array($res)) {
            //$usuario = $row["id_permiso"];
            $nombre = $row["nombre"];
            //$titulo = 
        }
    }

$cuerpo= "
<b>Nombre del trabajador:</b> <i>$nombre</i><br><br>
<b>Identificacion del trabajador:</b> <i>$cedula</i><br><br>
<b>Fecha:</b> <i>$fecha</i><br><br>

<hr>
<br><br>

<div style='text-align:center;'>
    <table style='text-align:center;' border='1'>
        <tr>
            <th>INGRESOS</th>
            <th>DEDUCCIONES</th>
        </tr>
";

$sql2 = "SELECT * FROM nomina WHERE cedula = '$cedula' AND YEAR(fecha) = $anio AND MONTH(fecha) = $mes";
$res2 = $conn->query($sql2);
$numero_filas2 = mysqli_num_rows($res2);
	
	if($numero_filas2){
	
		while($row2=mysqli_fetch_array($res2)) {
            $cuenta = $row2["cuenta"];
            $valor = $row2["valor"];

            $cuerpo.="
                <tr>
                    <td>".$cuenta.": ".$valor."</td>
                </tr>
                </table>
                </div>
            ";
        }
    }

/*
La presente solicitud es presentada por <b><u>$usuario</u></b>, con cedula de identidad Numero <b><u>$cedula</u></b>, con cargo <b><u>$cargo</u></b> perteneciente a <b><u>$ubicacion</u></b>, 
quien indica que necesita el tiempo de <b><u>$tiempo</u></b> horas entre las <b><u>$inicio</u></b> y las <b><u>$fin</u></b> el dia <b><u>$fecha_solicitud</u></b>, con la siguiente observacion: <b><u>$observaciones</u></b>.

<br><br>
La fecha de elaboracion es el: <b><u>$fecha_registro</u></b>.<br>
El estado de la solicitud es: <b><u>$estado</u></b>.<br>
Solicitud aprobada por: <b><u>$aprobador</u></b>.<br>
*/


class PDF extends FPDF
{

    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    function WriteHTML($html)
    {
        // HTML parser
        $html = str_replace("\n",' ',$html);
        $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                // Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    $this->Write(5,$e);
            }
            else
            {
                // Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    // Extract attributes
                    $a2 = explode(' ',$e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        // Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF = $attr['HREF'];
        if($tag=='BR')
            $this->Ln(5);
    }

    function CloseTag($tag)
    {
        // Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable)
    {
        // Modify style and select corresponding font
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach(array('B', 'I', 'U') as $s)
        {
            if($this->$s>0)
                $style .= $s;
        }
        $this->SetFont('',$style);
    }

    function PutLink($URL, $txt)
    {
        // Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../images/logos/crocs_logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'                           Rol de Pago','C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetTitle('Rol de pago '.$cedula.' - '.$fecha);
$pdf->AddPage('0');
$pdf->SetFont('Times','',12);
$pdf->WriteHTML($cuerpo);
$pdf->Output();
?>