<?php

if (isset($_REQUEST['utilidad'])) {
    $utilidad     = intval($_REQUEST['utilidad']);
    $costo        = floatval($_REQUEST['costo']);
    $utilidad     = ($costo * $utilidad) / 100;
    $precio_venta = $costo + $utilidad;
    $precio_venta = number_format($precio_venta, 0, '', '');

    $price[] = array('precio' => $precio_venta);
    //Creamos el JSON
    $json_string = json_encode($price);
    echo $json_string;
} elseif (isset($_REQUEST['mod_utilidad'])) {
    $utilidad     = intval($_REQUEST['mod_utilidad']);
    $costo        = floatval($_REQUEST['mod_costo']);
    $utilidad     = ($costo * $utilidad) / 100;
    $precio_venta = $costo + $utilidad;
    $precio_venta = number_format($precio_venta, 0, '', '');

    $price[] = array('mod_precio' => $precio_venta);
    //Creamos el JSON
    $json_string = json_encode($price);
    echo $json_string;
}
