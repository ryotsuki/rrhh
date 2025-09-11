<?php
$html = "";
if ($_POST["almacenelegido"]==1) {
    $html = '
    <option value="1">Buenos Aires</option>
    <option value="2">Cordoba</option>
    <option value="3">Rosario</option>
    <option value="4">Salta</option>
    ';  
}
if ($_POST["almacenelegido"]==2) {
    $html = '
    <option value="1">Madrid</option>
    <option value="2">Barcelona</option>
    <option value="3">Sevilla</option>
    <option value="4">Bilbao</option>
    ';  
}
if ($_POST["almacenelegido"]==3) {
    $html = '
    <option value="1">CDMX</option>
    <option value="2">Monterrey</option>
    <option value="3">Guadalajara</option>
    <option value="4">Tijuana</option>
    ';  
}
echo $html; 
?>