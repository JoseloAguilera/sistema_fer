<?php

/*-------------------------
Autor: Obed Alvarado
Web: obedalvarado.pw
Mail: info@obedalvarado.pw
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['qx'], ENT_QUOTES)));
    $aColumns = array('id_consulta', 'id_paciente'); //Columnas de busqueda
    $sTable   = "consultas";
    $sWhere   = "";
    if ($_GET['qx'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 5; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../html/pacientes.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($conexion, $sql);
    //loop through fetched data
    if ($numrows > 0) {

        ?>
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <tr  class="info">
                    <th>No. Consulta</th>
                    <th>Motivo Consulta</th>
                    <th>Diagnostico Consulta</th>
                    <th>Fecha</th>
                </tr>
                <?php
while ($row = mysqli_fetch_array($query)) {
            $id_consulta          = $row['id_consulta'];
            $motivo_consulta      = $row['motivo_consul'];
            $diagnostico_consulta = $row['diagnostico_consul'];
            $date_added           = $row['date_added'];
            ?>
                    <tr>
                        <td><?php echo $id_consulta; ?></td>
                        <td><?php echo $motivo_consulta; ?></td>
                        <td><?php echo $diagnostico_consul; ?></td>
                        <td><?php echo $date_added; ?></td>
                    </tr>
                    <?php
}
        ?>
                <tr>
                    <td colspan=6><span class="pull-right">
                    <?php
echo paginate($reload, $page, $total_pages, $adjacents);
        ?></span></td>
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
      <strong>Aviso!</strong> No hay Registro de Producto
  </div>
  <?php
}
// fin else
}
?>