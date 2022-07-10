<?php
include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
$numero_factura = $_SESSION['numero_factura'];
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
#require_once "../libraries/inventory.php"; //Contiene funcion que controla stock en el inventario
//Inicia Control de Permisos
include "../permisos.php";
//Archivo de funciones PHP
require_once "../funciones.php";
$user_id        = $_SESSION['id_users'];
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
$action         = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $daterange = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['range'], ENT_QUOTES)));
    $tables    = "creditos_abonos";
    $campos    = "*";
    $sWhere    = "numero_factura='" . $numero_factura . "'";
    if (!empty($daterange)) {
        list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
        list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
        $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
        list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
        $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";

        $sWhere .= " and fecha_abono between '$fecha_inicial' and '$fecha_final' ";
    }
    $sWhere .= " order by id_abono DESC";

    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $tables where $sWhere ");
    if ($row = mysqli_fetch_array($count_query)) {$numrows = $row['numrows'];} else {echo mysqli_error($conexion);}
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../ver_cxc.php';
    //main query to fetch the data
    $query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
    //loop through fetched data

    if ($numrows > 0) {
        ?>

        <div class="table-responsive">
            <table class="table table-sm table table-condensed table-hover table-striped ">
                <tr>
                    <th>Factura</th>
                    <th>Fecha</th>
                    <th>Crédito</th>
                    <th>Abonos</th>
                    <th>Saldo</th>
                    <th></th>
                </tr>
                <?php
$finales = 0;
        while ($row = mysqli_fetch_array($query)) {
            $id_users = $row['id_users_abono'];
            $sql      = mysqli_query($conexion, "select usuario_users from users where id_users='" . $id_users . "'");
            $rw       = mysqli_fetch_array($sql);
            $usuario  = $rw['usuario_users'];
            ?>
                    <tr>
                        <td><label class='badge badge-purple'><?php echo $row['numero_factura']; ?></label></td>
                        <td><?php echo date("d/m/Y", strtotime($row['fecha_abono'])); ?></td>
                        <td><?php echo $simbolo_moneda . ' ' . number_format($row['monto_abono'], 0,"","."); ?></td>
                        <td><?php echo $simbolo_moneda . ' ' . number_format($row['abono'], 0,"","."); ?></td>
                        <td><?php echo $simbolo_moneda . ' ' . number_format($row['saldo_abono'], 0,"","."); ?></td>
                        <td><a class='btn btn-info btn-sm waves-effect waves-light' href="#" title="Imprimir Resibo" onclick="imprimir_abono('<?php echo $row['id_abono']; ?>');"><i class="fa fa-print"></i>
                        </a>
                        </td>
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

