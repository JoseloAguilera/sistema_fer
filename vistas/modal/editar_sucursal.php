<?php
if (isset($conexion)) {
    ?>
	<div id="editarSucursal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Editar Sucursal</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_sucursal" name="editar_sucursal">
						<div id="resultados_ajax2"></div>

							<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="mod_codigo" class="control-label">Código:</label>
									<input type="text" class="form-control" id="mod_codigo" name="mod_codigo"  autocomplete="off" required readonly>
									<input id="mod_id" name="mod_id" type='hidden'>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="mod_nombre" class="control-label">Nombre:</label>
									<input type="text" class="form-control UpperCase" id="mod_nombre" name="mod_nombre"  autocomplete="off" required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="mod_direccion" class="control-label">Dirección:</label>
									<textarea class="form-control UpperCase"  id="mod_direccion" name="mod_direccion" maxlength="255"  autocomplete="off"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								<label for="mod_limite" class="control-label">Limite %:</label>
									<input type="text" class="form-control" id="mod_limite" name="mod_limite" required pattern="\d{1,4}"  maxlength="4">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="mod_estado" class="control-label">Estado:</label>
									<select class="form-control" id="mod_estado" name="mod_estado" required>
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