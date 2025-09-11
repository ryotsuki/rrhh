<?php

    include("conexion/conexion.php");
    $conn = conectate(); 
    session_start();
    $id_pedido = $_GET['pedido'];
    $sql="SELECT * FROM CABECERA_PEDIDO_ETA WHERE id_pedido = $id_pedido";
    $res=sqlsrv_query($conn,$sql); 
    while($row=sqlsrv_fetch_array($res)) {  
        $empresa = $row["empresa"];
        $comprador = $row["comprador"];
        $correo = $row["correo"];
        $valor = $row["valor_pedido"];
        $pares = $row["cantidad_pares"];
        $referencias = $row["cantidad_referencias"];
    }

    $sql1="SELECT * FROM PEDIDO_ETA WHERE id_pedido = $id_pedido AND a+b+cc+em+t+w+g+p+i > 0";
    $res1=sqlsrv_query($conn,$sql1); 

    $html='<style>
            .letra{ font-family: Verdana, Geneva, sans-serif; }
           </style>
           
           <link rel="stylesheet" href="vendors/metro4/css/metro-all.min.css">
            <link rel="stylesheet" href="css/index.css">
            <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>';


    $html.= '<h1 class="letra" align="center">Datos del Pedido Número '.$id_pedido.'</h1><br>';

    $html.= '<h2 class="letra" align="center">Datos Generales</h2><br>';

    $html.='<table class="table striped table-border mt-4" data-role="table" border="1">
        <tr class="bg-cyan fg-white">
            <th>EMPRESA</th>
            <th>COMPRADOR</th>
            <th>CORREO</th>
        </tr>';
        
            //while($row=sqlsrv_fetch_array($res)) {  
                
        
        $html.='<tr>
            <td>'.$empresa.'</td>
            <td>'.$comprador.'</td>
            <td>'.$correo.'</td>
        </tr>';

        $html.='
        <tr class="bg-cyan fg-white">
            <th>VALOR DEL PEDIDO($)</th>
            <th>CANTIDAD DE PARES</th>
            <th>CANTIDAD DE REFERENCIAS</th>
        </tr>';

        $html.='<tr>
            <td>'.$valor.'</td>
            <td>'.$pares.'</td>
            <td>'.$referencias.'</td>
        </tr>';
        
           // } 
        $html.='</table>';

        $html.= '<h2 class="letra" align="center">Detalles del Pedido</h2><br>';

        $html.='<table class="table striped table-border mt-4" data-role="table" border="1">
        <tr class="bg-cyan fg-white">
            <th>REFERENCIA</th>
            <th>PRECIO</th>
            <th>A</th>
            <th>B</th>
            <th>CC</th>
            <th>EM</th>
            <th>T</th>
            <th>W</th>
            <th>G</th>
            <th>P</th>
            <th>I</th>
            <th>TOTAL</th>
            <th>VALOR($)</th>
        </tr>';

        $suma = 0;
        while($row=sqlsrv_fetch_array($res1)) { 
            
            $suma = $row["a"] + $row["b"] + $row["cc"] + $row["em"] + $row["t"] + $row["w"] + $row["g"] + $row["p"] + $row["i"];

            $html.='<tr>
            <td>'.$row["referencia"].'</td>
            <td>'.$row["precio"].'</td>
            <td>';
                if($row["a"] == 0){ 
                    $html.='-'; 
                }else{ 
                    $html.=$row["a"]; 
                }
            $html.='</td>
            <td>';
                if($row["b"] == 0){ 
                    $html.='-'; 
                }else{ 
                    $html.=$row["b"]; 
                }
            $html.='</td>
            <td>';
                if($row["cc"] == 0){ 
                    $html.='-'; 
                }else{ 
                    $html.=$row["cc"]; 
                }
            $html.='</td>
            <td>';
                if($row["em"] == 0){ 
                    $html.='-'; 
                }else{ 
                    $html.=$row["em"]; 
                }
            $html.='</td>
            <td>';
                if($row["t"] == 0){ 
                    $html.='-'; 
                }else{ 
                    $html.=$row["t"]; 
                }
            $html.='</td>
            <td>';
                if($row["w"] == 0){ 
                    $html.='-'; 
                }else{ 
                    $html.=$row["w"]; 
                }
            $html.='</td>
            <td>';
                if($row["g"] == 0){ 
                    $html.='-'; 
                }else{ 
                    $html.=$row["g"]; 
                }
            $html.='</td>
            <td>';
                if($row["p"] == 0){ 
                    $html.='-'; 
                }else{ 
                    $html.=$row["p"]; 
                }
            $html.='</td>
            <td>';
                if($row["i"] == 0){ 
                    $html.='-'; 
                }else{ 
                    $html.=$row["i"]; 
                }
            $html.='</td>
            <th>'.$suma.'</th>
            <th>'.($suma*12)*$row["precio"].'</th>
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
        Datos del Pedido
    </div>');
    $mpdf->SetHTMLFooter('
    <table width="100%">
        <tr>
            <td width="33%">{DATE j-m-Y}</td>
            <td width="33%" align="center">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right;">Datos del Pedido</td>
        </tr>
    </table>');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
?>