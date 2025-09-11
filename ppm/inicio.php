<?php

ini_set('max_execution_time', 0);
include("../conexion/conexion.php");
$conn = conectate_ppm();

$sql="SELECT * FROM datos";
$res=sqlsrv_query($conn,$sql);	
while($row=sqlsrv_fetch_array($res)) {
  $client = $row["client_id"];
  $secret = $row["client_secret"];
  $xkey = $row["xkey"];
  $url = $row["url_inicio"]; 
  $referer = $row["referer"];
}

$data = array("grant_type" => "client_credentials", "client_id" => "$client", "client_secret" => "$secret");                                                                    
$data_string = json_encode($data);                                                                                   
                                                                                                                     
$ch = curl_init($url);                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string),
    //"X-VTEX-API-AppKey: x-api-key",
    "x-api-key: $xkey",
    "Referer: $referer")                                                                       
);                                                                                                                   
                                                                                                                     
$result = curl_exec($ch);

//echo $result;

//$response = curl_exec($curl);

curl_close($ch);

$data = json_decode($result, true);

//echo '<pre>'; print_r($data); echo '</pre>';
//exit;

?>

<html>
    <head>
        <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    </head>

    <body>
        
        <!-- <table class="table striped table-border cell-border compact">
            <tr>
                <th>TOKEN</th>
                <th>DURACION</th>
                <th>FECHA Y HORA</th>
            </tr> -->
        <?php 
            $i = 0;
            foreach ($data as $value) {
                //echo 'indice es '.$key.' y el valor es '.$value;
                //if($key == 'access_token'){
                if($i == 0){
                    $token = $value;
                }
                if($i == 2){
                    $duracion = $value;
                }
                    
                //}
                //if($key == 'expires_in'){
                    
                //}
                //else{
                    //$duracion = 3600;
                //}

                $i++; 
                }

                $fecha = date("Y-m-d H:i:s");

                 $consulta = "INSERT INTO token_actual(access_token,duracion,fecha_consulta) 
                 VALUES('$token',$duracion,GETDATE())";

                 $result	= sqlsrv_query($conn,$consulta);

                //echo "<br>".$consulta;
            ?>

                <!-- <tr>
                    <td><?php echo $token?></td>
                    <td><?php echo $duracion?></td>
                    <td><?php echo $fecha?></td>
                </tr>
            </table> -->
            <div class="container" style="text-align:center;">
                <div class="m-3">
                    <h2><strong>Integración<strong></h2>
                    <div class="cell">
                        <table class="table subcompact" style="text-align:center;">
                            <tr>
                                <th>
                                    <div class="img-container rounded">
                                        <img src="../images/logos/novomode.png" width="50" height="50">
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th><div><span class="mif-cross mif-2x"></span></div></th>
                            </tr>
                            <tr>
                                <th>
                                    <div class="img-container rounded">
                                        <img src="../images/logos/ppm.gif" width="50" height="50">
                                    </div>
                                </th>
                            </tr>
                        </table>
                    <div>
                        <hr>
                    <div class="cell">
                        <a href="intermedio"><button id="btn_actualizar" class="button shadowed primary large">Comenzar</button></a>
                    </div>
                </div>
            </div>

        <script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
    </body>
</html>