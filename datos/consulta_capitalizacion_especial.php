<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
ini_set('max_execution_time', '0');
//include("../validacion/validacion.php");
$conn = conectate();

$mes_actual = date("m");
$mes_anterior = $mes_actual - 1;
$anio_actual = date("Y");
$anio_anterior = $anio_actual - 1;

$desde = $_GET["desde"];
$hasta = $_GET["hasta"];

$newDesde = date("d/m/Y", strtotime($desde)); 
$newHasta = date("d/m/Y", strtotime($hasta)); 

$desde3 = $_GET["desde3"];
$hasta3 = $_GET["hasta3"];

$newDesde2 = date("d/m/Y", strtotime($desde3)); 
$newHasta2 = date("d/m/Y", strtotime($hasta3));

$desde2 = $desde."T00:00:00";
$hasta2 = $hasta."T23:59:59";
$desde4 = $desde3."T00:00:00";
$hasta4 = $hasta3."T23:59:59";

$desdenew = $anio_actual."-".date("m",strtotime($hasta3))."-01T00:00:00";
$desdenew2 = $anio_actual."-".date("m",strtotime($hasta3))."-01";

$clientes_nuevos = 0;
$clientes_recuperados = 0;
$clientes_base = 0;
$venta_nuevos = 0;
$venta_recuperados = 0;
$venta_base = 0;

session_start(); 

    $sql= "SELECT DISTINCT
    CEDULA_RUC,
	(SELECT COUNT(DISTINCT NUMERO_DOCUMENTO) WHERE FECHA BETWEEN '$desdenew' AND '$hasta4') AS FACTURAS, 
	(SELECT SUM(VTA_NETA) WHERE FECHA BETWEEN '$desdenew' AND '$hasta4') AS VENTA,
	FECHA_MODIFICACION,
	(select COUNT(distincT (NUMERO_DOCUMENTO))
	from VENTAS
	where FECHA between '$desde2' and '$hasta2'
	and CEDULA_RUC = a.CEDULA_RUC
	group by CEDULA_RUC) as PeSOLdo1,

	(select COUNT(distincT (NUMERO_DOCUMENTO))
	from VENTAS
	where FECHA between '$desde4' and '$hasta4'
	and CEDULA_RUC = a.CEDULA_RUC
	group by CEDULA_RUC) as PeSOLdo2,
	case
	when (select COUNT(distincT (NUMERO_DOCUMENTO))
	from VENTAS
	where FECHA between '$desde2' and '$hasta2'
	and CEDULA_RUC = a.CEDULA_RUC
	group by CEDULA_RUC) is not NULL and (select COUNT(distincT (NUMERO_DOCUMENTO))
	from VENTAS
	where FECHA between '$desde4' and '$hasta4'
	and CEDULA_RUC = a.CEDULA_RUC
	group by CEDULA_RUC) is not NULL then 'Mismo Cliente'
	when (select COUNT(distincT (NUMERO_DOCUMENTO))
	from VENTAS
	where FECHA between '$desde2' and '$hasta2'
	and CEDULA_RUC = a.CEDULA_RUC
	group by CEDULA_RUC) is NULL and (select COUNT(distincT (NUMERO_DOCUMENTO))
	from VENTAS
	where FECHA between '$desde4' and '$hasta4'
	and CEDULA_RUC = a.CEDULA_RUC
	group by CEDULA_RUC) is not NULL then 'Nuevo o Recuperado'
	when (select COUNT(distincT (NUMERO_DOCUMENTO))
	from VENTAS
	where FECHA between '$desde2' and '$hasta2'
	and CEDULA_RUC = a.CEDULA_RUC
	group by CEDULA_RUC) is not NULL and (select COUNT(distincT (NUMERO_DOCUMENTO))
	from VENTAS
	where FECHA between '$desde4' and '$hasta4' 
	and CEDULA_RUC = a.CEDULA_RUC
	group by CEDULA_RUC) is NULL then 'Inactivo' end AS ESTADO
	from VENTAS a
	where FECHA between '$desde2' and '$hasta4'
	AND
	ALMACEN LIKE '%NEW BALANCE%'
	GROUP BY CEDULA_RUC,FECHA,FECHA_MODIFICACION";
    //echo $sql."<BR>";
    //exit;
    $res=sqlsrv_query($conn,$sql);

    while($row=sqlsrv_fetch_array($res)) { 
        $estado = $row["ESTADO"];
        $facturas = $row["FACTURAS"];
        $fecha = date_format($row["FECHA_MODIFICACION"],"Y-m-d");
        //echo $fecha;

        //FACTURAS MISMOS CLIENTES
        if($estado == "Mismo Cliente" && $facturas > 0){
           $clientes_base++;
           $venta_base+=$row["VENTA"];
        }

        if($estado == "Nuevo o Recuperado" && $facturas > 0){

            //NUEVOS CLIENTES
            if($fecha >= $desdenew2 && $fecha <= $hasta3){
                $clientes_nuevos++;
                $venta_nuevos+=$row["VENTA"];
            }

            //CLIENTES RECUPERADOS
            else{
                $clientes_recuperados++;
                $venta_recuperados+=$row["VENTA"];
            }
        }
    }
//echo $sql;

?>

- Nuevos: <?php echo $clientes_nuevos." - ".$venta_nuevos?><br>
Base: <?php echo $clientes_base." - ".$venta_base?><br>
Recuperados: <?php echo $clientes_recuperados." - ".$venta_recuperados?><br>
- Base + Recuperados: <?php echo ($clientes_recuperados + $clientes_base)." - ".($venta_recuperados + $venta_base)?><br>