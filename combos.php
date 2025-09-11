<?php
   header("Pragma: public");
   header("Expires: 0");
   $filename = "combos.xls";
   header("Content-type: application/x-msdownload");
   header("Content-Disposition: attachment; filename=$filename");
   header("Pragma: no-cache");
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   include("conexion/conexion.php");
   ini_set('max_execution_time', '0'); 
   //include("../validacion/validacion.php");
   $conn = conectate();

   $sql1 = "SELECT DISTINCT NUMERO_DOCUMENTO FROM VENTAS 
            WHERE 
                FECHA BETWEEN '2022-06-06T00:00:00' AND '2022-06-13T23:59:59' AND 
                ALMACEN LIKE '%CH %' AND PORC_VTA_DESC = 100.00";

    // echo $sql;
    // exit;
   $res=sqlsrv_query($conn,$sql1);
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
</head>

<body>

<div class="container">
    <?php 
        $documento = "";
        while($row=sqlsrv_fetch_array($res)) {
            $documento = $row["NUMERO_DOCUMENTO"];
    ?>

        <table class="table striped table-border mt-4 compact">
            <tr>
                <th colspan="3">
                    <?php 
                        echo $row["NUMERO_DOCUMENTO"];
                    ?>
                </th>
                <?php
                    $sql2 = "SELECT DISTINCT
                                FAMILIA,
                                PORC_VTA_DESC
                            FROM 
                                VENTAS 
                            WHERE 
                                NUMERO_DOCUMENTO = '$documento'
                            GROUP BY 
                                FAMILIA, PORC_VTA_DESC";
                            $res2=sqlsrv_query($conn,$sql2);
                            //echo $sql2;

                            $jean = 0;
                            $no = 0;
                            while($row2=sqlsrv_fetch_array($res2)) {
                                // $familia = $row2["FAMILIA"];

                                // $buscar   = 'JEAN';
                                // $buscar_jean = strrpos($familia, $buscar);
                                // if ($buscar_jean === false) {
                                //     $no = 0;
                                // }
                                // else{
                                //     $jean++;
                                // }
                ?>
                <tr>
                    <td><?php echo $row2["FAMILIA"];?></td>
                    <td><?php echo "DESC: ".$row2["PORC_VTA_DESC"];?></td>
                    <?php if($row2["PORC_VTA_DESC"] == 100.00){?>
                        <td><?php echo "REGALO";?></td>
                    <?php }else{ ?>
                        <td>&nbsp;</td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </tr>
        </table>

    <?php 
        } 
    ?>
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