<?php
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
//Archivo de funciones PHP
require_once "../funciones.php";
$moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
if (isset($_REQUEST['id_factura'])) {
    $id_factura = intval($_REQUEST['id_factura']);
    $sql        = mysqli_query($conexion, "select monto_factura from facturaS_ventas where id_factura='" . $id_factura . "'");
    $rww        = mysqli_fetch_array($sql);
    $monto      = $rww['monto_factura'];
    ?>
	<strong><h3><div align="center">TOTAL A PAGAR</div></h3></strong>
	<div class="alert alert-danger" align="center">
		<strong><h1><?php echo $moneda . ' ' . $monto; ?></h1></strong>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="condiciones">Pago</label>
				<select class="form-control input-sm condiciones" id="condiciones" name="condiciones" onchange="showDiv(this)">
					<option value="1">Efectivo</option>
					<option value="2">Cheque</option>
					<option value="3">Transferencia bancaria</option>
					<option value="4">Crédito</option>
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="monto" class="control-label">Dinero Recibido:</label>
				<input type="text" class="form-control txt_monto" id="<?php echo $id_factura; ?>" name="monto" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" required autocomplete="off">
				<input value="<?php echo $id_factura; ?>" type="hidden" name="id_factura" id="id_factura">
				<input value="<?php echo $monto; ?>" type="hidden" name="monto" id="monto">
			</div>
		</div>
	</div>
	<?php }?>
	<script>
		$(document).ready(function () {
			$('#guardar_datosc').attr("disabled", true);
			$('.txt_monto').off('blur');
			$('.txt_monto').on('blur',function(event){
				var keycode = (event.keyCode ? event.keyCode : event.which);
				var monto = $("#monto").val();
        // if(keycode == '13'){
        	id_factura = $(this).attr("id");
        	resibido = $(this).val();
             //Inicia validacion
             if (isNaN(resibido)) {
             	$.Notification.notify('error','bottom center','ERROR', 'DIGITAR UN VALOR VALIDO')
             	$('#guardar_datosc').attr("disabled", true);
             	$(this).focus();
             	return false;
             }else{
             	$('#guardar_datosc').attr("disabled", false);
             }
             if (resibido < monto) {
             	$.Notification.notify('error','bottom center','ERROR', 'EL DINERO RESIBIDO DEBE SER IGUAL O MAYOR QUE EL TOTAL')
             	$('#guardar_datosc').attr("disabled", true);
             	$(this).focus();
             	return false;
             }else{
             	$('#guardar_datosc').attr("disabled", false);
             }
    //Fin validacion
    $.ajax({
    	type: "POST",
    	url: "../ajax/editar_desc_ventax.php",
    	data: "id_factura=" + id_factura + "&resibido=" + resibido,
    	success: function(datos) {
           //$("#resultados").load("../ajax/agregar_tmp.php");
           $.Notification.notify('success','bottom center','EXITO!', 'DESCUENTO ACTUALIZADO CORRECTAMENTE')
       }
   });
        // }
    });

		});
	</script>