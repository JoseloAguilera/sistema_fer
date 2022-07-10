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
    $daterange      = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['range'], ENT_QUOTES)));
    $estado_factura = intval($_REQUEST['estado_factura']);
    $tables         = "facturas_compras,  users";
    $campos         = "*";
    $sWhere         = "users.id_users=facturas_compras.id_users_factura";
    if ($estado_factura > 0) {
        $sWhere .= " and facturas_compras.estado_factura = '" . $estado_factura . "' ";
    }
    if (!empty($daterange)) {
        list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
        list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
        $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
        list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
        $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";

        $sWhere .= " and facturas_compras.fecha_factura between '$fecha_inicial' and '$fecha_final' ";
    }
    $sWhere .= " order by facturas_compras.id_factura";

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
    $reload      = '../rep_compras.php';
    //main query to fetch the data
    $query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
    //loop through fetched data

    if ($numrows > 0) {
        ?>

        <div class="table-responsive">
            <table class="table table-condensed table-hover table-striped table-sm">
                <tr>
                    <th class='text-center'>Factura Nº</th>
                    <th>Proveedor</th>
                    <th class='text-center'>Fecha </th>
                    <th class='text-center'>Estado Factura </th>
                    <th>Usuario </th>
                    <th class='text-left'>Total </th>
                </tr>
                <?php
$finales = 0;
        while ($row = mysqli_fetch_array($query)) {
            $factura           = $row['numero_factura'];
            $date_added        = $row['fecha_factura'];
            $user_fullname     = $row['nombre_users'] . ' ' . $row['apellido_users'];
            $subtotal          = $row['monto_factura'];
            $total             = $row['monto_factura'];
            $id_proveedor      = $row['id_proveedor'];
            $estado_factura    = $row['estado_factura'];
            $sql               = mysqli_query($conexion, "select nombre_proveedor from proveedores where id_proveedor='" . $id_proveedor . "'");
            $rw                = mysqli_fetch_array($sql);
            $nombre_proveedor  = $rw['nombre_proveedor'];
            list($date, $hora) = explode(" ", $date_added);
            list($Y, $m, $d)   = explode("-", $date);
            $fecha             = $d . "-" . $m . "-" . $Y;
            $finales++;
            $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
            if ($estado_factura == 1) {
                $text_estado = "Pagada";
                $label_class = 'badge-success';} else {
                $text_estado = "Pendiente";
                $label_class = 'badge-warning';}
            ?>
                    <tr>
                        <td class='text-center'><label class='badge badge-purple'><?php echo $factura; ?></label></td>
                        <td><?php echo $nombre_proveedor; ?></td>
                        <td class='text-center'><?php echo $fecha; ?></td>
                        <td class='text-center'><span class="badge <?php echo $label_class; ?>"><?php echo $text_estado; ?></span></td>
                        <td><?php echo $user_fullname; ?></td>
                        <td class='text-left'><b><?php echo $simbolo_moneda . '' . number_format($total, 2); ?></b></td>
                    </tr>
                    <?php }?>
                </table>
            </div>

            <div class="box-footer clearfix" align="right">

                <?php
$inicios = $offset + 1;
        $finales += $inicios - 1;
        echo "Mostrando $inicios al $finales de $numrows registros";
        echo paginate($reload, $page, $total_pages, $adjacents);?>

            </div>

            <?php
}
}
?>

