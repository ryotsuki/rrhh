<?php

    $anio_actual = date("Y");
	$anio_anterior = $anio_actual - 1;
    $anio_menosdos = $anio_actual - 2;
    $anio_menostres = $anio_actual - 3;
	$mes_actual = date("m");
	$mes_anterior = $mes_actual - 1;
	$mes_siguiente = $mes_actual + 1;
	$dia_actual = date("d");
	$dia_anterior = $dia_actual-1;
	if($dia_anterior < 10){
		$dia_anterior = "0".$dia_anterior;
    }

    //echo "Anio-mes-dia: ".$anio_actual."-".$mes_actual."-".$dia_actual;

    $mes_letras = "";
    $mes_letras_anterior = "";
    
    if($mes_actual == "1"){
        $mes_letras = "Enero";
    }
    if($mes_actual == "2"){
        $mes_letras = "Febrero";
    }
    if($mes_actual == "3"){
        $mes_letras = "Marzo";
    }
    if($mes_actual == "4"){
        $mes_letras = "Abril";
    }
    if($mes_actual == "5"){
        $mes_letras = "Mayo";
    }
    if($mes_actual == "6"){
        $mes_letras = "Junio";
    }
    if($mes_actual == "7"){
        $mes_letras = "Julio";
    }
    if($mes_actual == "8"){
        $mes_letras = "Agosto";
    }
    if($mes_actual == "9"){
        $mes_letras = "Septiembre";
    }
    if($mes_actual == "10"){
        $mes_letras = "Octubre";
    }
    if($mes_actual == "11"){
        $mes_letras = "Noviembre";
    }
    if($mes_actual == "12"){
        $mes_letras = "Diciembre";
    }


    if($mes_anterior == "0"){
        $mes_letras_anterior = "Diciembre";
    }
    if($mes_anterior == "1"){
        $mes_letras_anterior = "Enero";
    }
    if($mes_anterior == "2"){
        $mes_letras_anterior = "Febrero";
    }
    if($mes_anterior == "3"){
        $mes_letras_anterior = "Marzo";
    }
    if($mes_anterior == "4"){
        $mes_letras_anterior = "Abril";
    }
    if($mes_anterior == "5"){
        $mes_letras_anterior = "Mayo";
    }
    if($mes_anterior == "6"){
        $mes_letras_anterior = "Junio";
    }
    if($mes_anterior == "7"){
        $mes_letras_anterior = "Julio";
    }
    if($mes_anterior == "8"){
        $mes_letras_anterior = "Agosto";
    }
    if($mes_anterior == "9"){
        $mes_letras_anterior = "Septiembre";
    }
    if($mes_anterior == "10"){
        $mes_letras_anterior = "Octubre";
    }
    if($mes_anterior == "11"){
        $mes_letras_anterior = "Noviembre";
    }
    if($mes_anterior == "12"){
        $mes_letras_anterior = "Diciembre";
    }


    $date_now = date('d-m-Y');
    $date_future = strtotime('-1 day', strtotime($date_now));
    $date_future = date('Y-m-d', $date_future);

    $date_future2 = strtotime('-1 year', strtotime($date_future));
    $date_future2 = date('Y-m-d', $date_future2);

?>