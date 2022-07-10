<?php
/*-------------------------
Autor: Delmar Lopez
Web: softwys.com
Mail: softwysop@gmail.com
---------------------------*/
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
$modulo = "Configuracion";
permisos($modulo, $cadena_permisos);
$query_empresa = mysqli_query($conexion, "select * from perfil where id_perfil=1");
$row           = mysqli_fetch_array($query_empresa);
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
								Datos de Empresa
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

							<form class="form-horizontal" role="form" id="perfil">
								<div class="row">
									<div class="col-md-3">
										<div align="center">
											<img src="<?php echo $row['logo_url']; ?>" class="img-responsive" alt="profile-image" width="200px" height="200px">
										</div>
										<div class="form-group">
											<input class="form-control" data-buttonText="Logo" type="file" name="imagefile" id="imagefile" onchange="upload_image();">
										</div>

									</div>
									<!-- end col -->

									<div class="col-md-9">
										<div class="card-box">
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3  col-form-label">Razón Social:</label>
													<div class="col-sm-9">
														<input type="text" class="form-control UpperCase" name="nombre_empresa" value="<?php echo $row['nombre_empresa'] ?>" required autocomplete="off">
													</div>
												</div>
												<div class="form-group row">
													<label for="giro" class="col-sm-3  col-form-label">Desc.:</label>
													<div class="col-sm-9">
														<input type="text" class="form-control UpperCase" name="giro" value="<?php echo $row['giro_empresa'] ?>" required autocomplete="off">
													</div>
												</div>
												<div class="form-group row">
													<label for="fiscal" class="col-sm-3 col-form-label">RUC/Cedula:</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" required name="fiscal" value="<?php echo $row['fiscal_empresa'] ?>" autocomplete="off" >
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Teléfono:</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" name="telefono" value="<?php echo $row['telefono'] ?>" required autocomplete="off">
													</div>
												</div>
												<div class="form-group row">
													<label for="inputEmail3" class="col-sm-3 col-form-label">Email:</label>
													<div class="col-sm-9">
														<input type="email" class="form-control" name="email" value="<?php echo $row['email'] ?>" autocomplete="off" >
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Impuesto %:</label>
													<div class="col-sm-4">
														<input type="text" class="form-control" required name="impuesto" value="<?php echo $row['impuesto'] ?>" autocomplete="off" >
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Nombre Impuesto:</label>
													<div class="col-sm-4">
														<input type="text" class="form-control UpperCase" required name="nom_impuesto" value="<?php echo $row['nom_impuesto'] ?>" autocomplete="off" >
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Moneda:</label>
													<div class="col-sm-4">
														<select class='form-control input-sm' name="moneda" required>
															<?php
$sql   = "select symbol, name from  currencies group by symbol order by name ";
    $query = mysqli_query($conexion, $sql);
    while ($rw = mysqli_fetch_array($query)) {
        $simbolo = $rw['symbol'];
        $moneda  = $rw['name'];
        if ($row['moneda'] == $simbolo) {
            $selected = "selected";
        } else {
            $selected = "";
        }
        ?>
																<option value="<?php echo $simbolo; ?>" <?php echo $selected; ?>><?php echo ($simbolo)  ; ?></option>
																<?php
}
    ?>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Dirección:</label>
													<div class="col-sm-9">
														<input type="text" class="form-control UpperCase" name="direccion" value="<?php echo $row["direccion"]; ?>" required autocomplete="off" >
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Ciudad:</label>
													<div class="col-sm-9">
														<input type="text" class="form-control UpperCase" name="ciudad" value="<?php echo $row["ciudad"]; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Región/Provincia:</label>
													<div class="col-sm-9">
														<input type="text" class="form-control UpperCase" name="estado" value="<?php echo $row["estado"]; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Código postal:</label>
													<div class="col-sm-4">
														<input type="text" class="form-control UpperCase" name="codigo_postal" value="<?php echo $row["codigo_postal"]; ?>" autocomplete="off">
													</div>
												</div>

												<div class='col-md-12' id="resultados_ajax"></div><!-- Carga los datos ajax -->


												<div class="form-group m-b-0 row">
													<div class="offset-3 col-sm-9">
														<button type="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-refresh"></i> Actualizar Datos</button>
													</div>
												</div>
											</form>

									</div>

								</div>
								<!-- end row -->


							</div>
							<!-- /.box -->


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
				</div>
			</div>
		</div>


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
<script>
  $( "#perfil" ).submit(function( event ) {
    $('.guardar_datos').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "../ajax/editar_perfil.php",
      data: parametros,
      beforeSend: function(objeto){
        $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
      },
      success: function(datos){
        $("#resultados_ajax").html(datos);
        $('.guardar_datos').attr("disabled", false);
        //desaparecer la alerta
        $(".alert-success").delay(400).show(10, function() {
                $(this).delay(2000).hide(10, function() {
                  $(this).remove();
                });
              }); // /.alert

      }
    });
    event.preventDefault();
  })



</script>

<script>
  function upload_image(){

    var inputFileImage = document.getElementById("imagefile");
    var file = inputFileImage.files[0];
    if( (typeof file === "object") && (file !== null) )
    {
      $("#load_img").html('<img src="../../img/ajax-loader.gif"> Cargando...');
      var data = new FormData();
      data.append('imagefile',file);


      $.ajax({
            url: "../ajax/imagen_ajax.php",        // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: data,         // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,        // To send DOMDocument or non processed data file it is set to false
            success: function(data)   // A function to be called if request succeeds
            {
              $("#load_img").html(data);

            }
          });
    }


  }
</script>
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

	<?php require 'includes/footer_end.php'
?>

