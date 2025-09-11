<?PHP
header("Content-Type: text/html;charset=utf-8");  
include("../conexion/conexion.php");
ini_set('max_execution_time', '0'); 
//include("../validacion/validacion.php");
$conn = conectate();

$almacen = $_GET["almacen"];
$desde = $_GET["desde"];
$hasta = $_GET["hasta"];
$estado = $_GET["estado"];
$genero = $_GET["genero"];
$cumple = $_GET["cumple"];
$marca = $_GET["marca"];
$familia = $_GET["familia"];
$descuento = $_GET["descuento"];

if($estado == -1){
    $consulta_estado = "";
}
if($estado == 2){
    $consulta_estado = "AND (DATEDIFF(mm,(SELECT MAX(FECHA) FROM VENTAS  WHERE V.CEDULA_RUC = CEDULA_RUC),GETDATE()) >= 9 AND DATEDIFF(mm,(SELECT MAX(FECHA) FROM VENTAS  WHERE V.CEDULA_RUC = CEDULA_RUC),GETDATE()) <= 11) OR (DATEDIFF(mm,(SELECT MAX(FECHA) FROM VENTAS  WHERE V.CEDULA_RUC = CEDULA_RUC),GETDATE()) = 11)";
}
if($estado == 1){
    $consulta_estado = "AND (DATEDIFF(mm,(SELECT MAX(FECHA) FROM VENTAS  WHERE V.CEDULA_RUC = CEDULA_RUC),GETDATE()) < 9)";
}
if($estado == 3){
    $consulta_estado = "AND (DATEDIFF(mm,(SELECT MAX(FECHA) FROM VENTAS  WHERE V.CEDULA_RUC = CEDULA_RUC),GETDATE()) > 11)";
}

if($desde != ""){
    $consulta_fecha = "AND FECHA BETWEEN '".$desde."T00:00:00' AND '".$hasta."T23:59:59'";
}
else{
    $consulta_fecha = "";
}

if($almacen != -1){
    $new_almacen = "'";
    $new_almacen.= str_replace(",", "','", $almacen);
    $new_almacen.= "'";
    $consulta_almacen = "AND V.ALMACEN IN($new_almacen)";
}
else{ 
    $consulta_almacen = "";
}

if($genero != -1){
    $consulta_genero = "AND V.SEXO = '$genero'";
}
else{ 
    $consulta_genero = "";
}

if($cumple != ""){
    $consulta_cumple = "AND DATEPART(MONTH,C.FECHANACIMIENTO) = $cumple";
}
else{ 
    $consulta_cumple = "";
}

if($marca != -1){
    $consulta_marca = "AND V.MARCA = '$marca'";
}
else{ 
    $consulta_marca = "";
}

if($familia != -1){
    $new_familia = "'";
    $new_familia.= str_replace(",", "','", $familia);
    $new_familia.= "'";
    $consulta_familia = "AND V.FAMILIA IN($new_familia)";
}
else{ 
    $consulta_familia = "";
}

if($descuento != -1){
    if($descuento == 1){
        $consulta_descuento = "AND V.DESCUENTO = 0";
    }
    else{
        $consulta_descuento = "AND V.DESCUENTO > 0";
    }
}
else{ 
    $consulta_descuento = "";
}
   
    $sql = "SELECT DISTINCT
                V.CEDULA_RUC, 
                C.CODCLIENTE,
                (SELECT MAX(CLIENTE) FROM VENTAS WHERE V.CEDULA_RUC = CEDULA_RUC) AS NOMBRE,
                CONVERT(VARCHAR,C.FECHANACIMIENTO,103) AS FECHA_NACIMIENTO,
                DATEPART(MONTH,C.FECHANACIMIENTO) AS MES_CUMPLEANOS,
                (SELECT MAX(MAIL) FROM VENTAS WHERE V.CEDULA_RUC = CEDULA_RUC) AS CORREO,
                (SELECT MAX(CELULAR) FROM VENTAS WHERE V.CEDULA_RUC = CEDULA_RUC) AS CELULAR,
                --(SELECT MAX(DIRECCION) FROM VENTAS WHERE V.CEDULA_RUC = CEDULA_RUC) AS DIRECCION,
                (SELECT MAX(SEXO) FROM VENTAS WHERE V.CEDULA_RUC = CEDULA_RUC) AS SEXO,
                --(SELECT MAX(ALMACEN) FROM VENTAS WHERE V.CEDULA_RUC = CEDULA_RUC) AS ALMACEN,
                V.ALMACEN,
                (SELECT MAX(FECHA) FROM VENTAS WHERE V.CEDULA_RUC = CEDULA_RUC) AS FECHA_ULT_FACTURA,
                DATEDIFF(mm,(SELECT MAX(FECHA) FROM VENTAS  WHERE V.CEDULA_RUC = CEDULA_RUC),GETDATE()) AS MESES_SIN_VENTAS,
                CASE
                WHEN (DATEDIFF(mm,(SELECT MAX(FECHA) FROM VENTAS  WHERE V.CEDULA_RUC = CEDULA_RUC),GETDATE()) >= 9 AND DATEDIFF(mm,(SELECT MAX(FECHA) FROM VENTAS  WHERE V.CEDULA_RUC = CEDULA_RUC),GETDATE()) <= 11) THEN 'POR INACTIVAR'
                WHEN (DATEDIFF(mm,(SELECT MAX(FECHA) FROM VENTAS  WHERE V.CEDULA_RUC = CEDULA_RUC),GETDATE()) > 11)  THEN 'INACTIVO'
                WHEN (DATEDIFF(mm,(SELECT MAX(FECHA) FROM VENTAS  WHERE V.CEDULA_RUC = CEDULA_RUC),GETDATE()) < 9)  THEN 'ACTIVO'
                WHEN (DATEDIFF(mm,(SELECT MAX(FECHA) FROM VENTAS  WHERE V.CEDULA_RUC = CEDULA_RUC),GETDATE()) = 11)  THEN 'POR INACTIVAR'
                END AS ESTADO,
                SUM(V.CANTIDAD_VTA) AS UNIDADES,
                COUNT(DISTINCT NUMERO_DOCUMENTO) AS FRECUENCIA,
                (SUM(VTA_NETA)/NULLIF(SUM(CANTIDAD_VTA),0))*(SUM(CANTIDAD_VTA)/NULLIF(COUNT(DISTINCT NUMERO_DOCUMENTO),0)) AS VPT,
                (SUM(CANTIDAD_VTA)/NULLIF(COUNT(DISTINCT NUMERO_DOCUMENTO),0)) AS UPT,
                --T.IDTIPOTARJETA AS SEGMENTO
                CASE 
                WHEN V.ALMACEN LIKE '%CH %' AND T.IDTIPOTARJETA IN(4,5,6,7) THEN T.IDTIPOTARJETA
                WHEN (V.ALMACEN LIKE '%SIETE %' OR V.ALMACEN LIKE '%SUR%' OR V.ALMACEN LIKE '%ECOM%' OR V.ALMACEN LIKE '%POP%') AND T.IDTIPOTARJETA IN(9,10,11,12) THEN T.IDTIPOTARJETA
                END AS SEGMENTO
            FROM 
                VENTAS V LEFT JOIN
                [NOVOMODE].dbo.[TARJETAS] AS T ON T.ALIAS COLLATE Modern_Spanish_CI_AS = V.CEDULA_RUC COLLATE Modern_Spanish_CI_AS INNER JOIN
                [NOVOMODE].dbo.[CLIENTES] AS C ON C.NIF20 COLLATE Modern_Spanish_CI_AS = V.CEDULA_RUC COLLATE Modern_Spanish_CI_AS INNER JOIN
                [NOVOMODE].dbo.[CLIENTESCAMPOSLIBRES] AS C2 ON C.CODCLIENTE = C2.CODCLIENTE
            WHERE 
                1=1
                $consulta_estado
                $consulta_fecha
                $consulta_almacen
                $consulta_genero
                $consulta_cumple
                $consulta_marca
                $consulta_familia
                $consulta_descuento
            GROUP BY 
                CEDULA_RUC, C.FECHANACIMIENTO, T.IDTIPOTARJETA, C.CODCLIENTE, V.ALMACEN
            ORDER BY 
                CODCLIENTE";

    
    $res=sqlsrv_query($conn,$sql);	

   // echo $sql;

?> 

<table class="table striped table-border mt-4 compact" data-role="table"
        id="tabla"
        data-rownum="true"
        data-search-min-length="3"
        data-rows-steps="5,10,20,50,100,200"
        data-table-rows-count-title="Mostrar:"
        data-table-search-title="Buscar:"
        data-table-info-title="Mostrando de $1 a $2 de $3 resultados"
        data-pagination-prev-title="Ant"
        data-pagination-next-title="Sig"
>
    <thead>
    <tr>
        <th class="sortable-column">CEDULA</th>
        <th class="sortable-column">CODCLIENTE</th>
        <th class="sortable-column">NOMBRE</th>
        <th class="sortable-column">FEC. NAC.</th>
        <th class="sortable-column">MES CUMPLE</th>
        <th class="sortable-column">CORREO</th>
        <th class="sortable-column">CELULAR</th>
        <th class="sortable-column">GENERO</th>
        <th class="sortable-column">ALMACEN</th>
        <th class="sortable-column">FEC. ULT. FAC.</th>
        <th class="sortable-column">MESES SIN FAC.</th>
        <th class="sortable-column">ESTADO</th>
        <th class="sortable-column">UNIDADES</th>
        <th class="sortable-column">FRECUENCIA</th>
        <th class="sortable-column">SEGMENTO</th>
        <th class="sortable-column">VPT</th>
        <th class="sortable-column">UPT</th>
    </tr>
    </thead>

    <tbody>
    <?php 
        while($row=sqlsrv_fetch_array($res)) { 

            $segmento = "";

            if($row["SEGMENTO"] == 4){
                $segmento = "AMATEUR";
            }
            if($row["SEGMENTO"] == 5){
                $segmento = "EXPERT";
            }
            if($row["SEGMENTO"] == 6){
                $segmento = "BELIEVER";
            }
            if($row["SEGMENTO"] == 7){
                $segmento = "AMBASSADOR";
            }
            if($row["SEGMENTO"] == 9){
                $segmento = "FRIEND";
            }
            if($row["SEGMENTO"] == 10){
                $segmento = "BEST FRIEND";
            }
            if($row["SEGMENTO"] == 11){
                $segmento = "PARTNER";
            }
            if($row["SEGMENTO"] == 12){
                $segmento = "ICON";
            }

            if($segmento != "NULL" && $segmento != ""){
    ?>
    <tr>
        <td><?php echo $row["CEDULA_RUC"]?></td>
        <td><?php echo $row["CODCLIENTE"]?></td>
        <td><?php echo $row["NOMBRE"]?></td>
        <td><?php echo $row["FECHA_NACIMIENTO"]?></td>
        <td><?php echo $row["MES_CUMPLEANOS"]?></td>
        <td><?php echo $row["CORREO"]?></td>
        <td><?php echo $row["CELULAR"]?></td>
        <td><?php echo $row["SEXO"]?></td>
        <td><?php echo $row["ALMACEN"]?></td>
        <td><?php echo date_format($row["FECHA_ULT_FACTURA"],'Y-m-d');?></td>
        <td><?php echo $row["MESES_SIN_VENTAS"]?></td>
        <td><?php echo $row["ESTADO"]?></td>
        <td><?php echo $row["UNIDADES"]?></td>
        <td><?php echo $row["FRECUENCIA"]?></td>
        <td><?php echo $segmento?></td>
        <td><?php echo $row["VPT"]?></td>
        <td><?php echo $row["UPT"]?></td>
    </tr>
    <?php
        }}
    ?>
    </tbody>
</table>