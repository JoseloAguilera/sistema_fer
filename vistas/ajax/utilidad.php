
<?php

if (isset($_REQUEST['precio_vta'])) {
    $precio_vta   = intval($_REQUEST['precio_vta']);
    $costo        = floatval($_REQUEST['costo']);
    $diferencia   = $precio_vta-$costo;
    $utilidad     = ($diferencia * 100) / $costo;
    $utilidad_resultante = $utilidad;
    $utilidad_resultante = number_format($utilidad_resultante, 0, '', '');

    $utility[] = array('utilidad' => $utilidad_resultante);
    //Creamos el JSON
    $json_string = json_encode($utility);
    echo $json_string;
} elseif (isset($_REQUEST['mod_precio_vta'])) {
    $precio_vta     = intval($_REQUEST['mod_precio_vta']);
    $costo        = floatval($_REQUEST['mod_costo']);
    $diferencia   = $precio_vta - $costo;
    $utilidad     = ($diferencia * 100) / $costo;
    $utilidad_resultante = $utilidad;
    $utilidad_resultante = number_format($utilidad_resultante, 0, '', '');

    $utility[] = array('mod_utilidad' => $utilidad_resultante);
    //Creamos el JSON
    $json_string = json_encode($utility);
    echo $json_string;
}
