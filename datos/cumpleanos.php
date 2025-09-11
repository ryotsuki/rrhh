<?PHP
    header("Content-Type: text/html;charset=utf-8");

    $cumpleanos="SELECT * FROM CUMPLEANOS_NOVOMODE WHERE mes = $mes_actual AND dia <> $dia_actual ORDER BY dia";
    $cumpleanos2="SELECT * FROM CUMPLEANOS_NOVOMODE WHERE mes = $mes_actual AND dia = $dia_actual ORDER BY dia";

    //echo $top_vendedores;
    $res_cumpleanos=sqlsrv_query($conn,$cumpleanos);
    $res_cumpleanos2=sqlsrv_query($conn,$cumpleanos2);
 
?>