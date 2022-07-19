<?php
include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
$id_producto = $_SESSION['id'];
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
    $tipo      = intval($_REQUEST['tipo']);
    $tables    = "historial_productos";
    $campos    = "*";
    $sWhere    = "id_producto='" . $id_producto . "'";
    if ($tipo > 0) {
        $sWhere .= " and tipo_historial = '" . $tipo . "' ";
    }
    if (!empty($daterange)) {
        list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
        list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
        $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
        list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
        $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";

        $sWhere .= " and fecha_historial between '$fecha_inicial' and '$fecha_final' ";
    }
    $sWhere .= " order by id_historial";

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
    $reload      = '../ver_historial.php';
    //main query to fetch the data
    $query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
    //loop through fetched data
    
    ?><div style="margin-bottom: 1%;"> 
        <strong  style="color: #52bb56; font-size: 150%; ">Existencia actual: <?php echo consulta_stock($id_producto); ?></strong>
    </div>

    <?php
    if ($numrows > 0) {
        ?>

        <div class="table-responsive">
            <table class="table table-sm table table-condensed table-hover table-striped ">
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Descripción</th>
                    <th>Referencia</th>
                    <th>Tipo</th>
                    <th class='text-center'>Total</th>
                </tr>
                <?php
$finales = 0;
        while ($row = mysqli_fetch_array($query)) {
            if ($row['tipo_historial'] == 1) {
                $tipo = "<label class='badge badge-success'>Entrada</label>";
            } else {
                $tipo = "<label class='badge badge-danger'>Salida</label>";
            }
            $id_users = $row['id_users'];
            $sql      = mysqli_query($conexion, "select usuario_users from users where id_users='" . $id_users . "'");
            $rw       = mysqli_fetch_array($sql);
            $usuario  = $rw['usuario_users'];
            ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($row['fecha_historial'])); ?></td>
                                <td><?php echo date('H:i:s', strtotime($row['fecha_historial'])); ?></td>
                                <td><?php echo $usuario . ' ' . $row['nota_historial']; ?></td>
                                <td><?php echo $row['referencia_historial']; ?></td>
                                <td><?php echo $tipo; ?></td>
                                <td class='text-center'><?php echo $row['cantidad_historial']; ?></td>
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

