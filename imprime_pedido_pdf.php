<?php

    include("conexion/conexion.php");
    $conn = conectate();
    session_start();
    //$id_empresa = $_SESSION['id_empresa'];
    $sql="SELECT * FROM DATOS_ARTICULOS_NB";
    $res=sqlsrv_query($conn,$sql); 

    $html='<style>
            .letra{ font-family: Verdana, Geneva, sans-serif; }
           </style>
           
           <link rel="stylesheet" href="vendors/metro4/css/metro-all.min.css">
            <link rel="stylesheet" href="css/index.css">
            <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>';


    $html.= '<h1 class="letra" align="center">Reporte de Articulos</h1><br>';

    $html.='<table class="table striped table-border mt-4" data-role="table" border="1">
        <tr class="bg-cyan fg-white">
            <th>STYLE</th>
            <th>REF</th>
            <th>GENDER</th>
        </tr>';
        
            while($row=sqlsrv_fetch_array($res)) {  
                
        
        $html.='<tr>
            <td>'.$row["style"].'</td>
            <td>'.$row["ref"].'</td>
            <td>'.$row["gender"].'</td>
        </tr>';
        
            } 
        $html.='</table>';

    $html.='<!-- jQuery first, then Metro UI JS -->
    <script src="vendors/jquery/jquery-3.4.1.min.js"></script>
    <script src="vendors/chartjs/Chart.bundle.min.js"></script>
    <script src="vendors/qrcode/qrcode.min.js"></script>
    <script src="vendors/jsbarcode/JsBarcode.all.min.js"></script>
    <!--<script src="vendors/ckeditor/ckeditor.js"></script>-->
    <script src="vendors/metro4/js/metro.min.js"></script>
    <script src="js/index.js"></script>';

    require_once __DIR__ . '/vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
    $mpdf->SetHTMLHeader('
    <div style="text-align: right; font-weight: bold;">
        Reporte de Articulos
    </div>');
    $mpdf->SetHTMLFooter('
    <table width="100%">
        <tr>
            <td width="33%">{DATE j-m-Y}</td>
            <td width="33%" align="center">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right;">Reporte de Articulos</td>
        </tr>
    </table>');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
?>