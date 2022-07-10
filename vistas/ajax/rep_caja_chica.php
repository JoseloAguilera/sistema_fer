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
    $tipo_caja = intval($_REQUEST['tipo_caja']);
    $tables    = "caja_chica,  users";
    $campos    = "*";
    $sWhere    = "users.id_users=caja_chica.users_caja";
    if ($tipo_caja > 0) {
        $sWhere .= " and caja_chica.tipo_caja = '" . $tipo_caja . "' ";
    }
    if (!empty($daterange)) {
        list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
        list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
        $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
        list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
        $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";

        $sWhere .= " and caja_chica.date_added_caja between '$fecha_inicial' and '$fecha_final' ";
    }
    $sWhere .= " order by caja_chica.id_caja";

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
    $reload      = '../rep_ventas.php';
    //main query to fetch the data
    $query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
    //loop through fetched data

    if ($numrows > 0) {
        ?>

        <div class="table-responsive">
            <table class="table table-condensed table-hover table-striped ">
                <tr>
                    <th class='text-center'>Referencia</th>
                    <th>Descripción</th>
                    <th class='text-center'>Fecha </th>
                    <th class='text-center'>Transacción </th>
                    <th>Usuario </th>
                    <th class='text-left'>Monto </th>
                </tr>
                <?php
$finales = 0;
        while ($row = mysqli_fetch_array($query)) {
            $referencia_caja   = $row['referencia_caja'];
            $descripcion_caja  = $row['descripcion_caja'];
            $date_added        = $row['date_added_caja'];
            $user_fullname     = $row['nombre_users'] . ' ' . $row['apellido_users'];
            $subtotal          = $row['monto_caja'];
            $total             = $row['monto_caja'];
            $tipo_caja         = $row['tipo_caja'];
            list($date, $hora) = explode(" ", $date_added);
            list($Y, $m, $d)   = explode("-", $date);
            $fecha             = $d . "-" . $m . "-" . $Y;
            $finales++;
            $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
            if ($tipo_caja == 1) {
                $text_estado = "Ingreso";
                $label_class = 'label-success';} else {
                $text_estado = "Egreso";
                $label_class = 'label-danger';}
            ?>
                    <tr>
                        <td class='text-center'><label class='label label-purple'><?php echo $referencia_caja; ?></label></td>
                        <td><?php echo $descripcion_caja; ?></td>
                        <td class='text-center'><?php echo $fecha; ?></td>
                        <td class='text-center'><span class="label <?php echo $label_class; ?>"><?php echo $text_estado; ?></span></td>
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

