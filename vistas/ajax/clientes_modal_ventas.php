<?php
/*-------------------------
Autor: Delmar Lopez
Web: www.softwys.com
Mail: softwysop@gmail.com
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $t        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['t'], ENT_QUOTES)));
    //var_dump($t);
    $aColumns = array('fiscal_cliente', 'nombre_cliente'); //Columnas de busqueda
    $sTable   = "clientes";
    $sWhere   = "";
    if ($_GET['t'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $t . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
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
    $reload      = '../venta/prueba.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($conexion, $sql);
    //loop through fetched data
    if ($numrows > 0) {

        ?>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm">
                <tr  class="info">
                    <th></th>
                    
                    <th class='text-center'>RUC/CI</th>
                    <th class='text-center'>NOMBRE</th>
                    <th class='text-center'>TELEFONO</th>
                    <th class='text-center'>DIRECCION</th>
                    
                </tr>
                <?php
while ($row = mysqli_fetch_array($query)) {
            $id_client    = $row['id_cliente'];
            $nombre_cliente = $row['nombre_cliente'];
            $fiscal_cliente  = $row['fiscal_cliente'];
            $telefono_cliente    = $row["telefono_cliente"];
            $direccion_cliente    = $row['direccion_cliente'];
            $correo        = $row['email_cliente'];
            ?>
                    <tr>
                        <td class='text-center'>
                        <?php
/*if ($image_path == null) {
                echo '<img src="../../img/productos/default.jpg" class="" width="60">';
            } else {
                echo '<img src="' . $image_path . '" class="" width="60">';
            }*/

            ?>
                                <!--<img src="<?php echo $image_path; ?>" alt="Product Image" class='rounded-circle' width="60">-->
                            </td>
                            <td><?php echo $fiscal_cliente; ?></td>
                        <td><?php echo $nombre_cliente; ?></td>
                        <td><?php echo $telefono_cliente; ?></td>
                        <td><?php echo $direccion_cliente; ?></td>
                        <!--td class='col-xs-1' width="15%"-->
                        <!--div class="pull-right"-->
                        <!--input type="text" class="form-control" style="text-align:center" id="documento"  value="<?php echo $fiscal_cliente; ?>" -->
                        <!--/div-->
                        <!--/td-->
                        <!--td class='col-xs-2' width="15%"><div class="pull-right"-->
                        <!--input type="text" class="form-control" style="text-align:center" id="nombre_cliente"  value="<?php echo $nombre_cliente; ?>" -->
                        <!--/div></td-->
                        
                        
                        <td class='text-center'>
                        <a class='btn btn-success' href="#" title="Agregar Cliente" onclick="agregar_cliente('<?php echo $id_client ?>','<?php echo $nombre_cliente ?>','<?php echo $fiscal_cliente ?>','<?php echo $correo ?>')"><i class="fa fa-plus"></i>
                        </a>
                        </td>
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
      <strong>Aviso!</strong> No hay Registro de Producto
  </div>
  <?php
}
// fin else
}
?>