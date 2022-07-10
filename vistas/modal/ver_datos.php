<?php
if (isset($conexion)) {
    ?>
  <form class="form-horizontal"  method="post" name="add_abono" id="add_abono">
    <!-- Modal -->
    <div id="add-pago" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title"> <i class="fa fa-edit"></i> Agregar Abono</h4>
          </div>
          <div class="modal-body">
          <div class="outer_datos"></div>

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
