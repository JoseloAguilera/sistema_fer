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
$modulo = "Clientes";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title          = "Clientes";
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
if (isset($_GET['numero_factura'])) {
    $numero_factura = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['numero_factura'], ENT_QUOTES)));
    $sql_abono      = mysqli_query($conexion, "select * from creditos_abonos, clientes where creditos_abonos.numero_factura='$numero_factura' and creditos_abonos.id_cliente=clientes.id_cliente");
    $count          = mysqli_num_rows($sql_abono);
    if ($count > 0) {
        $rw                         = mysqli_fetch_array($sql_abono);
        $_SESSION['numero_factura'] = $numero_factura;
    } else {
        header("location: ../html/cxc.php");
        exit;
    }
} else {
    header("location: ../html/cxc.php");
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
									Abonos de Clientes
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
											<?php
include "../modal/agregar_abono.php";
    ?>
											<div class="col-lg-12 col-md-6">
												<div class="widget-bg-color-icon card-box">
													<div class="bg-icon bg-icon-purple pull-left">
														<i class="ti-user text-purple"></i>
													</div>
													<div class="text-right">
													<h5 class="text-dark"><b class="counter"><?php echo $rw['nombre_cliente']; ?></b></h5>
														<a class='btn btn-primary waves-effect waves-light btn-sm m-b-5' href="cxc.php" title="Regresar a los Créditos"><i class="fa fa-reply"></i> Regresar
														</a>
													</div>
													<div class="clearfix"></div>
												</div>
											</div>
											<div id="widgets"></div>

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
																	<span class="input-group-btn">
														<button class="btn btn-info waves-effect waves-light" type="button" onclick='load(1);'><i class='fa fa-search'></i></button>
													</span>

																</div><!-- /input-group -->
															</div>
															<div class="col-xs-3">
																<div id="loader" class="text-left"></div>
															</div>
															<div class="col-xs-2">
																<div class="btn-group pull-center">
																	<?php if ($permisos_ver == 1) {?>
																	<button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#add-stock"><i class="fa fa-plus"></i> Abono</button>
																	<?php }?>
																</div>
															</div>
															<div class="col-xs-2">
																<div class="btn-group pull-center">
																	<?php if ($permisos_ver == 1) {?>
																	<button type="button"  onclick="reporte();" class="btn btn-default waves-effect waves-light" title="Imprimir"><i class='fa fa-print'></i></button>
																	<?php }?>
																</div>
															</div>
														</div>
													</form>
													<div class="col-md-12" align="center">
														<div id="resultados_ajax"></div>
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
<script type="text/javascript" src="../../js/ver_cxc.js"></script>
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
		VentanaCentrada('../pdf/documentos/rep_cxc.php?daterange=' + daterange, 'Reporte', '', '800', '600', 'true');
	}
</script>
<script>
	function imprimir_abono(id_abono) {
		VentanaCentrada('../pdf/documentos/rep_abono.php?id_abono=' + id_abono, 'Reporte', '', '800', '600', 'true');
	}
</script>
<?php require 'includes/footer_end.php'
?>

