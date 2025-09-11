<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
//include("../validacion/validacion.php");
session_start();
$conn = conectate2();

//CALCULO DE DIA, MES Y AÑO
include("dias_meses_anios.php");
//-------------------

$username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
$filtro_tienda = ""; 

$txt_id = $_GET["txt_id"];
$txt_monto = $_GET["txt_monto"];
$txt_cedula = $_GET["txt_cedula"];
$txt_obs = $_GET["txt_obs"];
$alias = $txt_id." - CREADO POR ".$username;

$sql = "INSERT INTO [dbo].[TARJETAS]
            ([IDTARJETA]
            ,[CODCLIENTE]
            ,[POSICION]
            ,[IDTIPOTARJETA]
            ,[DESCRIPCION]
            ,[CADUCIDAD]
            ,[VALIDA]
            ,[SALDOTARJETA]
            ,[ENTREGADA]
            ,[OBSERVACIONES]
            ,[ALIAS]
            ,[USUARIO]
            ,[PASSWORD]
            ,[CODMONEDA])
            VALUES
            ($txt_id,
            0,
            1,
            2,
            '$txt_cedula',
            '2030-12-31T00:00:00',
            'T',
            $txt_monto,
            'T',
            '$txt_obs',
            '$alias',
            '',
            '',
            0
            )";
    $res=sqlsrv_query($conn,$sql);
    //echo $sql;

    echo "<h3>CODIGO GENERADO: $txt_id</h3>";

    //echo $username;

?>