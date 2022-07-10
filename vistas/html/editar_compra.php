<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Compras";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title   = "Compras";
$compras = 1;
if (isset($_GET['id_factura'])) {
    $id_factura = intval($_GET['id_factura']);
    $campos     = "proveedores.id_proveedor, proveedores.nombre_proveedor, proveedores.fiscal_proveedor, proveedores.email_proveedor, facturas_compras.id_vendedor, facturas_compras.fecha_factura, facturas_compras.condiciones, facturas_compras.estado_factura, facturas_compras.numero_factura";

    $sql_factura = mysqli_query($conexion, "select $campos from facturas_compras, proveedores where facturas_compras.id_proveedor=proveedores.id_proveedor and facturas_compras.id_factura='" . $id_factura . "'");
    $count       = mysqli_num_rows($sql_factura);
    if ($count == 1) {
        $rw_factura                 = mysqli_fetch_array($sql_factura);
        $id_proveedor               = $rw_factura['id_proveedor'];
        $nombre_proveedor           = $rw_factura['nombre_proveedor'];
        $fiscal_proveedor           = $rw_factura['fiscal_proveedor'];
        $email_proveedor            = $rw_factura['email_proveedor'];
        $id_vendedor_db             = $rw_factura['id_vendedor'];
        $fecha_factura              = date("d/m/Y", strtotime($rw_factura['fecha_factura']));
        $condiciones                = $rw_factura['condiciones'];
        $estado_factura             = $rw_factura['estado_factura'];
        $numero_factura             = $rw_factura['numero_factura'];
        $_SESSION['id_factura']     = $id_factura;
        $_SESSION['numero_factura'] = $numero_factura;
    } else {
        header("location: bitacoras_compras.php");
        exit;
    }
} else {
    header("location: bitacoras_compras.php");
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
									Editar Compra
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
include "../modal/buscar_productos_compras.php";
    include "../modal/registro_proveedor.php";
    include "../modal/registro_producto.php";
    //include "../modal/caja.php";
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
															<div class="col-md-1">
																<button type="button" accesskey="a" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#buscar" title="Buscar Producto">
																	<span class="fa fa-search"></span>
																</button>
															</div>
															<!--div class="col-md-1">
																<button type="button" accesskey="a" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#nuevoProducto" title="Agregar Nuevo Producto">
																	<span class="fa fa-plus"></span>
																</button>
															</div-->
														</div>
													</form>

													<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->

												</div>
											</div>

										</div>

										<div class="col-lg-4">
											<div class="card-box">

												<div class="widget-chart">
													<div class="editar_factura" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
													<form role="form" id="datos_factura">
														<div class="form-group row">
															<label class="col-2 col-form-label"></label>
															<div class="col-12">
																<div class="input-group">
																	<input type="text" id="nombre_proveedor" class="form-control" placeholder="Buscar Proveedor" required value="<?php echo $nombre_proveedor; ?>" tabindex="2">
																	<span class="input-group-btn">
																		<button type="button" class="btn waves-effect waves-light btn-success" data-toggle="modal" data-target="#nuevoProveedor" title="Agregar Proveedor"><li class="fa fa-plus"></li></button>
																	</span>
																	<input id="id_proveedor" name="id_proveedor" type='hidden' value="<?php echo $id_proveedor; ?>">

																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="fiscal">#Fiscal</label>
																	<input type="text" class="form-control" autocomplete="off" id="tel1" disabled="true" value="<?php echo $fiscal_proveedor; ?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="fiscal">No. Factura</label>
																	<input type="text" class="form-control" autocomplete="off" id="factura" name="factura" value="<?php echo $numero_factura; ?>" tabindex="3">
																</div>
															</div>
														</div>

														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="fiscal">Pago</label>
																	<select class='form-control input-sm' id="condiciones" name="condiciones">
																		<option value="1" <?php if ($condiciones == 1) {echo "selected";}?>>Efectivo</option>
																		<option value="2" <?php if ($condiciones == 2) {echo "selected";}?>>Cheque</option>
																		<option value="3" <?php if ($condiciones == 3) {echo "selected";}?>>Transferencia bancaria</option>
																		<option value="4" <?php if ($condiciones == 4) {echo "selected";}?>>Crédito</option>
																	</select>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="fecha">Estado Fact.</label>
																	<select class='form-control' id="estado_factura" name="estado_factura">
																		<option value="1" <?php if ($estado_factura == 1) {echo "selected";}?>>Pagado</option>
																		<option value="2" <?php if ($estado_factura == 2) {echo "selected";}?>>Pendiente</option>
																	</select>
																</div>
															</div>
														</div>
														<?php if ($permisos_editar == 1) {?>
														<div class="col-md-12" align="center">
															<button type="submit" id="guardar_factura" class="btn btn-danger btn-block btn-lg waves-effect waves-light"><span class="fa fa-refresh"></span> Actualizar</button>
															<!--<a href="#" onclick="imprimir_factura('1');"><i class="glyphicon glyphicon-download"></i> PDF</a>-->
														</div>
														<?php }?>
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
<!-- Todo el codigo js aqui -->
<!-- ============================================================== -->
<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
<script type="text/javascript" src="../../js/editar_compra.js"></script>
<!-- ============================================================== -->
<!-- Codigos Para el Auto complete de proveedores -->
<script>
	$(function() {
		$("#nombre_proveedor").autocomplete({
			source: "../ajax/autocomplete/proveedor.php",
			minLength: 2,
			select: function(event, ui) {
				event.preventDefault();
				$('#id_proveedor').val(ui.item.id_proveedor);
				$('#nombre_proveedor').val(ui.item.nombre_proveedor);
				$('#tel1').val(ui.item.fiscal_proveedor);



			}
		});


	});

	$("#nombre_proveedor" ).on( "keydown", function( event ) {
		if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
		{
			$("#id_proveedor" ).val("");
			$("#tel1" ).val("");

		}
		if (event.keyCode==$.ui.keyCode.DELETE){
			$("#nombre_proveedor" ).val("");
			$("#id_proveedor" ).val("");
			$("#tel1" ).val("");
		}
	});
</script>
<!-- FIN -->
<!--<script>
	$(document).ready(function () {
		$("#texto1").off('blur');
		$("#texto1").on('blur',function(){
			//$("#texto1").keyup(function () {
				var value = $(this).val();
				id_tmp = $(this).attr("id");
				$.ajax({
					type: "POST",
					url: "../ajax/editar_costo_compra.php",
					data: "id_tmp=" + id_tmp + "&value=" + value,
					beforeSend: function(objeto) {
						$("#resultadosx").html('<img src="../../img/ajax-loader.gif"> Cargando...');
					},
					success: function(datos) {
						$("#resultadosx").html(datos);
						$.Notification.notify('success','bottom center','Notificación', 'Producto agregado a la Factura correctamente')
					}
				});
			});
		});
	</script>-->

	<?php require 'includes/footer_end.php'
?>

