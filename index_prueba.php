<?php
    include("conexion/conexion.php");

    $conn = conectate();

    $sql="SELECT TOP 10 * FROM VENTAS ORDER BY FECHA;";
    $res=sqlsrv_query($conn,$sql);
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

    <title>Pandora - Admin template build with Metro 4</title>

</head>
<body class="h-vh-100">
<?php
    while($row=sqlsrv_fetch_array($res)) {
        echo $row['NUMERO_DOCUMENTO']."<br>";
        echo $row['VTA_NETA']."<br>";
        echo $row['VENDEDOR']."<br>";
    } 
?>

<!-- jQuery first, then Metro UI JS -->
<script src="vendors/jquery/jquery-3.4.1.min.js"></script>
<script src="vendors/chartjs/Chart.bundle.min.js"></script>
<script src="vendors/qrcode/qrcode.min.js"></script>
<script src="vendors/jsbarcode/JsBarcode.all.min.js"></script>
<script src="vendors/ckeditor/ckeditor.js"></script>
<script src="vendors/metro4/js/metro.min.js"></script>
<script src="js/index.js"></script>
</body>
</html>