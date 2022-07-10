<?php

/*-------------------------
Autor: Delmar Lopez
Web: softwys.com
Mail: softwysop@gmail.com
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Categorias";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
//Archivo de funciones PHP
require_once "../funciones.php";
$id_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('nombre_comp'); //Columnas de busqueda
    $sTable   = "comprobantes";
    $sWhere   = "";
    if ($_GET['q'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= " order by id_comp";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../html/comprobantes.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($conexion, $sql);
    //loop through fetched data
    if ($numrows > 0) {

        ?>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <tr  class="info">
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Serie</th>
                    <th>Desde</th>
                    <th>hasta</th>
                    <th>Longitud</th>
                    <th>Num. Actual</th>
                    <th>Estado</th>
                    <th class='text-right'>Acciones</th>

                </tr>
                <?php
while ($row = mysqli_fetch_array($query)) {
            $id_comp          = $row['id_comp'];
            $nombre_comp      = $row['nombre_comp'];
            $serie_comp       = $row['serie_comp'];
            $desde_comp       = $row['desde_comp'];
            $hasta_comp       = $row['hasta_comp'];
            $long_comp        = $row['long_comp'];
            $actual_comp      = $row['actual_comp'];
            $vencimiento_comp = $row['vencimiento_comp'];
            $estado_comp      = $row['estado_comp'];
            if ($estado_comp == 1) {
                $estado = "<span class='badge badge-success'>Activo</span>";
            } else {
                $estado = "<span class='badge badge-danger'>Inactivo</span>";
            }

            ?>

    <input type="hidden" value="<?php echo $nombre_comp; ?>" id="nombre_comp<?php echo $id_comp; ?>">
    <input type="hidden" value="<?php echo $serie_comp; ?>" id="serie_comp<?php echo $id_comp; ?>">
    <input type="hidden" value="<?php echo $desde_comp; ?>" id="desde_comp<?php echo $id_comp; ?>">
    <input type="hidden" value="<?php echo $hasta_comp; ?>" id="hasta_comp<?php echo $id_comp; ?>">
    <input type="hidden" value="<?php echo $long_comp; ?>" id="long_comp<?php echo $id_comp; ?>">
    <input type="hidden" value="<?php echo $actual_comp; ?>" id="actual_comp<?php echo $id_comp; ?>">
    <input type="hidden" value="<?php echo $vencimiento_comp; ?>" id="vencimiento_comp<?php echo $id_comp; ?>">
    <input type="hidden" value="<?php echo $estado_comp; ?>" id="estado_comp<?php echo $id_comp; ?>">


    <tr>
        <td><span class="badge badge-purple"><?php echo $id_comp; ?></span></td>
        <td><?php echo $nombre_comp; ?></td>
        <td><?php echo $serie_comp; ?></td>
        <td><?php echo $desde_comp; ?></td>
        <td><?php echo $hasta_comp; ?></td>
        <td><?php echo $long_comp; ?></td>
        <td><?php echo $actual_comp; ?></td>
        <td><?php echo $estado; ?></td>
        <td >
            <div class="btn-group dropdown">
                <button type="button" class="btn btn-warning btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                <div class="dropdown-menu dropdown-menu-right">
                   <?php if ($permisos_editar == 1) {?>
                   <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editarComp" onclick="obtener_datos('<?php echo $id_comp; ?>');"><i class='fa fa-edit'></i> Editar</a>
                   <?php }
            if ($permisos_eliminar == 1) {?>
                   <a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $id_comp; ?>"><i class='fa fa-trash'></i> Borrar</a>
                   <?php }
            ?>


               </div>
           </div>

       </td>

   </tr>
   <?php
}
        ?>
<tr>
    <td colspan="7">
        <span class="pull-right">
            <?php
echo paginate($reload, $page, $total_pages, $adjacents);
        ?></span>
        </td>
    </tr>
</table>
</div>
<?php
}
//Este else Fue agregado de Prueba de prodria Quitar
    else {
        ?>
    <div class="alert alert-warning alert-dismissible" role="alert" align="center">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Aviso!</strong> No hay Registro de Comprobantes
  </div>
  <?php
}
// fin else
}
?>