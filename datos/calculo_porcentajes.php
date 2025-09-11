<?php

    $porcentaje_anio = (($venta_anio_actual-$venta_anio_anterior) / $venta_anio_actual) * 100;
    $porcentaje_anio = number_format($porcentaje_anio,2,',','.');
    //echo $venta_anio_actual;

    if($porcentaje_anio > 0){
        $flecha_anio = "mif-arrow-drop-up";
        $color_anio = "fg-green";
    }
    if($porcentaje_anio < 0){
        $flecha_anio = "mif-arrow-drop-down";
        $color_anio = "fg-red";
    }
    if($porcentaje_anio == 0){
        $flecha_anio = "";
        $color_anio = "fg-orange";
    }

    $porcentaje_mes = (($venta_mes_actual-$venta_mes_anterior) / $venta_mes_actual) * 100;
    $porcentaje_mes = number_format($porcentaje_mes,2,',','.');

    if($porcentaje_mes > 0){
        $flecha_mes = "mif-arrow-drop-up";
        $color_mes = "fg-green";
    }
    if($porcentaje_mes < 0){
        $flecha_mes = "mif-arrow-drop-down";
        $color_mes = "fg-red";
    }
    if($porcentaje_mes == 0){
        $flecha_mes = "";
        $color_mes = "fg-orange";
    }

    $porcentaje_hoy = (($venta_dia_actual-$venta_dia_anterior_2) / $venta_dia_actual) * 100;
    //echo $venta_dia_actual. "-".$venta_dia_anterior_2;
    $porcentaje_hoy = number_format($porcentaje_hoy,2,',','.');
    //echo $porcentaje_hoy;

    if($porcentaje_hoy > 0){
        $flecha_hoy = "mif-arrow-drop-up";
        $color_hoy = "fg-green";
    }
    if($porcentaje_hoy < 0){
        $flecha_hoy = "mif-arrow-drop-down";
        $color_hoy = "fg-red";
    }
    if($porcentaje_hoy == 0){
        $flecha_hoy = "";
        $color_hoy = "fg-orange";
    }

    $porcentaje_ayer = (($venta_dia_anterior-$venta_dia_anterior_anterior) / $venta_dia_anterior) * 100;
    $porcentaje_ayer = number_format($porcentaje_ayer,2,',','.');

    if($porcentaje_ayer > 0){
        $flecha_ayer = "mif-arrow-drop-up";
        $color_ayer = "fg-green";
    }
    if($porcentaje_ayer < 0){
        $flecha_ayer = "mif-arrow-drop-down";
        $color_ayer = "fg-red";
    }
    if($porcentaje_ayer == 0){
        $flecha_ayer = "";
        $color_ayer = "fg-orange";
    }

?>