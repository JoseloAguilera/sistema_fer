<?php
include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
#require_once "../libraries/inventory.php"; //Contiene funcion que controla stock en el inventario
//Inicia Control de Permisos
$user_id = $_SESSION['id_users'];
$id_g    = $_SESSION['id'];
include "../permisos.php";
get_cadena($user_id);
$modulo = "Productos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
//Archivo de funciones PHP
require_once "../funciones.php";
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    //$tipo      = intval($_REQUEST['tipo']);
    //$trans     = intval($_REQUEST['trans']);
    $daterange = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['range'], ENT_QUOTES)));

    $tables = "kardex, productos";
    $campos = "*";
    $sWhere = "kardex.producto_kardex=productos.id_producto";
    /*if ($tipo > 0) {
    $sWhere .= " and facturas.tipo_factura = '" . $tipo . "' ";
    }
    if ($trans > 0) {
    $sWhere .= " and facturas.transaccion = '" . $trans . "' ";
    }*/
    if (!empty($daterange)) {
        list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
        list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
        $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
        list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
        $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";

        $sWhere .= " and kardex.fecha_kardex between '$fecha_inicial' and '$fecha_final' ";
    }
    $sWhere .= " and kardex.producto_kardex='" . $id_g . "'";

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
    $reload      = '../historial_pagos.php';
    //main query to fetch the data
    $query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
    //loop through fetched data

    if ($numrows > 0) {
        ?>

        <div class="table-responsive">
        <table class="table table-condensed table-hover table-striped table-sm table-bordered">
            <tr>
            <th colspan="2" class='text-center'>Fecha</th>
            <th colspan="3" class='text-center'>Entradas</th>
            <th colspan="3" class='text-center'>Salidas</th>
            <th colspan="3" class='text-center'>Saldo</th>
            </tr>
            <tr>
            <th class='text-center'></th>
            <th class='text-center'>Detalle</th>
            <th class='text-center'>Cant.</th>
            <th class='text-center'>Costo</th>
            <th class='text-center'>Total</th>
            <th class='text-center'>Cant.</th>
            <th class='text-center'>Costo</th>
            <th class='text-center'>Total</th>
            <th class='text-center'>Cant.</th>
            <th class='text-center'>Costo</th>
            <th class='text-center'>Total</th>

            </tr>
             <?php
$finales        = 0;
        $sumador_total  = 0;
        $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
        while ($row = mysqli_fetch_array($query)) {
            $id_kardex       = $row['id_kardex'];
            $fecha_kardex    = date("d/m/Y", strtotime($row['fecha_kardex']));
            $producto_kardex = $row['producto_kardex'];
            $cant_entrada    = $row['cant_entrada'];
            $costo_entrada   = $row['costo_entrada'];
            $total_entrada   = $row['total_entrada'];
            $cant_salida     = $row['cant_salida'];
            $costo_salida    = $row['costo_salida'];
            $total_salida    = $row['total_salida'];
            $cant_saldo      = $row['cant_saldo'];
            $costo_saldo     = $row['costo_saldo'];
            $total_saldo     = $row['total_saldo'];
            $tipo            = $row['tipo_movimiento'];
            if ($tipo == 1) {
                $movto = 'COMPRA';
            } else if ($tipo == 3 or $tipo == 4) {
                $movto = 'AJUSTE';
            } else if ($tipo == 5) {
                $movto = 'INICIAL';
            } else {
                $movto = 'VENTA';
            }

            $finales++;
            ?>
            <tr>
            <td class='text-center'><?php echo $fecha_kardex; ?></td>
            <td class='text-center'><?php echo $movto; ?></td>
            <td class='text-center table-success'><?php echo $cant_entrada; ?></td>
            <td class='text-center table-success'><?php echo formato($costo_entrada); ?></td>
            <td class='text-center table-success'><?php echo formato($total_entrada); ?></td>
            <td class='text-center table-danger'><?php echo $cant_salida; ?></td>
            <td class='text-center table-danger'><?php echo formato($costo_salida); ?></td>
            <td class='text-center table-danger'><?php echo formato($total_salida); ?></td>
            <td class='text-center table-info'><?php echo $cant_saldo; ?></td>
            <td class='text-center table-info'><?php echo formato($costo_saldo); ?></td>
            <td class='text-center table-info'><?php echo formato($total_saldo); ?></td>
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

