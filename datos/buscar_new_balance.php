<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
//include("../validacion/validacion.php"); 
$conn = conectate();



$pedido = "";
$muestra = "display:none;";

if(isset($_GET["pedido"])){
    $pedido = $_GET["pedido"];

    $consulta_gender = "SELECT DISTINCT gender FROM DATOS_ARTICULOS_NB ORDER BY gender";
    $res_gender=sqlsrv_query($conn,$consulta_gender);	

    $consulta_line = "SELECT DISTINCT line_plan FROM DATOS_ARTICULOS_NB ORDER BY line_plan";
    $res_line=sqlsrv_query($conn,$consulta_line);

    $consulta_ref = "SELECT DISTINCT ref FROM DATOS_ARTICULOS_NB ORDER BY ref";
    $res_ref=sqlsrv_query($conn,$consulta_ref);

    $muestra = "";
}
//echo "pedido: ".$pedido;

$gender = $_GET["gender"];
$line = $_GET["line"];
$ref = $_GET["ref"];
// $marca = $_GET["marca"];

if($gender != "TODOS"){
    $consulta_gender = "AND gender = '$gender'";
}
else{
    $consulta_gender = "";
}

if($line != "TODOS"){
    $consulta_line = "AND line_plan = '$line'";
}
else{
    $consulta_line = "";
}

if($ref != "TODOS"){
    $consulta_ref = "AND ref = '$ref'";
}
else{
    $consulta_ref = "";
}


    if($pedido == ""){
        $sql="SELECT * FROM DATOS_ARTICULOS_NB WHERE 1=1 $consulta_gender $consulta_line $consulta_ref";
    }
    else{
        $sql="SELECT * FROM V_PEDIDO WHERE 1=1 AND id_pedido = $pedido $consulta_gender $consulta_line $consulta_ref";
        $res2=sqlsrv_query($conn,$sql);
        while($row=sqlsrv_fetch_array($res2)) { 
            $pares = $row["cantidad_pares"];
            $referencias = $row["cantidad_referencias"];
            $valor = $row["valor_pedido"];
        }
        //echo $sql;
    }
    //echo $sql;

    $res=sqlsrv_query($conn,$sql);	

    // while($row=sqlsrv_fetch_array($res)) {
    //     echo $row["style"]."<br>";
    // }
    //echo $sql; 
    //$consulta_descripcion 

?>

<style>

    input{
        width:30px;
        text-align:right;
        border:0;
        background-color:transparent;
    }

    thead tr th { 
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #ffffff;
    }

    tbody  { 
        height:400px;
        overflow-y:scroll;
    }

</style>

<script src="js/jquery.floatThead.min.js"></script>
<script src="js/filtrotabla/dist/tablefilter/tablefilter.js"></script>

<script>
    var tf = new TableFilter(document.querySelector('#tabla_articulos'), {
        base_path: 'js/filtrotabla/dist/tablefilter/',
        col_0: 'none',
        col_2: 'select',
        col_3: 'select',
        col_4: 'select',
        col_5: 'select',
        col_6: 'select',
        col_8: 'none',
        col_7: 'none',
        col_9: 'none',
        col_10: 'none',
        col_11: 'none',
        col_12: 'none',
        col_13: 'none',
        col_14: 'none',
        col_15: 'none',
        col_16: 'none',
        col_17: 'none'
    });
    tf.init();
</script>
<script>

    //$(() => $('#tabla_articulos').floatThead());

    function recalcular(num){
        $(document).ready(function(){

            var monto_actual = parseFloat($("#valor_pedido").html());
            var referencias = parseFloat($("#referencias_cantidad").html());
            var pares = parseFloat($("#totales_cantidad").html());

            var a = 0;
            var b = 0;
            var cc = 0;
            var em = 0;
            var t = 0;
            var w = 0;
            var g = 0;
            var p = 0;
            var i = 0;

            var a1 = 0;
            var b1 = 0;
            var cc1 = 0;
            var em1 = 0;
            var t1 = 0;
            var w1 = 0;
            var g1 = 0;
            var p1 = 0;
            var i1 = 0;

            var precio = 0.00;
            var pagar = 0.00;

            var recorrido = 0;
            var articulos = 0;

            $('#tabla_articulos > tbody > tr').each(function(){

                a+=parseFloat($(this).find('td').eq(9).html());
                b+=parseFloat($(this).find('td').eq(10).html());
                cc+=parseFloat($(this).find('td').eq(11).html());
                em+=parseFloat($(this).find('td').eq(12).html());
                t+=parseFloat($(this).find('td').eq(13).html());
                w+=parseFloat($(this).find('td').eq(14).html());
                g+=parseFloat($(this).find('td').eq(15).html());
                p+=parseFloat($(this).find('td').eq(16).html());
                i+=parseFloat($(this).find('td').eq(17).html());

                a1=parseFloat($(this).find('td').eq(9).html());
                b1=parseFloat($(this).find('td').eq(10).html());
                cc1=parseFloat($(this).find('td').eq(11).html());
                em1=parseFloat($(this).find('td').eq(12).html());
                t1=parseFloat($(this).find('td').eq(13).html());
                w1=parseFloat($(this).find('td').eq(14).html());
                g1=parseFloat($(this).find('td').eq(15).html());
                p1=parseFloat($(this).find('td').eq(16).html());
                i1=parseFloat($(this).find('td').eq(17).html());

                if(a1+b1+cc1+em1+t1+w1+g1+p1+i1 > 0){
                    recorrido++;
                }

                precio=parseFloat($(this).find('td').eq(8).html());
                articulos = (a1*12)+(b1*12)+(cc1*12)+(em1*12)+(t1*12)+(w1*12)+(g1*12)+(p1*12)+(i1*12);

                pagar+= precio*articulos;

            });

            a=a*12;
            b=b*12;
            cc=cc*12;
            em=em*12;
            t=t*12;
            w=w*12;
            g=g*12;
            p=p*12;
            i=i*12;

            var todos = a+b+cc+em+t+w+g+p+i;

            //alert(todos);
            //alert(precio);

            $("#totales_cantidad").html(todos);
            $("#referencias_cantidad").html(recorrido);
            $("#valor_pedido").html((pagar).toFixed(2));
        })
    }

    $( document ).ready(function() {
        
        $( ".input" ).keypress(function() {
            recalcular();
        });

        $('[contenteditable]').on('paste', function(e) {
            //strips elements added to the editable tag when pasting
            var $self = $(this);
            setTimeout(function() {$self.html($self.text());}, 0);
        }).on('keypress', function(e) {
            //ignores enter key
            if(e.which != 13){
                return e.which != 13;
            }
            else{
                //alert("Se va a recalcular");
                var $self = $(this);
                var num = $(this).html();
                recalcular(num);
                this.blur();
                return e.which != 13;
            }
        });

    });

    function buscar2(){

        var gender1 = $("#cbo_gender1").val();
        var line1 = $("#cbo_line1").val();
        var ref1 = $("#cbo_ref1").val();
        var pedido = '<?php echo $pedido;?>';

        // alert(gender);
        // alert(line);
        // alert(ref);

        $.post("datos/buscar_new_balance.php?gender="+gender1+"&line="+line1+"&ref="+ref1+"&pedido="+pedido, function(htmlexterno){
            $('#tabla_datos').fadeOut('slow');
            $('#tabla_datos').fadeIn('slow');
            $("#tabla_datos").html(htmlexterno);
        });

    }

    function guardar(){

        var empresa = $("#txt_empresa").val();
        var comprador = $("#txt_comprador").val();
        var correo = $("#txt_correo").val();
        var pedido = '<?php echo $pedido;?>';
        // alert(pedido);
        // return;

        var valor_pedido = parseFloat($("#valor_pedido").html());
        var totales_cantidad = parseFloat($("#totales_cantidad").html());
        var referencias_cantidad = parseFloat($("#referencias_cantidad").html());

        var cabecera_doc = [];
        cabecera_doc.push({'empresa':empresa,
                        'comprador':comprador,
                        'correo':correo,
                        'valor_pedido':valor_pedido,
                        'totales_cantidad':totales_cantidad,
                        'referencias_cantidad':referencias_cantidad,
        });

        // alert(valor_pedido);
        // return;

        var detalle_doc = [];

        $('#tabla_articulos > tbody > tr').each(function(){

            var a1 = 0;
            var b1 = 0;
            var cc1 = 0;
            var em1 = 0;
            var t1 = 0;
            var w1 = 0;
            var g1 = 0;
            var p1 = 0;
            var i1 = 0;

            var precio = 0.00;
            var pagar = 0.00;
            var referencia = "";

            var recorrido = 0;
            var articulos = 0;

                a1=parseFloat($(this).find('td').eq(9).html());
                b1=parseFloat($(this).find('td').eq(10).html());
                cc1=parseFloat($(this).find('td').eq(11).html());
                em1=parseFloat($(this).find('td').eq(12).html());
                t1=parseFloat($(this).find('td').eq(13).html());
                w1=parseFloat($(this).find('td').eq(14).html());
                g1=parseFloat($(this).find('td').eq(15).html());
                p1=parseFloat($(this).find('td').eq(16).html());
                i1=parseFloat($(this).find('td').eq(17).html());

                precio=parseFloat($(this).find('td').eq(8).html());
                referencia=$(this).find('td').eq(1).html();

                articulos = (a1*12)+(b1*12)+(cc1*12)+(em1*12)+(t1*12)+(w1*12)+(g1*12)+(p1*12)+(i1*12);

                // alert(articulos);
                // return;

                pagar+= precio*articulos;

                detalle_doc.push({'referencia':referencia,
                                'precio':precio,
                                'a':a1,
                                'b':b1,
                                'cc':cc1,
                                'em':em1,
                                't':t1,
                                'w':w1,
                                'g':g1,
                                'p':p1,
                                'i':i1,
                });

            });
            console.log(detalle_doc);
            console.log(cabecera_doc);

            $.ajax({
                type: "POST",
                dataType:"html",
                url: "datos/guarda_pedido.php",	
                data:{ cabecera_doc:cabecera_doc,detalle_doc:detalle_doc,pedido:pedido },
                cache: false,			
                success: function(result) {	
                    //alert(result);
                    resultado=result.split("/");
                    if(resultado[1] == 1){
                        alert("Pedido guardado exitosamente");
                    }
                    else{
                        alert("Pedido guardado exitosamente");
                    }
            
                    
                },			
                error: function(error) {				
                    alert("	jquery - Algunos problemas han ocurrido. Por favor, inténtelo de nuevo más tarde: " + toString(error));			
                }

            });


    }

</script>

<div class="row" style="<?php echo $muestra;?>">
        
        <div class="cell-3"><div>
            <select data-prepend="Gender:" data-role="select" id="cbo_gender1">
            <option value="TODOS">TODOS</option>
            <?php while($row=sqlsrv_fetch_array($res_gender)) { ?>
            <option value="<?php echo $row["gender"]?>"><?php echo $row["gender"]?></option>
            <?php } ?>
            </select>
        </div></div>
        <div class="cell-3"><div>
            <select data-prepend="Line Plan:" data-role="select" id="cbo_line1">
                <option value="TODOS">TODOS</option>
                <?php while($row=sqlsrv_fetch_array($res_line)) { ?>
                <option value="<?php echo $row["line_plan"]?>"><?php echo $row["line_plan"]?></option>
                <?php } ?>
            </select>
        </div></div>
        <div class="cell-3"><div>
            <select data-prepend="Silueta:" data-role="select" id="cbo_ref1">
                <option value="TODOS">TODOS</option>
                <?php while($row=sqlsrv_fetch_array($res_ref)) { ?>
                <option value="<?php echo $row["ref"]?>"><?php echo $row["ref"]?></option>
                <?php } ?>
            </select>
        </div></div>
        <div class="cell-3"><div>
            <!--<button class="button primary cycle" onclick="buscar2();"><span class="mif-search"></span></button>-->
        </div></div>
    </div>

<div class="container" style="text-align:center;">

<div class="container" style="text-align:center;font-size:xx-large;">
        <div class="row remark primary" style="text-align:center;font-size:xx-large;">
            <div class="cell">
                <strong>Cantidad (referencias): <label id="referencias_cantidad"><?php if($pedido > 0){ echo $referencias; }else{ echo "0";}?></label></strong>
            </div>
            <div class="cell">
                <strong>Cantidad (pares): <label id="totales_cantidad"><?php if($pedido > 0){ echo $pares; }else{ echo "0";}?></strong>
            </div>
            <div class="cell">
                <strong>Valor del pedido ($): <label id="valor_pedido"><?php if($pedido > 0){ echo $valor; }else{ echo "0";}?></label></strong>
            </div>
        </div>
    
        <?php if($pedido == ""){?>
        <button class="button primary" onclick="guardar();">Guardar</button>
        <?php }else{ ?>
        <button class="button success" onclick="guardar();">Finalizar</button>
        <?php } ?>
    </div>
    </div>

    <div style="overflow: scroll;height: 380px;">
    <table class="table compact striped table-border mt-4" id="tabla_articulos">
        <thead>
        <tr>
            <th>FOTO</th>
            <th>REF</th>
            <th>SILUETA</th>
            <th>PRIMARY R.</th>
            <th>Q</th>
            <th>PRIMARY COLOR</th>
            <th>TIER</th>
            <th>PVP</th>
            <th>PRECIO MAYOR+IMP</th>
            <th data-role="popover"
                data-popover-hide="2500"
                data-popover-text="
                    <div class='text-center'>
                        <img src='images/curvas/CURVA A.jpg' style='height: 50px;'>
                    </div>"
                data-popover-position="left">A</th>
            <th style="display:none;" data-role="popover"
                data-popover-hide="2500"
                data-popover-text="
                    <div class='text-center'>
                        <img src='images/curvas/CURVA B.jpg' style='height: 50px;'>
                    </div>"
                data-popover-position="left">B</th>
            <th style="display:none;" data-role="popover"
                data-popover-hide="2500"
                data-popover-text="
                    <div class='text-center'>
                        <img src='images/curvas/CURVA CC.jpg' style='height: 50px;'>
                    </div>"
                data-popover-position="left">CC</th>
            <th data-role="popover"
                data-popover-hide="2500"
                data-popover-text="
                    <div class='text-center'>
                        <img src='images/curvas/CURVA EM.jpg' style='height: 50px;'>
                    </div>"
                data-popover-position="left">EM</th>
            <th data-role="popover"
                data-popover-hide="2500"
                data-popover-text="
                    <div class='text-center'>
                        <img src='images/curvas/CURVA T.jpg' style='height: 50px;'>
                    </div>"
                data-popover-position="left">T</th>
            <th data-role="popover"
                data-popover-hide="2500"
                data-popover-text="
                    <div class='text-center'>
                        <img src='images/curvas/CURVA W.jpg' style='height: 50px;'>
                    </div>"
                data-popover-position="left">W</th>
            <th data-role="popover"
                data-popover-hide="2500"
                data-popover-text="
                    <div class='text-center'>
                        <img src='images/curvas/CURVA G.jpg' style='height: 50px;'>
                    </div>"
                data-popover-position="left">G</th>
            <th data-role="popover"
                data-popover-hide="2500"
                data-popover-text="
                    <div class='text-center'>
                        <img src='images/curvas/CURVA P.jpg' style='height: 50px;'>
                    </div>"
                data-popover-position="left">P</th>
            <th data-role="popover"
                data-popover-hide="2500"
                data-popover-text="
                    <div class='text-center'>
                        <img src='images/curvas/CURVA I.jpg' style='height: 50px;'>
                    </div>"
                data-popover-position="left">I</th>
        </tr>
        </thead>

        <tbody>
        <?php 
            $i=0;
            while($row=sqlsrv_fetch_array($res)) { 
        ?>
        <tr>
            <td>
                <img data-role="popover"
                data-popover-hide="1500"
                data-popover-text="
                    <div class='text-center'>
                        <img src='images/fotos/<?php echo $row["style"]?>_2.png' style='height: 300px;'>
                    </div>"
                data-popover-position="right"
                     src="images/fotos/<?php echo $row["style"]?>_2.png" width="100" heigh="100" id="foto">
            </td>
            <td class="busca_style"><?php echo $row["style"]?></td>
            <td class="busca_ref"><?php echo $row["ref"]?></td>
            <td><?php echo $row["primary_reporting"]?></td>
            <td><?php echo $row["Q"]?></td>
            <td><?php echo $row["primary_color"]?></td>
            <td><?php echo $row["tier"]?></td>
            <td><?php echo $row["pvp"]?></td>
            <td><?php echo $row["precio_cadena"]?></td>
            <td contenteditable="true"><?php if($pedido > 0){ echo $row["a"]; }else{ echo "0"; }?></td>
            <td style="display:none;" contenteditable="true">0</td>
            <td style="display:none;" contenteditable="true">0</td>
            <td contenteditable="true"><?php if($pedido > 0){ echo $row["em"]; }else{ echo "0"; }?></td>
            <td contenteditable="true"><?php if($pedido > 0){ echo $row["t"]; }else{ echo "0"; }?></td>
            <td contenteditable="true"><?php if($pedido > 0){ echo $row["w"]; }else{ echo "0"; }?></td>
            <td contenteditable="true"><?php if($pedido > 0){ echo $row["g"]; }else{ echo "0"; }?></td>
            <td contenteditable="true"><?php if($pedido > 0){ echo $row["p"]; }else{ echo "0"; }?></td>
            <td contenteditable="true"><?php if($pedido > 0){ echo $row["i"]; }else{ echo "0"; }?></td>
            <!--<input type="input" id="txt_a_<?php //echo $i;?>" class="input sumar">-->
        </tr>
        <?php
            $i++;
            }
        ?>
        </tbody>
        
    </table>
    </div>

    <br><br><br>
</div>