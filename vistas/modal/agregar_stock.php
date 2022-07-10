<?php
if (isset($conexion)) {
    ?>
  <form class="form-horizontal"  method="post" name="add_stock" id="add_stock">
    <!-- Modal -->
    <div id="add-stock" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title"> <i class="fa fa-edit"></i> Agregar Stock</h4>
          </div>
          <div class="modal-body">
            <!--<div id="resultados_ajax"></div>-->

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="quantity" class="control-label">Cantidad:</label>
                  <input type="text" class="form-control" id="quantity" name="quantity" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="reference" class="control-label">Referencia:</label>
                  <input type="text" class="form-control" id="reference" name="reference" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="motivo" class="control-label">Motivo:</label>
                  <input type="text" class="form-control" id="motivo" name="motivo" autocomplete="off">
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light" id="guardar_datos">Guardar</button>
          </div>
        </div>

      </div>
    </div>
  </form>
  <?php
}
?>
