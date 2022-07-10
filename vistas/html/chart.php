<?php
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
//Archivo de funciones PHP
    include "../funciones.php";
    $periodo = intval($_REQUEST['periodo']);
    $txt_mes = array("1" => "Ene", "2" => "Feb", "3" => "Mar", "4"  => "Abr", "5"  => "May", "6"  => "Jun",
        "7"                  => "Jul", "8" => "Ago", "9" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dic",
    ); //Arreglo que contiene las abreviaturas de los meses del año

    $categorias[] = array('Mes', "Ventas $periodo", "Compras $periodo "); //Nombre de la primer fila del grafico
    for ($inicio = 1; $inicio <= 12; $inicio++) {
        $mes          = $txt_mes[$inicio]; //Obtengo la abreviatura del mes
        $ingresos     = monto('facturas_ventas', $inicio, $periodo); //Obtengo el  monto de los ingresos
        $egresos      = monto('facturas_compras', $inicio, $periodo); //Obtengo el monto de los egresos
        $categorias[] = array($mes, $ingresos, $egresos); //Agrego elementos al arreglo

    }
    echo json_encode(($categorias)); //Convierto el arreglo a formato json
}
