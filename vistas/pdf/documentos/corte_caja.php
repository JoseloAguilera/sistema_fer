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
$user_id        = intval($_GET['user_id']);
$fecha_actual   = date('Y-m-d');
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
$sql_factura    = mysqli_query($conexion, "SELECT * FROM facturas_ventas WHERE DATE(fecha_factura)='$fecha_actual' and id_users_factura='$user_id'");
$rw_factura     = mysqli_fetch_array($sql_factura);
$numero_factura = $rw_factura['numero_factura'];
$id_cliente     = $rw_factura['id_cliente'];
$id_vendedor    = $rw_factura['id_vendedor'];
$fecha_factura  = $rw_factura['fecha_factura'];
$condiciones    = $rw_factura['condiciones'];

// get the HTML
ob_start();
include dirname(__FILE__) . '/res/corte_html.php';
$content = ob_get_clean();

// convert to PDF
require_once dirname(__FILE__) . '/../html2pdf.class.php';
try
{
    $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', 3);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('usuarios.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
