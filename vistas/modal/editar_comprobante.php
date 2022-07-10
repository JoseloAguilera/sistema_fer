<?php
if (isset($conexion)) {
    ?>
	<div id="editarComp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Editar Comprobante</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_comprobante" name="editar_comprobante">
						<div id="resultados_ajax2"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre2" class="control-label">Nombre:</label>
									<input type="text" class="form-control UpperCase" id="nombre2" name="nombre2"  autocomplete="off" required>
									<input id="mod_id" name="mod_id" type='hidden'>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="serie2" class="control-label">Serie:</label>
									<input type="text" class="form-control UpperCase" id="serie2" name="serie2"  autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="desde2" class="control-label">Desde:</label>
									<input type="number" class="form-control" id="desde2" name="desde2"  autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="hasta2" class="control-label">Hasta:</label>
									<input type="number" class="form-control" id="hasta2" name="hasta2"  autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="long2" class="control-label">Longitud:</label>
									<input type="number" class="form-control" id="long2" name="long2"  autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="num_actual2" class="control-label">Numero actual:</label>
									<input type="number" class="form-control" id="num_actual2" name="num_actual2"  autocomplete="off" required>
								</div>
							</div>
						</div>


						<div class="row">
						<div class="col-md-6">
								<div class="form-group">
									<label for="fecha_venc2" class="control-label">Fecha Vendimiento:</label>
									<input type="date" class="form-control" id="fecha_venc2" name="fecha_venc2"  autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-6">
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