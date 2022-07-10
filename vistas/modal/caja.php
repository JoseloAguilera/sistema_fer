<?php
if (isset($conexion)) {
    ?>
	<!-- Modal -->
	<div class="modal fade" id="caja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i> Efectivo de Caja</h4>
				</div>
				<div class="modal-body" align="center">
					<strong><h3>Cajero: <?php echo $nombre_usuario; ?></h3></strong>
					<div class="alert alert-info" align="center">
						<strong><h1>
						<div id="resultados2"></div><!-- Carga los datos ajax del incremento de la fatura -->

						</h1></strong>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect waves-light" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>