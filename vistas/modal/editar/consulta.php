<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
/* Connect To Database*/
require_once "../../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../../php_conexion.php"; //Contiene funcion que conecta a la base de datos
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $id = intval($id);
} else {echo "<script>location.replace('../../consulta.php')</script>";}
?>

    <table class="table table-sm" id="productTable2">
        <thead>
            <tr>
                <th style="width:30%;">Medicamento</th>
                <th style="width:40%;">Indicación</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php

$orderItemSql    = "SELECT receta_medica.id_receta, receta_medica.id_consulta, receta_medica.medicamento_receta,  receta_medica.indicacion_receta FROM receta_medica WHERE receta_medica.id_consulta = {$id}";
$orderItemResult = $conexion->query($orderItemSql);
// $orderItemData = $orderItemResult->fetch_all();

// print_r($orderItemData);
$arrayNumber = 0;
// for($x = 1; $x <= count($orderItemData); $x++) {
$x = 1;
while ($orderItemData = $orderItemResult->fetch_array()) {
    // print_r($orderItemData); ?>
        <tr id="row2<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
            <td style="margin-left:20px;">
                <div class="form-group">

                    <select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
                        <option value="">-- Selecciona --</option>
                        <?php
$productSql  = "SELECT * FROM medicamentos WHERE estado_medicamento = 1";
    $productData = $conexion->query($productSql);

    while ($row = $productData->fetch_array()) {
        $selected = "";
        if ($row['id_medicamento'] == $orderItemData['medicamento_receta']) {
            $selected = "selected";
        } else {
            $selected = "";
        }

        echo "<option value='" . $row['id_medicamento'] . "' id='changeProduct" . $row['id_medicamento'] . "' " . $selected . " >" . $row['nombre_medicamento'] . "</option>";
    } // /while

    ?>
    </select>
</div>
</td>
<td style="padding-left:20px;">
    <input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['indicacion_receta']; ?>" />
    <input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="0" />
</td>
<td>

    <button class="btn btn-danger waves-effect waves-light removeProductRowBtn2" type="button" id="removeProductRowBtn2" onclick="removeProductRow2(<?php echo $x; ?>)"><i class="fa fa-remove"></i></button>
</td>
</tr>
<?php
$arrayNumber++;
    $x++;
} // /for
?>
</tbody>
</table>
<div class="form-group submitButtonFooter" align="center">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="button" class="btn btn-success  waves-effect waves-light" onclick="addRowEdit()" id="addRowBtn2" data-loading-text="Cargando..."> <i class="fa fa-plus"></i> Añadir fila </button>
    </div>
</div>