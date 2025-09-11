<?PHP
header("Content-Type: text/html;charset=utf-8");
include("conexion/conexion.php");
//include("../validacion/validacion.php"); 
$conn = conectate2();

$documento = $_GET["documento"];

$sql = "UPDATE FACTURASVENTAFIRMA SET ESTADO2 = 0 WHERE SERIE = 'AVF' AND NUMERO = $documento";
//$res=sqlsrv_query($conn,$sql);
//echo $sql;	

$res=sqlsrv_query($conn,$sql);

$respuesta = "";
$color = "";

if($res){
    $respuesta = "El documento $documento ha sido regenerado, espere unos minutos para ver el PDF.";
    $color = "success";
}
else{
    $respuesta = "Algo salió mal. Verifique los datos ingresados.";
    $color = "alert";
}
//echo $respuesta;
//return;
?>

<div class="remark <?php echo $color;?>">
    <?php echo $respuesta;?>
</div>

<script>
    setTimeout(function(){
        window.location.reload();
    }, 7000);
</script>