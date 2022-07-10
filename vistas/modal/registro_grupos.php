<?php
if (isset($conexion)) {
    ?>
	<div id="nuevoGrupo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Nuevo Grupo de Usuarios</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="guardar_permisos" name="guardar_permisos">
						<div id="resultados_ajax"></div>

						<div class="form-group  ">
							<label for="nombres" class="col-sm-3 control-label">Nombre:</label>
							<div class="col-sm-12">
								<input type="text" class="form-control UpperCase" id="nombres" name="nombres" placeholder="Nombre del Grupo" required autocomplete="off">
							</div>
						</div>
						<div class="table-responsive">
						<table class="table table-sm table-hover">
							<thead>
								<tr>
									<th>Módulo</th>
									<th ><input name="Todos" type="checkbox" value="1" id="all_ver" class="check_ver" /> Visualizar</th>
									<th ><input name="Todos" type="checkbox" value="1" id="all_mod" class="check_mod"/> Editar</th>
									<th ><input name="Todos" type="checkbox" value="1" id="all_del" class="check_del"/> Eliminar</th>
								</tr>
							</thead>
							<tbody>
								<?php
$sql   = "select * from modulos";
    $query = mysqli_query($conexion, $sql);
    $num   = 1;
    while ($row = mysqli_fetch_array($query)) {
        $modulo = $row["nombre_modulo"];
        ?>
									<tr>
										<td>
											<?php echo $modulo; ?>
											<input type='hidden' name='permisos_<?php echo $num; ?>' value='<?php echo $modulo; ?>'>
										</td>
										<td><input  type ='checkbox' name='view_<?php echo $num; ?>' value='1' class='ck'></td>
										<td><input  type ='checkbox' name='edit_<?php echo $num; ?>'  value='1' class='ck1'></td>
										<td><input  type ='checkbox' name='del_<?php echo $num; ?>'  value='1'  class='ck2'></td>
									</tr>
									<?php
$num++;
    }
    ?>
							</tbody>
						</table>
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