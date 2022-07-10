<?php
if (isset($conexion)) {
    ?>
	<div id="buscar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-search'></i> Buscar Productos</h4>
				</div>
				<div class="modal-body">

					<form class="form-horizontal">
						<div class="form-group row">

							<div class="col-md-5">
								<div class="input-group">
									<input type="text" autocomplete="off" class="form-control" id="q" placeholder="Buscar por Codigo/nombre" onkeyup="load(1)">
									<span class="input-group-btn">
										<button type="submit" class="btn btn-primary waves-effect waves-light" onclick="load(1)"><span class="fa fa-search"></span></button>
									</span>
								</div>
							</div>
							<div class="col-md-4">
								<div id="loader"></div><!-- Carga gif animado -->
							</div>
						</div>
					</form>
					<div class="outer_div" ></div><!-- Datos ajax Final -->

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div><!-- /.modal -->
	<?php
}
?>