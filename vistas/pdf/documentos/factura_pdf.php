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
$sql_count = mysqli_query($conexion, "select * from tmp where session_id='" . $session_id . "'");
$count     = mysqli_num_rows($sql_count);
if ($count == 0) {
    echo "<script>alert('No hay productos agregados a la factura')</script>";
    echo "<script>window.close();</script>";
    exit;
}

require_once dirname(__FILE__) . '/../html2pdf.class.php';

//Variables por GET
$id_cliente     = intval($_GET['id_cliente']);
$id_vendedor    = intval($_SESSION['id_users']);
$condiciones    = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
$numero_factura = mysqli_real_escape_string($conexion, (strip_tags($_GET["factura"], ENT_QUOTES)));
//Fin de variables por GET

//Seleccionamos el ultimo compo numero_fatura y aumentamos una
$sql            = mysqli_query($conexion, "select LAST_INSERT_ID(id_factura) as last from facturas order by id_factura desc limit 0,1 ");
$rw             = mysqli_fetch_array($sql);
$id_factura     = $rw['last'] + 1;
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
// get the HTML
ob_start();
include dirname('__FILE__') . '/res/factura_html.php'; //RUTA DEL ARCHIVO QUE MUESTRA EL PDF
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
    $html2pdf->Output('Factura.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
