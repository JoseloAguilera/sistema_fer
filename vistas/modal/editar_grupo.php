<?php
if (isset($conexion)) {
    ?>
	<div id="editarGrupo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Editar Grupo de Usuario</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_permisos" name="editar_permisos">
						<div id="loader2" class="text-center"></div>
						<div id="resultados_ajax2"></div>
						<div class="outer_div2"></div>



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