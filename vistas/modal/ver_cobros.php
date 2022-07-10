<?php
if (isset($conexion)) {
    ?>
  <!-- Modal -->
  <div class="modal fade" id="cobros" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class='fa fa-dollar'></i> Pago de consulta</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post" id="guardar_cobros" name="guardar_cobros">

            <div class="outer_cobros"></div>


          </div>
          <div class="modal-footer">
            <button type="submit" id="guardar_datosc" class="btn btn-primary waves-effect waves-light">Guardar Pago</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php
}
?>