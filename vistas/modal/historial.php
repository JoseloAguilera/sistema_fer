<style type="text/css">
    <!--
    table { vertical-align: top; }
    tr    { vertical-align: top; }
    td    { vertical-align: top; }
    .midnight-blue{
        background:#2c3e50;
        padding: 4px 4px 4px;
        color:white;
        font-weight:bold;
        font-size:12px;
    }
    .silver{
        background:white;
        padding: 3px 4px 3px;
    }
    .clouds{
        background:#ecf0f1;
        padding: 3px 4px 3px;
    }
    .border-top{
        border-top: solid 1px #bdc3c7;

    }
    .border-left{
        border-left: solid 1px #bdc3c7;
    }
    .border-right{
        border-right: solid 1px #bdc3c7;
    }
    .border-bottom{
        border-bottom: solid 1px #bdc3c7;
    }
    table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<?php
include "../ajax/is_logged.php"; //Archivo comprueba si el usuario esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
#require_once "../libraries/inventory.php"; //Contiene funcion que controla stock en el inventario
//Inicia Control de Permisos
include "../permisos.php";
if (isset($_REQUEST['id_paciente'])) {
    $id_paciente = intval($_REQUEST['id_paciente']);
//consulta
    $sql    = "SELECT * FROM consultas, pacientes WHERE consultas.id_paciente=pacientes.id_paciente and consultas.id_paciente = '$id_paciente' group by consultas.id_paciente";
    $result = $conexion->query($sql);
    $data   = $result->fetch_array();
    if ($data > 0) {
        ?>

    <div class="row">
        <table cellspacing="0" style="width:50 % ;
text - align:left;
font - size:12pt;">
            <tr>
                <td style="width:50 % ;" class='midnight-blue'>INFORMACION DE PACIENTE:</td>
            </tr>
            <tr>
                <td style="width:50 % ;" >
                    <?php
echo "<b>Nombre: </b>";
        echo $data['nombre_paciente'];
        echo "<br> <b>Dirección: </b>";
        echo $data['direccion_paciente'];
        echo "<br> <b>Teléfono: </b>";
        echo $data['telefono_paciente'];
        echo "<br><b>Email: </b> ";
        echo $data['email_paciente'];
        echo "<br>";
        echo "<br>";
        ?>

                </td>
            </tr>
        </table></br></br>
</hr>
        <div class="table-responsive">
        <table class="table table-sm" >
            <thead class="thead-default">
                <tr>
                    <th>No. Consulta</th>
                    <th>Motivo Consulta</th>
                    <th>Diagnostico</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
$arrayNumber = 0;
// for($x = 1; $x <= count($orderItemData); $x++) {
        $x               = 1;
        $orderItemSql    = "SELECT * FROM consultas WHERE consultas.id_paciente ='$id_paciente' order by date_added desc";
        $orderItemResult = $conexion->query($orderItemSql);
        while ($orderItemData = $orderItemResult->fetch_array()) {
            // print_r($orderItemData); ?>
        <tr>
            <td class="text-center"><span class="badge badge-pill badge-primary"><?php echo $orderItemData['id_consulta']; ?></span></td>
            <td><?php echo $orderItemData['motivo_consul']; ?> </td>
            <td><?php echo $orderItemData['diagnostico_consul']; ?></td>
            <td><?php echo $orderItemData['date_added']; ?></td>
        </tr>
        <?php
$arrayNumber++;
            $x++;
        } // /for
    } //Este else Fue agregado de Prueba de prodria Quitar
    else {
        ?>
    <div class="alert alert-warning alert-dismissible" role="alert" align="center">
      <strong>Aviso!</strong> No hay Registro de Consultas
  </div>
  <?php
}
// fin else
    ?>

</tbody>
</table>
</div>
</div>

<!-- /row -->
<?php }?>