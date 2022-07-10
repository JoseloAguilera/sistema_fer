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
    $daterange = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['range'], ENT_QUOTES)));
    $vendedor = intval($_REQUEST['vendedor']);
    $tables    = "detalle_fact_ventas,  productos, facturas_ventas";
    $campos    = "*";
    $sWhere    = "productos.id_producto=detalle_fact_ventas.id_producto and facturas_ventas.id_factura=detalle_fact_ventas.id_factura";
    if ($vendedor > 0) {
        $sWhere .= " and facturas_ventas.id_users_factura = '" . $vendedor . "'";
    }
    if (!empty($daterange)) {
        list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
        list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
        $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
        list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
        $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";

        $sWhere .= " and facturas_ventas.fecha_factura between '$fecha_inicial' and '$fecha_final' ";
    }
    $sWhere .= " group by detalle_fact_ventas.id_producto";

    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 100; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $numrows     = 0;
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $tables where $sWhere ");
    if ($row = mysqli_fetch_array($count_query)) {$numrows = $row['numrows'];} else {echo mysqli_error($conexion);}
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../rep_ventas.php';
    //main query to fetch the data
    $query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
    //loop through fetched data

    if ($numrows > 0) {
        ?>

        <div class="table-responsive">
            <table class="table table-condensed table-hover table-striped table-sm">
                <tr>
                    <th class='text-center'>Codigo</th>
                    <th>Producto</th>
                    <th>Cant.</th>
                    <th>Costo</th>
                    <th>Total Costo</th>
                    <th>Desc.</th>
                    <th>Total Vendido</th>
                    <th>Utilidad</th>
                </tr>
                <?php
$finales = 0;
        while ($row = mysqli_fetch_array($query)) {
            $id_producto     = $row['id_producto'];
            $codigo_producto = $row['codigo_producto'];
            $nombre_producto = $row['nombre_producto'];
            $costo_producto  = $row['costo_producto'];
            $precio_vendido  = $row['precio_venta'];
            $sql_kardex      = mysqli_query($conexion, "select * from kardex where producto_kardex='" . $id_producto . "' order by id_kardex DESC LIMIT 1");
            $rww             = mysqli_fetch_array($sql_kardex);
            $costo_saldo     = $rww['costo_saldo'];
            //calculos de totales
            $sql         = mysqli_query($conexion, "select sum(cantidad) as cant, sum(desc_venta) as d, sum(importe_venta) as pv from detalle_fact_ventas, facturas_ventas where facturas_ventas.id_factura=detalle_fact_ventas.id_factura and facturas_ventas.fecha_factura between '$fecha_inicial' and '$fecha_final' and  detalle_fact_ventas.id_producto='" . $id_producto . "'");
            $rw          = mysqli_fetch_array($sql);
            $cantidad    = $rw['cant'];
            $desc_venta  = $rw['d'];
            $total_costo = $cantidad * $costo_saldo;
            $total_pv    = $rw['pv'];

            $final_items = rebajas($total_pv, $desc_venta); //Aplicando el descuento
            $descuento   = $total_pv - $final_items;
            $utilidad    = $final_items - $total_costo;
            $finales++;
            $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
            ?>
                    <tr>
                        <td class='text-center'><label class='badge badge-purple'><?php echo $codigo_producto; ?></label></td>
                        <td><?php echo $nombre_producto; ?></td>
                        <td><span class="badge badge-success"><?php echo $cantidad; ?></span></td>
                        <td class='text-left'><?php echo $simbolo_moneda . '' . number_format($costo_saldo, 0,"","."); ?></td>
                        <td><b><?php echo $simbolo_moneda . ' ' . number_format($total_costo, 0,"","."); ?></b></td>
                        <td><?php echo $simbolo_moneda . ' ' . number_format($descuento, 0,"","."); ?></td>
                        <td><b><?php echo $simbolo_moneda . ' ' . number_format($final_items, 0,"","."); ?></b></td>
                        <td><b><?php echo $simbolo_moneda . ' ' . number_format($utilidad, 0,"","."); ?></b></td>
                    </tr>
                    <?php }?>
                </table>
            </div>

            <div class="box-footer clearfix" align="right">

                <?php
$inicios = $offset + 1;
        $finales += $inicios - 1;
        //echo "Mostrando $inicios al $finales de $numrows registros";
        echo paginate($reload, $page, $total_pages, $adjacents);?>

            </div>

            <?php
}
}
?>

