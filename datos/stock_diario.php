<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
ini_set('max_execution_time', '0'); 
//include("../validacion/validacion.php");
$conn = conectate2();
$conn2 = conectate();
$dia = 1;
$mes = 1;
$anio = 2023;
$almacen = 1;

for($i=$dia;$i<=2;$i++){
    $sql="EXEC ICG_REPORTE_STTOCK 'B".$almacen."', '".$anio."-".$mes."-".$i."'";
    $res=sqlsrv_query($conn,$sql);

    $sql2 = "SELECT DISTINCT
            MA.CODBARRAS,
            MA.CODARTICULO,
            MA.TALLA,
            MA.COLOR,
            MA.CODALMACEN0,
            MA.STOCK_2_0,
            S.FAMILIA,
            S.SUBFAMILIA,
            S.DEPARTAMENTO,
            S.SECCION,
            MA.DESCRIPCION,
            S.REFERENCIA,
            S.ALMACEN,
            S.CODMARCA,
            S.MARCA,
            S.LINEA,
            S.TEMPORADA,
            S.SILUETA,
            S.CODIGO_MAESTRO,
            S.IMPORTACION,
            S.CODFAB,
            S.PVP,
            S.COSTO,
            S.FECHA_CREACION
        FROM
            TMP_MULTIALMACEN MA,
            V_STOCK_CON_DETALLE S
        WHERE
            MA.CODARTICULO = S.CODIGO_ARTICULO
            AND MA.TALLA = S.TALLA 
            AND MA.COLOR = S.COLOR
            AND MA.CODALMACEN0 COLLATE Modern_Spanish_CI_AS = S.CODIGO_ALMACEN COLLATE Modern_Spanish_CI_AS";

    $res2=sqlsrv_query($conn,$sql2);
    while($row2=sqlsrv_fetch_array($res2)) {
        $date = $anio."-".$mes."-".$dia;
        $FECHA = date('Y-m-d',strtotime($date));
        //$FECHA = $date('Y/m/d');
        $CODBARRAS = $row2["CODBARRAS"];
        $CODARTICULO = $row2["CODARTICULO"];
        $TALLA = $row2["TALLA"];
        $COLOR = $row2["COLOR"];
        $CODALMACEN0 = $row2["CODALMACEN0"];
        $STOCK_2_0 = $row2["STOCK_2_0"];
        $FAMILIA = $row2["FAMILIA"];
        $SUBFAMILIA = $row2["SUBFAMILIA"];
        $DEPARTAMENTO = $row2["DEPARTAMENTO"];
        $SECCION = $row2["SECCION"];
        $DESCRIPCION = $row2["DESCRIPCION"];
        $REFERENCIA = $row2["REFERENCIA"];
        $ALMACEN = $row2["ALMACEN"];
        $CODMARCA = $row2["CODMARCA"];
        $MARCA = $row2["MARCA"];
        $LINEA = $row2["LINEA"];
        $TEMPORADA = $row2["TEMPORADA"];
        $SILUETA = $row2["SILUETA"];
        $CODIGO_MAESTRO = $row2["CODIGO_MAESTRO"];
        $IMPORTACION = $row2["IMPORTACION"];
        $CODFAB = $row2["CODFAB"];
        $PVP = $row2["PVP"];
        $COSTO = $row2["COSTO"];
        $FECHA_CREACION = "NULL";

        $sql3 = "
            INSERT INTO STOCK_DIARIO VALUES('".$FECHA."','".$CODBARRAS."','".$CODARTICULO."','".$TALLA."',
            '".$COLOR."','".$CODALMACEN0."',".$STOCK_2_0.",'".$FAMILIA."','".$SUBFAMILIA."','".$DEPARTAMENTO."',
            '".$SECCION."','".$DESCRIPCION."','".$REFERENCIA."','".$ALMACEN."','".$CODMARCA."','".$MARCA."','".$LINEA."',
            '".$TEMPORADA."','".$SILUETA."','".$CODIGO_MAESTRO."','".$IMPORTACION."','".$CODFAB."',".$PVP.",".$COSTO.",".$FECHA_CREACION.")
        ";
        echo $sql3;
        $res3=sqlsrv_query($conn2,$sql3);
        if($res3){
            echo "ok<br>";
        }
        else{
            echo "error<br>";
        }
    }

    //echo $sql;
}

    //echo $sql; 
    //$consulta_descripcion 
    
?>