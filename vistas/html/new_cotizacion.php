<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Ventas";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title          = "Ventas";
$nombre_usuario = get_row('users', 'usuario_users', 'id_users', $user_id);
?>

<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>

<!-- Begin page -->
<div id="wrapper" class="forced enlarged"> <!-- DESACTIVA EL MENU -->
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
									Nuevo Presupuesto
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
									<?php
	include "../modal/buscar_productos_ventas.php";
	include "../modal/buscar_clientes_ventas.php";
    include "../modal/registro_cliente.php";
    include "../modal/registro_producto.php";
    ?>
									<div class="row">
										<div class="col-lg-8">
											<div class="card-box">

												<div class="widget-chart">
													<div id="resultados_ajaxf" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
													<form class="form-horizontal" role="form" id="barcode_form">
														<div class="form-group row">
															<label for="barcode_qty" class="col-md-1 control-label">Cant:</label>
															<div class="col-md-2">
																<input type="text" class="form-control" id="barcode_qty" value="1" autocomplete="off">
															</div>

															<label for="condiciones" class="control-label">Codigo:</label>
															<div class="col-md-5" align="left">
																<div class="input-group">
																	<input type="text" class="form-control" id="barcode" autocomplete="off"  tabindex="1" autofocus="true" >
																	<span class="input-group-btn">
																		<button type="submit" class="btn btn-default"><span class="fa fa-barcode"></span></button>
																	</span>
																</div>
															</div>
															<div class="col-md-2">
																<button type="button" accesskey="a" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#buscar">
																	<span class="fa fa-search"></span> Buscar
																</button>
															</div>
														</div>
													</form>

													<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->

												</div>
											</div>

										</div>

										<div class="col-lg-4">
											<div class="card-box">
												<div class="widget-chart">
													<form role="form" id="datos_factura">
														<div class="form-group row">
															<label class="col-2 col-form-label"></label>
															<div class="col-md-12">
																	<div class="input-group">
																		<input type="text" id="nombre_cliente" class="form-control" placeholder="Buscar Cliente" required  tabindex="2">
																		<span class="input-group-btn">
																			<button type="button" class="btn waves-effect waves-light btn-success" data-toggle="modal" data-target="#nuevoCliente"><li class="fa fa-plus"></li></button>
																		</span>
																		<button type="button" accesskey="a" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#buscar_cliente">
																			<span class="fa fa-search"></span>
																		</button>
																		<input id="id_cliente" name="id_cliente" type='hidden'>
																	</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<label for="email">Email</label>
																	<input type="text" class="form-control" autocomplete="off" id="em" disabled="true">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="fiscal">RUC | Cedula</label>
																	<input type="text" class="form-control" autocomplete="off" id="tel1" disabled="true">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="fiscal">No. Presupuesto</label>
																	<div id="f_resultado"></div><!-- Carga los datos ajax del incremento de la fatura -->
																</div>
															</div>
														</div>

														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="condiciones">Pago</label>
																	<select class="form-control input-sm condiciones" id="condiciones" name="condiciones" onchange="showDiv(this)">
																		<option value="1">Contado</option>
																		<option value="4">Crédito</option>
																	</select>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="validez">Validez</label>
																	<select class="form-control" id="validez" name="validez">
																		<option value="1">5 días</option>
																		<option value="2">10 días</option>
																		<option value="3">15 días</option>
																		<option value="4">30 días</option>
																		<option value="5">60 días</option>

																	</select>
																</div>
															</div>
														</div>

														<div class="col-md-12" align="center">
															<button type="submit" id="guardar_factura" class="btn btn-danger btn-block btn-lg waves-effect waves-light" aria-haspopup="true" aria-expanded="false"><span class="fa fa-save"></span> Guardar</button>
														</div>
													</form>

												</div>
											</div>

										</div>

									</div>
									<!-- end row -->


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
<!-- Todo el codigo js aqui-->
<!-- ============================================================== -->
<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
<script type="text/javascript" src="../../js/cotizacion.js"></script>
<!-- ============================================================== -->
<!-- Codigos Para el Auto complete de Clientes -->
<script>
	$(function() {
		$("#nombre_cliente").autocomplete({
			source: "../ajax/autocomplete/clientes.php",
			minLength: 2,
			select: function(event, ui) {
				event.preventDefault();
				$('#id_cliente').val(ui.item.id_cliente);
				$('#nombre_cliente').val(ui.item.nombre_cliente);
				$('#tel1').val(ui.item.fiscal_cliente);
				$('#em').val(ui.item.email_cliente);
				$.Notification.notify('success','bottom right','EXITO!', 'CLIENTE AGREGADO CORRECTAMENTE')
			}
		});
	});

	$("#nombre_cliente" ).on( "keydown", function( event ) {
		if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
		{
			$("#id_cliente" ).val("");
			$("#tel1" ).val("");
			$("#em" ).val("");
		}
		if (event.keyCode==$.ui.keyCode.DELETE){
			$("#nombre_cliente" ).val("");
			$("#id_cliente" ).val("");
			$("#tel1" ).val("");
			$("#em" ).val("");
		}
	});
</script>
<!-- FIN -->
<script>
// print order function
function printFactura(id_factura) {
	$('#modal_vuelto').modal('hide');
	if (id_factura) {
		$.ajax({
			url: '../pdf/documentos/imprimir_cotizacion.php',
			type: 'post',
			data: {
				id_factura: id_factura
			},
			dataType: 'text',
			success: function(response) {
				var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
				mywindow.document.write('<html><head><title>Facturación</title>');
				mywindow.document.write('</head><body>');
				mywindow.document.write(response);
				mywindow.document.write('</body></html>');
                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10
                mywindow.print();
                mywindow.close();
            } // /success function

        }); // /ajax function to fetch the printable order
    } // /if orderId
} // /print order function
</script>
<script>
	function obtener_caja(user_id) {
		$(".outer_div3").load("../modal/carga_caja.php?user_id=" + user_id);//carga desde el ajax
	}
</script>
<script>
	function showDiv(select){
		if(select.value==4){
			$("#resultados3").load("../ajax/carga_prima.php");
		} else{
			$("#resultados3").load("../ajax/carga_resibido.php");
		}
	}
</script>

<?php require 'includes/footer_end.php'
?>

