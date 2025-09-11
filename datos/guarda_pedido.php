<?PHP
	include("../conexion/conexion.php");
	$conn = conectate();
	
    $pedido = "";
    if(isset($_POST['pedido'])){
        $pedido = $_POST['pedido'];
    }

	$detalle_doc	= $_POST['detalle_doc'];

    if($pedido > 0){

        $cabecera_doc	= $_POST['cabecera_doc'];
        foreach ($cabecera_doc as $item) {
            $valor_pedido = $item["valor_pedido"];
            $totales_cantidad = $item["totales_cantidad"];
            $referencias_cantidad = $item["referencias_cantidad"];
        }

        $consulta1 = "UPDATE CABECERA_PEDIDO SET valor_pedido = $valor_pedido, cantidad_pares = $totales_cantidad, cantidad_referencias = $referencias_cantidad WHERE id_pedido = $pedido";
        $actualiza_cabecera = sqlsrv_query($conn,$consulta1);

        $borrar = "DELETE FROM PEDIDO WHERE id_pedido = $pedido";
        $borrar_detalle = sqlsrv_query($conn,$borrar);

        foreach ($detalle_doc as $item) {
            $referencia = $item['referencia'];
            $precio = $item['precio'];
            $a = $item['a'];
            $b = $item['b'];
            $cc = $item['cc'];
            $em = $item['em'];
            $t = $item['t'];
            $w = $item['w'];
            $g = $item['g'];
            $p = $item['p'];
            $i = $item['i'];

            $consulta2 = "INSERT INTO PEDIDO(id_pedido,referencia,precio,a,b,cc,em,t,w,g,p,i) 
            VALUES($pedido,'$referencia',$precio,$a,$b,$cc,$em,$t,$w,$g,$p,$i)";
            $inserta_detalle = sqlsrv_query($conn,$consulta2);
        }

        $busca_faltantes = "SELECT * FROM datos_articulos_nb WHERE style NOT IN(SELECT DISTINCT referencia FROM pedido WHERE id_pedido = $pedido)";
        $res_faltantes = sqlsrv_query($conn,$busca_faltantes);
        while($row=sqlsrv_fetch_array($res_faltantes)) {
            $refe = $row["style"];
            $prec = $row["precio_cadena"];
            $consulta3 = "INSERT INTO PEDIDO(id_pedido,referencia,precio,a,b,cc,em,t,w,g,p,i) 
            VALUES($pedido,'$refe',$prec,0,0,0,0,0,0,0,0,0)";
            $inserta_faltantes = sqlsrv_query($conn,$consulta3);
        }
    }
    else{

        $cabecera_doc	= $_POST['cabecera_doc'];
        foreach ($cabecera_doc as $item) {
            $empresa = $item["empresa"];
            $comprador = $item["comprador"];
            $correo = $item["correo"];
            $valor_pedido = $item["valor_pedido"];
            $totales_cantidad = $item["totales_cantidad"];
            $referencias_cantidad = $item["referencias_cantidad"];
            $pedido = $item["pedido"];
        }

        $consulta1 = "INSERT INTO CABECERA_PEDIDO(empresa,comprador,correo,valor_pedido,cantidad_pares,cantidad_referencias,estado_pedido) 
        VALUES('$empresa','$comprador','$correo',$valor_pedido,$totales_cantidad,$referencias_cantidad,0)";

        //echo $consulta1;
        $inserta_cabecera = sqlsrv_query($conn,$consulta1);

        $busca = "SELECT MAX(id_pedido) AS ultimo_pedido FROM CABECERA_PEDIDO";
        $res_pedido = sqlsrv_query($conn,$busca);
        while($row=sqlsrv_fetch_array($res_pedido)) { 
            $max_pedido = $row["ultimo_pedido"];
        }

        foreach ($detalle_doc as $item) {
            $referencia = $item['referencia'];
            $precio = $item['precio'];
            $a = $item['a'];
            $b = $item['b'];
            $cc = $item['cc'];
            $em = $item['em'];
            $t = $item['t'];
            $w = $item['w'];
            $g = $item['g'];
            $p = $item['p'];
            $i = $item['i'];

            $consulta2 = "INSERT INTO PEDIDO(id_pedido,referencia,precio,a,b,cc,em,t,w,g,p,i) 
            VALUES($max_pedido,'$referencia',$precio,$a,$b,$cc,$em,$t,$w,$g,$p,$i)";
            $inserta_detalle = sqlsrv_query($conn,$consulta2);
        }

        $busca_faltantes = "SELECT * FROM datos_articulos_nb WHERE style NOT IN(SELECT DISTINCT referencia FROM pedido WHERE id_pedido = $max_pedido)";
        $res_faltantes = sqlsrv_query($conn,$busca_faltantes);
        while($row=sqlsrv_fetch_array($res_faltantes)) {
            $refe = $row["style"];
            $prec = $row["precio_cadena"];
            $consulta3 = "INSERT INTO PEDIDO(id_pedido,referencia,precio,a,b,cc,em,t,w,g,p,i) 
            VALUES($max_pedido,'$refe',$prec,0,0,0,0,0,0,0,0,0)";
            $inserta_faltantes = sqlsrv_query($conn,$consulta3);
        }
    }

    if ($inserta_detalle){
        //echo $detalle;
        echo 'Pedido cargado exitosamente/1/'.$consulta2;
    }else{
        //echo $detalle;
        echo 'No se ha podido registrar el cliente!/0/'.$consulta2;
    }

?>