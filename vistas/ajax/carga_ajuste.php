<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/

/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
//Archivo de funciones PHP
require_once "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Productos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$id_producto    = intval($_REQUEST['id_producto']);
$_SESSION['id'] = $id_producto;
$sql            = mysqli_query($conexion, "select * from productos where id_producto='$id_producto'");
$rw             = mysqli_fetch_array($sql);
$nombre         = $rw['nombre_producto'];
$stock          = $rw['stock_producto'];
$image_path     = $rw['image_path'];
?>

<div class="row">
	<div class="col-lg-3">
		<div class="col-lg-12 col-md-6">
			<div class="widget-bg-color-icon card-box">
				<!--<img class="card-img-top img-fluid" src="../../assets/images/small/img2.jpg" alt="Card image cap">-->
				<?php
if ($image_path == null) {
    echo '<img class="card-img-top img-fluid" src="../../img/productos/default.jpg">';
} else {
    echo '<img src="' . $image_path . '" class="card-img-top img-fluid">';
}

?>
				<div class="text-center">
			
				<!--div style="margin-top: 10%;  margin-bottom: 10%;" align="center">
						<strong  style="color: #52bb56; font-size: 150%; ">Existencia: <?php //echo $stock; ?></strong>
					</div-->
					<button type="button" class="btn btn-success btn-block btn-lg waves-effect waves-light" data-toggle="modal" data-target="#add-stock"><i class="fa fa-edit"></i> Agregar Stock</button>
					<button type="button" class="btn btn-danger btn-block btn-lg waves-effect waves-light" data-toggle="modal" data-target="#remove-stock"><i class="fa fa-trash"></i> Eliminar Stock</button>
				</div>
				
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-9">
		<div class="panel panel-color panel-info">
			<div class="panel-body">
				<form class="form-horizontal" role="form" id="datos_cotizacion">
					<div class="form-group row">
						<div class="col-xs-4">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" class="form-control daterange pull-right" value="<?php echo "01" . date('/m/Y') . ' - ' . date('d/m/Y'); ?>" id="range" readonly>

							</div><!-- /input-group -->
						</div>
						<div class="col-xs-4">
							<div class="input-group">
								<select class='form-control' id="tipo" name="tipo" onchange="load(1);">
									<option value="">Selecciona Tipo</option>
									<option value="">Todos</option>
									<option value="1">Entradas</option>
									<option value="2">Salidas</option>
								</select>
								<span class="input-group-btn">
									<button class="btn btn-outline-info btn-rounded waves-effect waves-light" type="button" onclick='load(1);'><i class='fa fa-search'></i></button>
								</span>
							</div>
						</div>

						<div class="col-xs-3">
							<div id="loader" class="text-left"></div>
						</div>

						<div class="col-xs-1 ">
							<div class="btn-group pull-center">
								<?php if ($permisos_ver == 1) {?>
								<button type="button"  onclick="reporte();" class="btn btn-default btn-rounded waves-effect waves-light" title="Imprimir"><i class='fa fa-print'></i> Imprimir</button>
								<?php }?>
							</div>
						</div>

					</div>
				</form>
				<div class="col-md-12" align="center">
					<div id="resultados_ajax"></div>
					<div class="clearfix"></div>
					<table>
						<tr>
							<th style="font-size: 135%;">Nombre de Producto: <b><?php echo $nombre; ?></b></th>
						</tr>
					</table>
					<div class='outer_div'></div><!-- Carga los datos ajax -->
				</div>
			</div>
		</div>
	</div>
</div>

</div>
<script>
	$(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
    });
	$(function() {
		load(1);

//Date range picker
$('.daterange').daterangepicker({
	buttonClasses: ['btn', 'btn-sm'],
	applyClass: 'btn-success',
	cancelClass: 'btn-default',
	locale: {
		format: "DD/MM/YYYY",
		separator: " - ",
		applyLabel: "Aplicar",
		cancelLabel: "Cancelar",
		fromLabel: "Desde",
		toLabel: "Hasta",
		customRangeLabel: "Custom",
		daysOfWeek: [
		"Do",
		"Lu",
		"Ma",
		"Mi",
		"Ju",
		"Vi",
		"Sa"
		],
		monthNames: [
		"Enero",
		"Febrero",
		"Marzo",
		"Abril",
		"Mayo",
		"Junio",
		"Julio",
		"Agosto",
		"Septiembre",
		"Octubre",
		"Noviembre",
		"Diciembre"
		],
		firstDay: 1
	},
	opens: "right"

});
});

</script>
