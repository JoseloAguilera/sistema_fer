<?php
if (isset($conexion)) {
    ?>
	<div id="editarGasto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Editar Medicamento</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_gasto" name="editar_gasto">
						<div id="resultados_ajax2"></div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="mod_referencia" class="control-label">Referencia:</label>
									<input type="text" class="form-control" id="mod_referencia" name="mod_referencia"  autocomplete="off">
									<input id="mod_id" name="mod_id" type='hidden'>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="mod_monto" class="control-label">Monto</label>
									<input type="text" class="form-control" id="mod_monto" name="mod_monto" autocomplete="off">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="mod_descripcion" class="control-label">Descripción</label>
									<textarea class="form-control"  id="mod_descripcion" name="mod_descripcion" maxlength="255"  autocomplete="off" required></textarea>
								</div>
							</div>
						</div>




					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary waves-effect waves-light" id="actualizar_datos">Actualizar</button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal -->
	<?php
}
?>