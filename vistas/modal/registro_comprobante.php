<?php
if (isset($conexion)) {
    ?>
	<div id="nuevoComp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Nuevo Comprobante</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="guardar_comprobante" name="guardar_comprobante">
						<div id="resultados_ajax"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Nombre:</label>
									<input type="text" class="form-control UpperCase" id="nombre" name="nombre"  autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="serie" class="control-label">Serie:</label>
									<input type="text" class="form-control UpperCase" id="serie" name="serie"  autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="desde" class="control-label">Desde:</label>
									<input type="number" class="form-control" id="desde" name="desde"  autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="hasta" class="control-label">Hasta:</label>
									<input type="number" class="form-control" id="hasta" name="hasta"  autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="long" class="control-label">Longitud:</label>
									<input type="number" class="form-control" id="long" name="long"  autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="numero_act" class="control-label">Numero Actual:</label>
									<input type="number" class="form-control" id="numero_act" name="numero_act"  autocomplete="off" required>
								</div>
							</div>
						</div>


						<div class="row">
						<div class="col-md-6">
								<div class="form-group">
									<label for="fecha_venc" class="control-label">Fecha Vendimiento:</label>
									<input type="date" class="form-control" id="fecha_venc" name="fecha_venc"  autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="estado" class="control-label">Estado:</label>
									<select class="form-control" id="estado" name="estado" required>
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
						<button type="submit" class="btn btn-primary waves-effect waves-light" id="guardar_datos">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal -->
	<?php
}
?>