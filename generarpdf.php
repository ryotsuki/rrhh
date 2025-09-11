<?php

ini_set('max_execution_time', 0);
include("conexion/conexion.php");
$conn = conectate2();

// $sql="SELECT * FROM datos";
// $res=sqlsrv_query($conn,$sql);	
// while($row=sqlsrv_fetch_array($res)) {
//   $client = $row["client_id"];
//   $secret = $row["client_secret"];
//   $xkey = $row["xkey"];
//   $url = $row["url_inicio"]; 
//   $referer = $row["referer"];
// }
?>

<html>
    <head>
        <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <script>
            function valideKey(evt){
                    
                // code is the decimal ASCII representation of the pressed key.
                var code = (evt.which) ? evt.which : evt.keyCode;
                
                if(code==8) { // backspace.
                return true;
                } else if(code>=46 && code<=57) { // is a number.
                return true;
                } else{ // other keys.
                return false;
                }
            }

            function reprocesar(){
                let documento = $("#txt_documento").val();
                //alert(documento);
                //return;
                if(documento == "" || documento < 0){
                    Metro.infobox.create("<p><h2><b>Debe ingresar un documento valido.</b></h2></p>", "alert");
                    return;
                }
                else{
                    $.post("generarpdf2.php?documento="+documento, function(htmlexterno){
                        //$("#confirmacion").html(htmlexterno);
                        $("#tabla_datos").html(htmlexterno);
                        $("#txt_documento").val("");
                    });
                }
            }
        </script>
    </head>

    <body>
    <div class="container" style="text-align:center;">
        <div class="m-3">
            <h2><strong>Generador de PDF<strong></h2>
            <div class="row">
            <div class="cell-7"><div>
                <input type="number" onkeypress="return valideKey(event);" maxlength="4" data-role="material-input" data-label="NUMERO:" placeholder="Ingrese numero de documento" id="txt_documento">
            </div></div>
            </div>
            <div class="cell">
                <button class="button success" onclick="reprocesar();">Actualizar</button>
            </div>
        </div>
    </div>

    <div id="tabla_datos">

    </div>

        <script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
    </body>
</html>