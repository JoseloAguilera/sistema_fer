<?php
include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
#require_once "../libraries/inventory.php"; //Contiene funcion que controla stock en el inventario
//Inicia Control de Permisos
include "../permisos.php";
//Archivo de funciones PHP
require_once "../funciones.php";
$user_id = $_SESSION['id_users'];
$action  = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $daterange   = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['range'], ENT_QUOTES)));
    $employee_id = intval($_REQUEST['employee_id']);
    $tables      = "facturas_ventas,  users";
    $campos      = "*";
    $sWhere      = "users.id_users=facturas_ventas.id_vendedor";
    if ($employee_id > 0) {
        $sWhere .= " and facturas_ventas.id_vendedor = '" . $employee_id . "' ";
    }
    if (!empty($daterange)) {
        list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
        list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
        $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
        list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
        $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";

        $sWhere .= " and facturas_ventas.fecha_factura between '$fecha_inicial' and '$fecha_final' ";
    }
    $sWhere .= " order by facturas_ventas.id_factura";

    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 100; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $tables where $sWhere ");
    if ($row = mysqli_fetch_array($count_query)) {$numrows = $row['numrows'];} else {echo mysqli_error($conexion);}
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../rep_corte_caja.php';
    //main query to fetch the data
    $query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
    //loop through fetched data

    if ($numrows > 0) {
        ?>

      <div class="table-responsive">
        <?php
$finales        = 0;
        $totalVentas    = 0;
        $totalEfectivo  = 0;
        $totalCheque    = 0;
        $totalBanco     = 0;
        $totalCredito   = 0;
        $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
        while ($row = mysqli_fetch_array($query)) {
            if ($row['condiciones'] == 1) {
                $totalEfectivo += $row['monto_factura'];
            } elseif ($row['condiciones'] == 2) {
                $totalCheque += $row['monto_factura'];
            } elseif ($row['condiciones'] == 3) {
                $totalBanco += $row['monto_factura'];
            } elseif ($row['condiciones'] == 4 and $row['estado_factura'] == 2) {
                $totalCredito += $row['monto_factura'];
            }
            $totalVentas += $row['monto_factura'];
        }
        //---------------------------------------------------------------------------------------
        $abonoSql    = "SELECT * FROM creditos_abonos where fecha_abono between '$fecha_inicial' and '$fecha_final'";
        $abonoQuery  = $conexion->query($abonoSql);
        $total_abono = 0;
        while ($abonoResult = $abonoQuery->fetch_assoc()) {
            $total_abono += $abonoResult['abono'];
        }
//---------------------------------------------------------------------------------------
        ?>
        <div class="col-sm-6">
          <table class="table table-bordered" cellspacing="0" style="width: 100%;font-size: 12pt;">
            <tr class="success">
              <td style="width:100%; text-align: center;" colspan="2">Ventas</td>
            </tr>
            <tr>
             <td style="width:50%;text-align: left;">Efectivo Ventas:</td>
             <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalEfectivo, 2); ?></td>
           </tr>
           <tr>
             <td style="width:50%;text-align: left;">Cheque:</td>
             <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalCheque, 2); ?></td>
           </tr>
           <tr>
             <td style="width:50%;text-align: left;">Tranferencia Bancaria:</td>
             <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalBanco, 2); ?></td>
           </tr>
           <tr>
             <td style="width:50%;text-align: left;">Crédito:</td>
             <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalCredito, 2); ?></td>
           </tr>
           <tr>
             <td style="width:50%;text-align: right;font-weight:bold;">Total Ventas:</td>
             <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalVentas, 2); ?></td>
           </tr>
         </table>
       </div>
       <?php
$totalEntrada   = 0;
        $totalSalida    = 0;
        $total_efectivo = 0;
        if ($employee_id > 0) {
            $caja = mysqli_query($conexion, "select * from caja_chica where users_caja='" . $employee_id . "' and date_added_caja between '$fecha_inicial' and '$fecha_final'");
        } else {
            $caja = mysqli_query($conexion, "select * from caja_chica where date_added_caja between '$fecha_inicial' and '$fecha_final'");
        }
        while ($rw = mysqli_fetch_array($caja)) {
            if ($rw['tipo_caja'] == 1) {
                $totalEntrada += $rw['monto_caja'];
            } elseif ($rw['tipo_caja'] == 2) {
                $totalSalida += $rw['monto_caja'];
            }
            $total_efectivo = $totalSalida - $totalEntrada;
        }

        ?>
      <div class="col-sm-6">
       <table class="table table-bordered" cellspacing="0" style="width: 100%;font-size: 12pt;">
        <tr class="success">
         <td style="width:100%; text-align: center;" colspan="2">Control de Efectivo</td>
       </tr>
       <tr>
         <td style="width:50%;text-align: left;">Entradas de Dinero:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalEntrada, 2); ?></td>
       </tr>
       <tr>
         <td style="width:50%;text-align: left;">Salidas de Caja:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalSalida, 2); ?></td>
       </tr>
        <tr>
         <td style="width:50%;text-align: left;">Cuentas por Cobrar:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($total_abono, 2); ?></td>
     </tr>
       <tr>
         <td style="width:50%;text-align: right;font-weight:bold;">Total Efectivo:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($total_efectivo + $total_abono, 2); ?></td>
       </tr>
     </table>
   </div>
   <br>
   <div class="col-sm-12">
     <table class="table table-striped" cellspacing="0" style="width: 100%;font-size: 14pt;">
       <tr class="danger">
         <td style="width:50%;text-align: right;font-weight:bold;">Total Caja:</td>
         <td style="width:50%; text-align: left;"><?php echo $simbolo_moneda . '' . number_format($totalEfectivo + $total_abono, 2); ?></td>
       </tr>
     </table>
   </div>

 </div>



 <?php
}
}
?>

