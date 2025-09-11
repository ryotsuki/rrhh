<?php

error_reporting(0);
ini_set('max_execution_time', 0);
include("../conexion/conexion.php");
$conn = conectate_ppm();

$pagina = 0;
$num = 20;
$i=72;

$sql="SELECT * FROM datos";
$res=sqlsrv_query($conn,$sql);	
while($row=sqlsrv_fetch_array($res)) {
  $xkey = $row["xkey"];
  $url = $row["url_medio"];
  $referer = $row["referer"];
}

$sql_borrar="TRUNCATE TABLE productos";
$res_borrar=sqlsrv_query($conn,$sql_borrar);

$sql="SELECT access_token FROM token_actual WHERE fecha_consulta IN(SELECT MAX(fecha_consulta) FROM token_actual)";
$res=sqlsrv_query($conn,$sql);	
while($row=sqlsrv_fetch_array($res)) {
  $aut = $row["access_token"];
}

for($pagina==0;$pagina<=$i;$pagina++){
 
  //$data = array("page" => "2", "pageSize" => "20");                                                                    
  //$data_string = json_encode($data); 

  $ch = curl_init($url.'?page='.$pagina.'&pageSize='.$num.'');                                                                      
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
  //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
      'Content-Type: application/json',                                                                                
      //'Content-Length: ' . strlen($data_string),
      //"X-VTEX-API-AppKey: x-api-key",
      "Authorization: $aut",
      "x-api-key: $xkey",
      "Referer: $referer")                                                                       
  );                                                                                                                   
                                                                                                                      
  $result = curl_exec($ch);

  //echo $result;

  //$response = curl_exec($curl);

  curl_close($ch);

  $data = json_decode($result, true);

  //echo '<pre>'; print_r($data); echo '</pre>';
?>


<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">
    </head>

    <body>
        

        <?php 

            $nombre = "";
            $j=0;
            $conteo = 0;
            $id = "";

            // foreach ($data as $empresa => $departamentos) {
            //     echo "Empresa: $empresa\n";
            //     foreach ($departamentos as $departamento => $equipos) {
            //         echo "  Departamento: $departamento\n";
            //         foreach ($equipos as $equipo => $miembros) {
            //             echo "    Equipo: $equipo\n";
            //             foreach ($miembros as $miembro => $tareas) {
            //                 echo "      Miembro: $miembro\n";
            //                 foreach ($tareas as $tarea => $descripcion) {
            //                     echo "        $tarea: $descripcion\n";
            //                 }
            //             }
            //         }
            //     }
            // }

            foreach ($data as $value) {
                foreach ($value as $clave => $valor) {
                  $id_mayor = "";
                  $nombre = "";
                    //echo $clave.':'.$valor["id"]."<br>";
                    $id_mayor = (string)$valor["id"];
                    $nombre = (string)$valor["name"];
                    $variations = [];

                    //echo $id_mayor."---".$nombre."<br><br>";

                    $variations[] = $valor["variations"];
                    foreach ($variations as $varia) {
                      foreach ($varia as $key => $item) {
                        $id_menor = "";
                        $ean = "";
                        $stock = 0;
                        //echo $key.':'.$item["id"]."<br>";
                        $id_menor = $item["id"];
                        $ean = $item["reference"];
                        $stock = $item["stock"];

                        $sql = "INSERT INTO productos(id_mayor, nombre, id_menor, ean, stock) 
                        VALUES('$id_mayor','$nombre','$id_menor','$ean',$stock)";

                        //echo $sql."______<br>";

                        $result	= sqlsrv_query($conn,$sql);
                      }
                    }
                }
                // $conteo = 0;
                // $conteo = count($value["name"]);

                // for($j=0;$j<=($conteo-1);$j++){
                //   $id = $value["id"];
                //   echo $id."<br>";
                // }
            }
          }
        ?>
        <div class="container" style="text-align:center;">
            <h2><strong>El proceso ha terminado. Presione culminar para ver el resumen.</strong></h2>

            <div class="cell"><div>
                <a href="final"><button id="btn_actualizar" class="button shadowed success large">Culminar</button></a>
            </div></div>

        </div>

        <script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
    </body>
</html>