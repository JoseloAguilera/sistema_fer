<?php
/*-------------------------
Autor: Obed Alvarado
Web: obedalvarado.pw
Mail: info@obedalvarado.pw
---------------------------*/
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../../login.php");
    exit;
}

/* Connect To Database*/
include "../../db.php";
include "../../php_conexion.php";
//Archivo de funciones PHP
include "../../funciones.php";
$session_id = session_id();
//Comprobamos si hay archivos en la tabla temporal
$sql_count = mysqli_query($conexion, "select * from tmp_cotizacion where session_id='" . $session_id . "'");
$count     = mysqli_num_rows($sql_count);
if ($count == 0) {
    echo "<script>alert('No hay productos agregados a la factura')</script>";
    echo "<script>window.close();</script>";
    exit;
}

require_once dirname(__FILE__) . '/../html2pdf.class.php';

//Variables por GET
$atencion    = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST["atencion"], ENT_QUOTES)));
$tel1        = mysqli_real_escape_string($conexion, (strip_tags($_GET["tel1"], ENT_QUOTES)));
$empresa     = mysqli_real_escape_string($conexion, (strip_tags($_GET["empresa"], ENT_QUOTES)));
$email       = mysqli_real_escape_string($conexion, (strip_tags($_GET["email"], ENT_QUOTES)));
$condiciones = mysqli_real_escape_string($conexion, (strip_tags($_GET["condiciones"], ENT_QUOTES)));
$validez     = mysqli_real_escape_string($conexion, (strip_tags($_GET["validez"], ENT_QUOTES)));
$entrega     = mysqli_real_escape_string($conexion, (strip_tags($_GET["entrega"], ENT_QUOTES)));
$validez     = mysqli_real_escape_string($conexion, (strip_tags($_GET["validez"], ENT_QUOTES)));
//Fin de variables por GET
$sql_cotizacion    = mysqli_query($conexion, "select LAST_INSERT_ID(numero_cotizacion) as last from cotizaciones order by id_cotizacion desc limit 0,1 ");
$rwC               = mysqli_fetch_array($sql_cotizacion);
$numero_cotizacion = $rwC['last'] + 1;
// get the HTML
ob_start();
include dirname('__FILE__') . '/res/cotizacion_html.php'; //RUTA DEL ARCHIVO QUE MUESTRA EL PDF
$content = ob_get_clean();

try
{
    // init HTML2PDF
    $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
    // display the full page
    $html2pdf->pdf->SetDisplayMode('fullpage');
    // convert
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    // send the PDF
    $html2pdf->Output('Cotizacion.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
