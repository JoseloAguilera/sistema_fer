<?php
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
if (isset($_REQUEST['numero_factura'])) {
    $numero_factura = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST["numero_factura"], ENT_QUOTES)));
    ?>
  <div class="alert alert-danger">
    <strong>Ojo!</strong> Realizar Cobro de la Factura No. <strong><?php echo $numero_factura; ?></strong>
  </div>
    <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="abono" class="control-label">Abono:</label>
                  <input type="text" class="form-control" id="abono" name="abono" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required autofocus>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="concepto" class="control-label">En Concepto de:</label>
                  <input type="text" class="form-control UpperCase" id="concepto" name="concepto" autocomplete="off" required>
                </div>
              </div>
            </div>
<?php }?>