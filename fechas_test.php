<?php

    $anio_actual = date("Y");
    $anio_anterior = $anio_actual - 1;
    $mes_actual = date("m");
    $mes_anterior = $mes_actual - 1;
    $mes_siguiente = $mes_actual + 1;
    $dia_actual = date("d");
    $dia_anterior = $dia_actual-1;
    if($dia_anterior < 10){
        $dia_anterior = "0".$dia_anterior;
    }

    $date_now = date('d-m-Y');
    $date_future = strtotime('-1 day', strtotime($date_now));
    $date_future = date('Y-m-d', $date_future);

    $date_future2 = strtotime('-1 year', strtotime($date_future));
    $date_future2 = date('Y-m-d', $date_future2);

    echo "Menos un dos: ".$date_future."<br>";

    echo "Menos un año: ".$date_future2;

?>