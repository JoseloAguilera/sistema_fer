<?php
if (isset($conexion)) {
    ?>
  <form class="form-horizontal"  method="post" name="add_abono" id="add_abono">
    <!-- Modal -->
    <div id="add-stock" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title"> <i class="fa fa-edit"></i> Agregar Abono</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="abono" class="control-label">Abono:</label>
                  <input type="text" class="form-control" id="abono" name="abono" autocomplete="off" maxlength="10000" required autofocus>
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
