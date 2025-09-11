<?php

error_reporting(0);
ini_set('max_execution_time', 0);
include("../conexion/conexion.php");
$conn = conectate_ppm();

$pagina = 0;
$num = 10;
$i=1;

$sql="SELECT * FROM datos";
$res=sqlsrv_query($conn,$sql);	
while($row=sqlsrv_fetch_array($res)) {
  $xkey = $row["xkey"];
  $url = $row["url_final"];
  $referer = $row["referer"];
}

$sql="SELECT access_token FROM token_actual WHERE fecha_consulta IN(SELECT MAX(fecha_consulta) FROM token_actual)";
$res=sqlsrv_query($conn,$sql);	
while($row=sqlsrv_fetch_array($res)) {
  $aut = $row["access_token"];
}

$consulta = "SELECT
            P.id_mayor AS PRODUCTO_PPM,
            P.id_menor AS INTERNO_PPM,
            P.ean AS CODIGO_PPM,
            P.stock AS STOCK_PPM,
            S.CODIGO_BARRAS AS BARRAS_ICG,
            SUM(S.STOCK) AS STOCK_ICG
            FROM
            PPM.dbo.productos AS P INNER JOIN
            NOVOMODE.dbo.V_STOCK_CON_DETALLE S ON P.ean COLLATE Modern_Spanish_CI_AS = S.CODIGO_BARRAS COLLATE Modern_Spanish_CI_AS
            --WHERE p.ean = '7704803034622'
            WHERE S.CODIGO_ALMACEN IN('B2','B3','B4','B5','B7','B8','BA','BB','C1','C2','C3','C5','C6','C7','N1','N2','N3','PQ1')
            GROUP BY
            P.id_mayor, P.id_menor, P.EAN, P.stock, S.CODIGO_BARRAS";

$res=sqlsrv_query($conn,$consulta);
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">
    </head>
    <body>

        <div class="container" style="text-align:center;">
            <h4>Resumen de actualización.</h4>
            <hr>
            <table class="table compact striped table-border mt-4" data-role="table"
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
                    <!--<th>ID PRODUCTO</th>
                    <th>ID VARIACION</th>-->
                    <th>CODBARRAS</th>
                    <th class="sortable-column sort-asc">STOCK PREVIO</th>
                    <th class="sortable-column sort-asc">STOCK NUEVO</th>
                    <th class="sortable-column sort-asc">ENVIADO</th>
                </tr>
                </thead>
                <tbody>
            

<?php
while($row=sqlsrv_fetch_array($res)) {
  $enviar = "SI";
  $id_mayor = $row["PRODUCTO_PPM"];
  $id_menor = $row["INTERNO_PPM"];
  $stock = ($row["STOCK_ICG"]-3);
  //$stock = 0;
  $stock_previo = $row["STOCK_PPM"];
  $barras = $row["BARRAS_ICG"];

  if($stock < 0){
    $stock = 0;
  }

  if($stock == $stock_previo){
    $enviar = "NO";
  }

?>
            <tr>
                <!--<td><?php echo $id_mayor?></td>
                <td><?php echo $id_menor?></td>-->
                <td><?php echo $barras?></td>
                <td><?php echo $stock_previo?></td>
                <td><?php echo $stock?></td>
                <td><?php echo $enviar?></td>
            </tr>


<?php

$result = "";

  if($enviar == "SI"){
    $data = array(
            array("variationId" => "$id_menor", "stock" => $stock)
        );                                                                   
        $data_string = json_encode($data);  
        //echo $data;   
        //echo $url.$id_mayor.'/variations';                                                                           
                                                                                                                            
        $ch = curl_init($url.$id_mayor.'/variations');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string),
            //"X-VTEX-API-AppKey: x-api-key",
            "Authorization: $aut",
            "x-api-key: $xkey",
            "Referer: $referer")                                                                       
        );                                                                                                                   
                                                                                                                            
        $result = curl_exec($ch);
    }

    //echo $result;
    }

?>

        </tbody>
        </table>
        </div>
        <script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
    </body>
</html>