<?php
if (isset($conexion)) {
    ?>
	<div id="editarImp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Editar Impuesto</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_impuesto" name="editar_impuesto">
						<div id="resultados_ajax2"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre2" class="control-label">Nombre:</label>
									<input type="text" class="form-control UpperCase" id="nombre2" name="nombre2"  autocomplete="off" required>
									<input id="mod_id" name="mod_id" type='hidden'>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="valor2" class="control-label">Porcentaje:</label>
									<input type="text" class="form-control" id="valor2" name="valor2"  autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="estado2" class="control-label">Estado:</label>
									<select class="form-control" id="estado2" name="estado2" required>
										<option value="">-- Selecciona --</option>
										<option value="1" selected>Activo</option>
										<option value="0">Inactivo</option>
									</select>
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