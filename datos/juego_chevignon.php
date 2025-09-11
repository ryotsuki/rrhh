<?PHP
include_once('PHPMailer/src/Exception.php');
include_once('PHPMailer/src/PHPMailer.php');
include_once('PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
//include("../validacion/validacion.php");
$conn = conectate2();
$conn2 = conectate();


    //echo $sql; 
    //$consulta_descripcion 

// $sql3 = "SELECT 
//             F.CODCLIENTE,
//             C.E_MAIL,
//             C.NOMBRECLIENTE,
//             F.NUMFACTURA,
//             F.NUMSERIE,
//             F.TOTALNETO,
//             FC.CODIGO_JUEGO
//             FROM
//             FACTURASVENTA F,
//             FACTURASVENTACAMPOSLIBRES FC,
//             CLIENTES C
//             WHERE 
//             F.NUMSERIE = FC.NUMSERIE AND 
//             F.NUMFACTURA = FC.NUMFACTURA AND
//             C.CODCLIENTE = F.CODCLIENTE AND
//             F.NUMSERIE LIKE 'C%F%' AND
//             F.TOTALNETO >= 50 AND
//             (FC.CODIGO_JUEGO IS NULL OR FC.CODIGO_JUEGO = '') AND
//             F.FECHA BETWEEN '2023-07-26T00:00:00' AND GETDATE()";

$sql3 = "SELECT DISTINCT
                F.NUMFACTURA,
                F.CODCLIENTE,
                C.E_MAIL,
                C.NOMBRECLIENTE,
                F.NUMSERIE,
                F.TOTALNETO,
                FC.CODIGO_JUEGO,
                A2.CODALMACEN
            FROM
                FACTURASVENTA F,
                ALBVENTACAB A1,
                ALBVENTALIN A2,
                FACTURASVENTACAMPOSLIBRES FC,
                CLIENTES C
            WHERE 
                F.NUMSERIE = FC.NUMSERIE AND 
                F.NUMFACTURA = FC.NUMFACTURA AND
                C.CODCLIENTE = F.CODCLIENTE AND
                (A1.NUMSERIE = A2.NUMSERIE AND A1.NUMALBARAN = A2.NUMALBARAN AND A1.NUMSERIEFAC = F.NUMSERIE AND A1.NUMFAC = F.NUMFACTURA) AND
                (A2.CODALMACEN IN ('A8','C1','C2','C3','C4','C5','C6','C7')) AND
                F.TOTALNETO >= 50 AND
                (FC.CODIGO_JUEGO IS NULL OR FC.CODIGO_JUEGO = '') AND
                F.FECHA BETWEEN '2023-07-26T00:00:00' AND GETDATE()";

echo $sql3;
$res3=sqlsrv_query($conn,$sql3);

while($row=sqlsrv_fetch_array($res3)) { 
    $cliente = $row["CODCLIENTE"];
    $factura = $row["NUMFACTURA"];
    $serie = $row["NUMSERIE"];
    $monto = $row["TOTALNETO"];
    $correo = $row["E_MAIL"];
    $nombre = $row["NOMBRECLIENTE"];

    if($monto >= 50 && $monto <= 99){
        $sql2 = "SELECT MAX(id_cupon) AS id_cupon, numero_cupon FROM CH_CUPONES_JUEGO WHERE cod_cliente = '' OR cod_cliente IS NULL AND tipo_cupon = 1 GROUP BY numero_cupon";
    }
    if($monto >= 100 && $monto <= 249){
        $sql2 = "SELECT MAX(id_cupon) AS id_cupon, numero_cupon FROM CH_CUPONES_JUEGO WHERE cod_cliente = '' OR cod_cliente IS NULL AND tipo_cupon = 2 GROUP BY numero_cupon";
    }
    if($monto >= 250){
        $sql2 = "SELECT MAX(id_cupon) AS id_cupon, numero_cupon FROM CH_CUPONES_JUEGO WHERE cod_cliente = '' OR cod_cliente IS NULL AND tipo_cupon = 3 GROUP BY numero_cupon";
    }

    //echo $sql2;
    
    $res2=sqlsrv_query($conn,$sql2);
    while($row=sqlsrv_fetch_array($res2)) { 
        $max_codigo = $row["id_cupon"];
        $cupon = $row["numero_cupon"];
    }

    $sql4 = "UPDATE CH_CUPONES_JUEGO SET cod_cliente = '$cliente', numero_factura = '$factura', correo_cliente = '$correo', nombre_cliente = '$nombre' WHERE id_cupon = $max_codigo";
    $res4=sqlsrv_query($conn,$sql4);

    $sql5 = "UPDATE FACTURASVENTACAMPOSLIBRES SET CODIGO_JUEGO = '$cupon' WHERE NUMFACTURA = '$factura' AND NUMSERIE = '$serie'";
    $res5=sqlsrv_query($conn,$sql5);
}



$sql = "SELECT * FROM CH_CUPONES_JUEGO";
$res=sqlsrv_query($conn,$sql);	
?>

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
        <th class="sortable-column sort-asc">ID</th>
        <th class="sortable-column sort-asc">CODIGO</th>
        <th class="sortable-column sort-asc">TIPO</th>
        <th class="sortable-column sort-asc">CLIENTE</th>
        <th class="sortable-column sort-asc">FACTURA</th>
    </tr>
    </thead>

    <tbody>
    <?php while($row=sqlsrv_fetch_array($res)) { ?>
    <tr>
        <td><?php echo $row["id_cupon"]?></td>
        <td><?php echo $row["numero_cupon"]?></td>
        <td><?php echo $row["tipo_cupon"]?></td>
        <td><?php echo $row["cod_cliente"]?></td>
        <td><?php echo $row["numero_factura"]?></td>
    </tr>
    <?php
        }
    ?>
    </tbody>
    
</table>

<?php

//Create an instance; passing `true` enables exceptions
// $mail = new PHPMailer(true);

// try {
//     //Server settings
//     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//     $mail->isSMTP();                                            //Send using SMTP
//     $mail->Host       = 'priva30.privatednsorg.com';                     //Set the SMTP server to send through
//     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//     $mail->Username   = 'info@chevignon.ec';                     //SMTP username
//     $mail->Password   = 'Novomode2023';                               //SMTP password
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//     $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//     //Recipients
//     $mail->setFrom('info@chevignon.ec', 'Chevignon');
//     $mail->addAddress('programacion@novomode.ec', 'Joe User');     //Add a recipient
//     //$mail->addAddress('ellen@example.com');               //Name is optional
//     //$mail->addReplyTo('info@example.com', 'Information');
//     //$mail->addCC('nightmare178@gmail.com');
//     //$mail->addBCC('mercadeo@novomode.ec');
//     $mail->addBCC('nightmare178@gmail.com');

//     //Attachments
//     //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//     //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

//     //Content
//     $mail->isHTML(true);                                  //Set email format to HTML

//     $html = '
//     <div style="background-image: url(https://novomodecol.vtexassets.com/assets/vtex.file-manager-graphql/images/9c72ada9-3e9c-4d70-a0e7-65b8a4a3d713___9832bd8d37d2a5052fc1cefc8ae12756.jpg);
//     background-size: cover;background-size: 100% 100%;width:100%;
//     background-repeat: no-repeat; text-align:center;color:black; font-family:Ciutadella Bold;">
//         <br><br><br><br><br><br><br>
                    
//         <font style="color:black;">Compite por un viaje a la carrera de automovilismo más prestigiosa de la historia
//         <br><br>CÓDIGO DE JUEGO: 
//         <br><br><strong></strong>
//         <br><br>Ingresa tu código de juego entrando a este link:
//         <br><a href="https://www.chevignon.com.ec/chevignonracing"><img src="https://novomodecol.vtexassets.com/assets/vtex.file-manager-graphql/images/36562c63-ea92-40b1-bd8b-6c54f52a9db9___1eff589284f0de77e7245b2f3b975ece.jpg" width="120" height="39"></a>

//         <br><br>VÁLIDO DEL 24 DE JULIO AL 4 DE OCTUBRE DEL 2023
//         <br>Aplica en tiendas físicas Chevignon en todo el país, WhatsApp y tienda online.

//         <br><br>Por compras entre $50 USD Y $99 USD recibes un código con 1 OPORTUNIDAD DE JUEGO en el video game Chevignon Racing.

//         <br><br>Por compras entre $100 USD Y $249 USD recibes un código con 5 OPORTUNIDADES DE JUEGO en el video game Chevignon Racing.

//         <br><br>Por compras iguales o superiores a $250USD recibes un código con 15 OPORTUNIDADES DE JUEGO en el video game Chevignon Racing.


//         <br><br>¡Registra tus códigos y juega!

//         <br><br>EL 5 DE OCTUBRE PREMIAREMOS EL RANKING CON LOS 10 MEJORES TIEMPOS
//         <br>GANA UNA EXPERIENCIA

//         <br><br>Ubícate en el ranking de los 10 mejores pilotos del video game CHEVIGNON RACING y gana:

//         <br><br>Tiquetes aéreos a Ciudad de México
//         <br>5 días de hospedaje en Ciudad de México
//         <br>3 días en la SUITE Chevignon Racing
//         <br>Kit de bienvenida Chevignon Racing
//         <br>Free Access food & drinks en la SUITE Chevignon Racing
//         <br>3 looks Chevignon</font>

//         <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
//     </div>
//     ';

//     $mail->Subject = 'Chevignon Racing';
//     $mail->Body    = $html;
    

//     // $mail->Body    = '<div style="background-image: url(https://novomodecol.vtexassets.com/assets/vtex.file-manager-graphql/images/ff852799-d545-468a-93f8-7daa99b888e5___eea7b6371a34c2f532214b557bc08119.jpg);
//     //                 background-size: cover;background-size: 100% 100%;width:50%;
//     //                 background-repeat: no-repeat; text-align:center;color:black; font-family:Ciutadella Bold;">
//     //                 <br><br><br><br><br>
                    
//     //                 </div>';

//     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//     $mail->send();
//     echo 'Message has been sent';
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }

?>