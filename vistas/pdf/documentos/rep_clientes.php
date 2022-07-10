<?php
/* Connect To Database*/
require_once "../../db.php";
require_once "../../php_conexion.php";
#require_once "../libraries/inventory.php"; //Contiene funcion que controla stock en el inventario
//Inicia Control de Permisos
include "../../permisos.php";
//Archivo de funciones PHP
require_once "../../funciones.php";
//Ontengo variables pasadas por GET
$q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
$aColumns = array('nombre_cliente', 'fiscal_cliente'); //Columnas de busqueda
$sTable   = "clientes";
$sWhere   = "";
if ($_GET['q'] != "") {
    $sWhere = "WHERE (";
    for ($i = 0; $i < count($aColumns); $i++) {
        $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
    }
    $sWhere = substr_replace($sWhere, "", -3);
    $sWhere .= ')';
}
$sWhere .= " order by id_cliente ASC";

$query = mysqli_query($conexion, "SELECT * FROM  $sTable $sWhere ");
// get the HTML
ob_start();
include dirname(__FILE__) . '/res/rep_clientes_html.php';
$content = ob_get_clean();

// convert to PDF
require_once dirname(__FILE__) . '/../html2pdf.class.php';
try
{
    $html2pdf = new HTML2PDF('L', 'A4', 'es', true, 'UTF-8', 3);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    ob_end_clean();
    $html2pdf->Output('clientes.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
