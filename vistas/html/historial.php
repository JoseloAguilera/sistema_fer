<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
require_once "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Productos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title     = "Productos";
$Productos = 1;
if (isset($_GET['id'])) {
    $id_producto  = intval($_GET['id']);
    $sql_producto = mysqli_query($conexion, "select * from productos where id_producto='$id_producto'");
    $count        = mysqli_num_rows($sql_producto);
    if ($count == 1) {
        $rw_factura     = mysqli_fetch_array($sql_producto);
        $_SESSION['id'] = $id_producto;
    } else {
        header("location: ../html/productos.php");
        exit;
    }
} else {
    header("location: ../html/productos.php");
    exit;
}
?>

<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>

<!-- Begin page -->
<div id="wrapper">

	<?php require 'includes/menu.php';?>

	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->
	<div class="content-page">
		<!-- Start content -->
		<div class="content">
			<div class="container">
				<?php if ($permisos_ver == 1) {
    ?>
					<div class="col-lg-12">
						<div class="portlet">
							<div class="portlet-heading bg-primary">
								<h3 class="portlet-title">
									Movimiento de Inventario
								</h3>
								<div class="portlet-widgets">
									<a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
									<span class="divider"></span>
									<a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary"><i class="ion-minus-round"></i></a>
									<span class="divider"></span>
									<a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div id="bg-primary" class="panel-collapse collapse show">
								<div class="portlet-body">
									<div class="row">
										<div class="col-lg-4">
										<!--<div class="card-box widget-user">
											<div>
												<img src="../../img/stock.png" class="img-responsive img-circle" alt="user">
												<div class="wid-u-info">
													<h5 class="m-t-0 m-b-3">Producto:<?php echo $rw_factura['nombre_producto']; ?></h5>
													<h5 class="m-t-0 m-b-3">Codigo: <?php echo $rw_factura['codigo_producto']; ?></h5>
													<h5 class="m-t-0 m-b-3">Stock: <?php echo stock($rw_factura['stock_producto']); ?></h5>
												</div>
											</div>
										</div>-->

										<div class="col-lg-12 col-md-6">
											<div class="widget-bg-color-icon card-box">
												<div class="bg-icon bg-icon-purple pull-left">
													<i class="ti-home text-purple"></i>
												</div>
												<div class="text-center">
													<p class="text-muted m-b-5 font-16 font-bold text-uppercase"><?php echo $rw_factura['nombre_producto']; ?></p>
													<p class="text-muted m-b-5 font-14 font-bold text-uppercase"><b class="counter">CODIGO: <?php echo $rw_factura['codigo_producto']; ?></b></p>
													<a class='btn btn-primary waves-effect waves-light btn-sm m-b-5' href="productos.php" title="Regresar al listado de Productos"><i class="fa fa-reply"></i> Regresar
													</a>
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
										<div class="col-lg-12 col-md-6">
											<div class="card-box widget-icon">
												<div>
													<i class="mdi mdi-briefcase-check text-info"></i>
													<div class="wid-icon-info text-center">
														<p class="text-muted m-b-5 font-14 font-bold text-uppercase">EXISTENCIA</p>
														<p class="m-t-0 m-b-5 counter font-18 font-bold text-primary"><?php echo stock($rw_factura['stock_producto']); ?></p>
													</div>
												</div>
											</div>
										</div>

										<div class="card-box">
											<div class="widget-chart text-center">
												<div class='row'>
													<?php
include "../modal/agregar_stock.php";
    include "../modal/eliminar_stock.php";
    ?>
													<div class="col-md-12" align="center">
														<button type="button" class="btn btn-success btn-block btn-lg waves-effect waves-light" data-toggle="modal" data-target="#add-stock"><i class="fa fa-edit"></i> Agregar Stock</button>
														<button type="button" class="btn btn-danger btn-block btn-lg waves-effect waves-light" data-toggle="modal" data-target="#remove-stock"><i class="fa fa-trash"></i> Eliminar Stock</button>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-lg-8">
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
																	<button class="btn btn-primary" type="button" onclick='load(1);'><i class='fa fa-search'></i></button>
																</span>
															</div>
														</div>

														<div class="col-xs-3">
															<div id="loader" class="text-left"></div>
														</div>

														<div class="col-xs-1 ">
															<div class="btn-group pull-center">
																<?php if ($permisos_ver == 1) {?>
																<button type="button"  onclick="reporte();" class="btn btn-default waves-effect waves-light" title="Imprimir"><i class='fa fa-print'></i></button>
																<?php }?>
															</div>
														</div>

													</div>
												</form>
												<div class="col-md-12" align="center">
													<div class="clearfix"></div>
													<div class='outer_div'></div><!-- Carga los datos ajax -->
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
				<?php
} else {
    ?>
				<section class="content">
					<div class="alert alert-danger" align="center">
						<h3>Acceso denegado! </h3>
						<p>No cuentas con los permisos necesario para acceder a este módulo.</p>
					</div>
				</section>
				<?php
}
?>

		</div>
		<!-- end container -->
	</div>
	<!-- end content -->

	<?php require 'includes/pie.php';?>

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->


</div>
<!-- END wrapper -->

<?php require 'includes/footer_start.php'
?>
<!-- ============================================================== -->
<!-- Todo el codigo js aqui -->
<!-- ============================================================== -->
<script type="text/javascript" src="../../js/ver_historial.js"></script>
<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
<script>
	$(document).ready( function () {
		$(".UpperCase").on("keypress", function () {
			$input=$(this);
			setTimeout(function () {
				$input.val($input.val().toUpperCase());
			},50);
		})
	})
</script>
<script>
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
<script>
	function reporte() {
		var daterange = $("#range").val();
		var tipo = $("#tipo").val();
		VentanaCentrada('../pdf/documentos/rep_historial.php?daterange=' + daterange + "&tipo=" + tipo, 'Reporte', '', '800', '600', 'true');
	}
</script>
<?php require 'includes/footer_end.php'
?>

