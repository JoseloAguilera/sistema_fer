<?php 
	session_start();
	include_once "../php_conexion.php";
	include_once "class/class.php";
	include_once "class/class_pediatria.php";
	include_once "../funciones.php";
	include_once "../class_buscar.php";
	include_once "../../modulos/citas_medicas/class/class.php";
	if($_SESSION['cod_user']){
	}else{
		header('Location: ../../php_cerrar.php');
	}
	$id_medico=$_SESSION['cod_user'];
	$usu=$_SESSION['cod_user'];
	$pa=mysqli_query($conexion,"SELECT * FROM cajero WHERE usu='$usu'");				
	while($row=mysqli_fetch_array($pa)){
		$id_consultorio=$row['consultorio'];
	}
	
	$oPersona=new Consultar_Cajero($usu);
	$cajero_nombre=$oPersona->consultar('nom');
	$fecha=date('Y-m-d');
	$hora=date('H:i:s');
	
	######### TRAEMOS LOS DATOS DE LA EMPRESA #############
		$pa=mysqli_query($conexion,"SELECT * FROM empresa WHERE id=1");				
        if($row=mysqli_fetch_array($pa)){
			$nombre_empresa=$row['empresa'];
		}
	
	if(!empty($_GET['del'])){
		$id=$_GET['del'];
		mysqli_query($conexion,"DELETE FROM pacientes WHERE id='$id'");
		header('index.php');
	}
	 #paginar
        $maximo=15;
        if(!empty($_GET['pag'])){
            $pag=limpiar($_GET['pag']);
        }else{
            $pag=1;
        }
        $inicio=($pag-1)*$maximo;
        
        $cans=mysqli_query($conexion,"SELECT COUNT(nombre)as total FROM pacientes");
        if($dat=mysqli_fetch_array($cans)){
            $total=$dat['total']; #inicializo la variable en 0
        }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $nombre_empresa; ?></title>
	<!-- BOOTSTRAP STYLES-->
    <link href="../../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="../../assets/css/font-awesome.css" rel="stylesheet" />
     <!-- CALENDARIO STYLES-->
	<link href="../../assets/todo/bootstrap-datetimepicker.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="../../assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="../../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

</head>
<body>
    <div id="wrapper">
        <?php include_once "../../menu/navar.php"; ?>
           <?php include_once "../../menu/m_pacientes.php"; ?>
        <div id="page-wrapper" >
            <div id="page-inner">
				<div class="panel-body">                                              
<?php if(permiso($_SESSION['cod_user'],'1')==TRUE){ ?>
				  <!--  Modals-->
								 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<form name="form1" method="post" action="">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													
														<h3 align="center" class="modal-title" id="myModalLabel">Nuevo Paciente</h3>
													</div>
										<div class="panel-body">
										<div class="row">											
											<div class="col-md-12">
											<br>
											<input class="form-control" title="Se necesita un nombre"  name="nombre" placeholder="Nombre Completo" autocomplete="off" required><br>
											<input class="form-control" title="Se necesita una Direccion" name="direccion" placeholder="Dirección"  autocomplete="off" required><br>	
											</div>
											<div class="col-md-6">	
												<input class="form-control" title="Se necesita un nombre"  name="nomp" placeholder="Nombre Del Padre" autocomplete="off" required><br>											
												<input class="form-control" name="telefono" title="Se necesita un Telefono" placeholder="Telefono" autocomplete="off" required><br>
												
												<div class='input-group date form_date' id='form_date' data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
													<input type='text' name="edad" id="form_date" class="form-control" placeholder="Fecha de Nacimiento" onfocus="(this.type='')" required autocomplete="off" />
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
												</div><br>
												<input type="hidden" id="dtp_input2" name="edad" />
												<select class="form-control" name="sexo" autocomplete="off" required>
													<option value="" selected disabled>--SEXO--</option>
													<option value="m">Masculino</option>
													<option value="f">Femenino</option>													
												</select><br>
												<select class="form-control" name="estado" placeholder="Estado" autocomplete="off" required>						
													<option value="s">Activo</option>
													<option value="n">No Activo</option>													
												</select><br>
												
												
											</div>
											<div class="col-md-6">																						
												<input class="form-control" title="Se necesita un nombre"  name="nomm" placeholder="Nombre De La Madre" autocomplete="off" required><br>
												<input class="form-control" name="refpor" placeholder="Referido por" autocomplete="off"><br>																							 
												
												<div class='input-group date form_date2' id='form_date2' data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input3" data-link-format="yyyy-mm-dd">
													<input type='text' name="feccita" id="form_date2" class="form-control" placeholder="Fecha de Primera Cita" onfocus="(this.type='')" required autocomplete="off" />
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
												</div><br>
												<input type="hidden" id="dtp_input3" name="feccita" />
												<select class="form-control" name="seguro" autocomplete="off" required>
													<option value="" selected disabled>--SEGURO--</option>
													<option value="ninguno">NINGUNO</option>
													<option value="rpn">RPN</option>
													<option value="vivir">VIVIR</option>
													<option value="sg">SALUD GLOBAL</option>
													<option value="acsa">ACSA</option>
													<option value="sp">SEGURO DEL PACIFICO</option>
													<option value="paligmed">PALIGMED</option>													
													<option value="red">MI RED</option>													
													<option value="sisa">SISA</option>													
													<option value="otros">OTROS</option>	
												</select><br>
											</div> 																																												                                                            
										</div> 
										</div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>										 
                                    </div>
                                </div>
								</form>
                            </div>
                     <!-- End Modals-->
					
            <div class="row">
				<div align="center">
                    <div class="btn-group">
                      <a href="../imprimir/rep_pacientes.php" class="btn btn-success" title="Regresar"><i class="fa fa-print" ></i><strong> Reporte</strong></a> 
                    </div>
                </div><br>
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
							PACIENTES
							<ul class="nav pull-right">
								<a href="" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal" title="Agregar Paciente" title="Agregar"><i class="fa fa-plus"> </i> <strong>Nuevo</strong></a>								                            																										                            
							</ul>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
								<?php 
									if(!empty($_POST['nombre'])){ 
										#$documento=limpiar($_POST['documento']);		
										$nombre=limpiar($_POST['nombre']);		
										$direccion=limpiar($_POST['direccion']);
										$nomp=limpiar($_POST['nomp']);
										$nomm=limpiar($_POST['nomm']);
										$telefono=limpiar($_POST['telefono']);
										$edad=limpiar($_POST['edad']);			
										$sexo=limpiar($_POST['sexo']);
                                        $feccita=limpiar($_POST['feccita']);										
										$refpor=limpiar($_POST['refpor']);															
										$estado=limpiar($_POST['estado']);										
										$seguro=limpiar($_POST['seguro']);										
																	
										if(empty($_POST['id'])){
											$oPaciente=new Proceso_Paciente('',$nombre,$direccion,$nomp,$nomm,$telefono,$edad,$sexo,$feccita,$refpor,$estado,$id_consultorio,$seguro);
											$oPaciente->crear();
											echo mensajes('Paciente "'.$nombre.'" Creado con Exito','verde');
										}else{
											$id=limpiar($_POST['id']);
											$oPaciente=new Proceso_Paciente($id,$nombre,$direccion,$nomp,$nomm,$telefono,$edad,$sexo,$feccita,$refpor,$estado,$id_consultorio,$seguro);
											$oPaciente->actualizar();
											echo mensajes('Paciente "'.$nombre.'" Actualizado con Exito','verde');
										}
									}
									if(!empty($_POST['alergia']) and !empty($_POST['enf_cro']) and !empty($_POST['id'])){
											$id=limpiar($_POST['id']);
											$alergia=limpiar($_POST['alergia']);						
											$enf_cro=limpiar($_POST['enf_cro']);						
											$cuadro_vac=limpiar($_POST['cuadro_vac']);
											$ant_quir=limpiar($_POST['ant_quir']);					
											
																						
											mysql_query("UPDATE pacientes SET alergia='$alergia',
																			enf_cro='$enf_cro',
																			cuadro_vac='$cuadro_vac',
																			ant_quir='$ant_quir'																																					
																	WHERE id=$id
											");	
											echo mensajes('Expedinte Registrado con Exito','verde');
									}
																																				
								?>
								<?php 
									if(!empty($_POST['idx'])){ 												
										$id_paciente=limpiar($_POST['idx']);																											
										$fechai=limpiar($_POST['fechai']);																																																						
										$horario=limpiar($_POST['horario']);																																																						
										$tipo=limpiar($_POST['tipo']);
										$fecha=date('Y-m-d');
										$hora=date('H:i:s');
										$status='PENDIENTE';
										$consulta='PENDIENTE';
										
																						
										if(empty($_POST['id'])){
											$oCita=new Proceso_Cita('',$id_paciente,$id_medico,$id_consultorio,$fechai,$tipo,$fecha,$hora,$horario,$status,$consulta);
											$oCita->crear();
											echo mensajes('Cita Medica Guardada con Exito','verde');
										}else{
											$id=limpiar($_POST['id']);
											$oCita=new Proceso_Cita($id,$fechai,$tipo,$horario);
											$oCita->actualizar();
											echo mensajes('Cita Medica Actualizada con Exito','verde');
										}
									}
									

								?>
								  <div align="center">
								 <table width="100%" border="0">
                                  <tr>
                                    <td width="50%">
                                        <div align="right">
                                        <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
                                          <div class="input-group">
                                                 <input class="form-control" name="bus" type="text" class="span2" size="60" list="browsers1" autocomplete="off" placeholder="Buscar" autofocus>
                                                  <datalist id="browsers1">
                                                  <?php
                                                    $buscar=$_POST['bus'];
                                                    $can=mysqli_query($conexion,"SELECT * FROM pacientes"); 
                                                    while($dato=mysqli_fetch_array($can)){
                                                        echo '<option value="'.$dato['nombre'].'">';
                                                    }
                                                  ?>
                                              </datalist>
                                            </td>
                                            <td width="20%">
                                                <button class="btn" type="submit">Buscar</button>
                                          </div>
                                        </form>
                                        </div>
                                    </td>
                                  </tr>
                                </table><br>
                                <table class="table table-striped table-bordered table-hover" style="font-size:13px; font-family:Times New Roman;">
                                    
									<thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>DIRECCION</th>
                                            <th>EDAD</th>
                                            <th>TELEFONO</th>                                           
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											

											if(empty($_POST['bus'])){
                                                $pame=mysqli_query($conexion,"SELECT * FROM pacientes WHERE consultorio='$id_consultorio' ORDER BY nombre LIMIT $inicio, $maximo");
                                            }else{
                                                $buscar=$_POST['bus'];
                                                $pame=mysqli_query($conexion,"SELECT * FROM pacientes where nombre LIKE '$buscar%' 
                                                 or id LIKE '$buscar%'");
                                            }      													
											while($row=mysqli_fetch_array($pame)){
											$url=$row['id'];
											$id_expediente=$row['id'];
											$edad=$row['edad'];	
											
											if ($row['control'] == 'prenatal')
											{
												$editarpre='<div class="btn-group">
														  <button data-toggle="dropdown" class="btn btn-success btn-sm dropdown-toggle"><i class="glyphicon glyphicon-align-justify"></i> <span class="caret"></span></button>
														  <ul class="dropdown-menu pull-right">														   
															<li><a  href="#" data-toggle="modal" data-target="#antecedentespre'.$url.'"><i class="fa fa-edit"></i> Antecedentes</a></li>															
															<li><a  href="#" data-toggle="modal" data-target="#emabarazopre'.$url.'"><i class="fa fa-edit"></i> Emabarazo Actual</a></li>		
														 </ul>
														</div>';
											}
											else {
												$editarpre='';
											}
										?>
                                        <tr class="odd gradeX">
                                            <td><i class="fa fa-user fa-2x"></i> <?php echo $row['nombre']; ?></td>
                                            <td><?php echo $row['direccion']; ?></td>
                                            <td>
												<?php 
												$fecha_de_nacimiento = $row['edad']; 
												
												$array_nacimiento = explode ( "-", $fecha_de_nacimiento ); 
												$array_actual = explode ( "-", $fecha); 

												$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años 
												$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses 
												$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días 

												//ajuste de posible negativo en $días 
												if ($dias < 0) 
												{ 
												    --$meses; 

												    //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual 
												    switch ($array_actual[1]) { 
												           case 1:     $dias_mes_anterior=31; break; 
												           case 2:     $dias_mes_anterior=31; break; 
												           case 3:  
												                if (bisiesto($array_actual[0])) 
												                { 
												                    $dias_mes_anterior=29; break; 
												                } else { 
												                    $dias_mes_anterior=28; break; 
												                } 
												           case 4:     $dias_mes_anterior=31; break; 
												           case 5:     $dias_mes_anterior=30; break; 
												           case 6:     $dias_mes_anterior=31; break; 
												           case 7:     $dias_mes_anterior=30; break; 
												           case 8:     $dias_mes_anterior=31; break; 
												           case 9:     $dias_mes_anterior=31; break; 
												           case 10:     $dias_mes_anterior=30; break; 
												           case 11:     $dias_mes_anterior=31; break; 
												           case 12:     $dias_mes_anterior=30; break; 
												    } 

												    $dias=$dias + $dias_mes_anterior; 
												} 

												//ajuste de posible negativo en $meses 
												if ($meses < 0) 
												{ 
												    --$anos; 
												    $meses=$meses + 12; 
												} 

												echo "<br>$anos años con $meses meses y $dias días"; 
												?>
                                            </td>
                                            <td><?php echo $row['telefono']; ?></td>                                           
                                            <td class="center">
                                            <div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle"><i class="fa fa-cog"></i> <span class="caret"></span></button>
											  <ul class="dropdown-menu pull-right">
												<li><a  href="../perfil_paciente/index.php?id=<?php echo $url; ?>"><i class="fa fa-user"></i> Perfil</a></li>
												<li class="divider"></li>
												<li><a href="#" data-toggle="modal" data-target="#cuadro<?php echo $row['id']; ?>"><i class="fa fa-list"></i> Ant. Personales</a></li>
												<li class="divider"></li>
												<li><a  href="../historial_medico/index.php?id=<?php echo $url; ?>"><i class="fa fa-list-alt"></i> Historial Med.</a></li>
												<li class="divider"></li>
												<li><a href="#" data-toggle="modal" data-target="#newcita<?php echo $row['id']; ?>" ><i class="glyphicon glyphicon-time"></i> Nueva Cita</a></li>												
												<li class="divider"></li>
												<li><a  href="../pagos/index.php?id=<?php echo $url; ?>"><i class="fa fa-dollar"></i> Pagos</a></li>												
												<li class="divider"></li>
												<li><a  href="#" data-toggle="modal" data-target="#actualizar<?php echo $row['id']; ?>"><i class="fa fa-edit"></i> Editar</a></li>																																			
											  </ul>
											</div>			
											</td>
											
									    <!--  Modals-->
										 <div class="modal fade" id="actualizar<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form1" method="post" action="">
												<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h3 align="center" class="modal-title" id="myModalLabel">Actualizar</h3>
															</div>
										<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
											<br>
											<div class="input-group">
												  <span class="input-group-addon">Nombre</span>
												  <input class="form-control" title="Se necesita un nombre"  name="nombre" placeholder="Nombre Completo" value="<?php echo $row['nombre']; ?>" autocomplete="off" required><br>											
											</div><br>
											<div class="input-group">
												  <span class="input-group-addon">Direccion</span>
												  <input class="form-control" title="Se necesita un nombre"  name="direccion" placeholder="Dirección" value="<?php echo $row['direccion']; ?>" autocomplete="off" required><br>											
											</div><br>											
											</div>
											<div class="col-md-6">
											<div class="input-group">
												  <span class="input-group-addon">Nom. Padre</span>
												  <input class="form-control" title="Se necesita un nombre"  name="nomp" placeholder="Nombre Completo" value="<?php echo $row['nomp']; ?>" autocomplete="off" required><br>											
											</div>
											</div>
											<div class="col-md-6">
											<div class="input-group">
												  <span class="input-group-addon">Nom. Madre</span>
												  <input class="form-control" title="Se necesita un nombre"  name="nomm" placeholder="Dirección" value="<?php echo $row['nomm']; ?>" autocomplete="off" required><br>											
											</div><br>											
											</div>
											<div class="col-md-6">																			
												<div class="input-group">
												  <span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
												 <input class="form-control" name="telefono" data-mask="9999-9999" autocomplete="off" required value="<?php echo $row['telefono']; ?>"><br>
												</div><br>
											</div>
											
											<div class="col-md-6">	
												<div class="input-group">
												  <span class="input-group-addon">Ref. por</span>
												  <input class="form-control" name="refpor" autocomplete="off" value="<?php echo $row['refpor']; ?>"><br>												
												</div><br>
											</div>
											<div class="col-md-6">	
												<div class='input-group'>
													<span class="input-group-addon">Nac:</span>
													<input type='date' name="edad" id="form_datex" class="form-control" value="<?php echo $row['edad']; ?>" required/>				
													
												</div><br>
											</div>
											<div class="col-md-6">																			
												<div class="input-group">
												<span class="input-group-addon">P.F Cita:</span>
												 <input type="date" class="form-control" name="feccita"  autocomplete="off" required value="<?php echo $row['feccita']; ?>"><br>
												</div><br>
												
											</div>
											<div class="col-md-6">																																		
												<div class="input-group">
												  <span class="input-group-addon">Sexo</span>
												  <select class="form-control" name="sexo" autocomplete="off" required>
													<option value="m" <?php if($row['sexo']=='m'){ echo 'selected'; } ?>>Masculino</option>
													<option value="f" <?php if($row['sexo']=='f'){ echo 'selected'; } ?>>Femenino</option>												
												</select>												
												</div><br>
											</div> 
											<div class="col-md-6">																																		
												<div class="input-group">
												  <span class="input-group-addon">Seguro</span>
												  <select class="form-control" name="seguro" autocomplete="off" required>
													<option value="ninguno" <?php if($row['seguro']=='ninguno'){ echo 'selected'; } ?>>NINGUNO</option>
													<option value="vivir" <?php if($row['seguro']=='vivir'){ echo 'selected'; } ?>>VIVIR</option>
													<option value="rpn" <?php if($row['seguro']=='rpn'){ echo 'selected'; } ?>>RPN</option>												
													<option value="sg" <?php if($row['seguro']=='sg'){ echo 'selected'; } ?>>SALUD GLOBAL</option>
													<option value="acsa" <?php if($row['seguro']=='acsa'){ echo 'selected'; } ?>>ACSA</option>
													<option value="sp" <?php if($row['seguro']=='sp'){ echo 'selected'; } ?>>SEGURO DEL PACIFICO</option>												
													<option value="paligmed" <?php if($row['seguro']=='paligmed'){ echo 'selected'; } ?>>PALIGMED</option>												
													<option value="red" <?php if($row['seguro']=='red'){ echo 'selected'; } ?>>MI RED</option>												
													<option value="sisa" <?php if($row['seguro']=='sisa'){ echo 'selected'; } ?>>SISA</option>												
													<option value="otros" <?php if($row['seguro']=='otros'){ echo 'selected'; } ?>>OTROS</option>
												</select>												
												</div><br>
											</div> 
											
											<div class="col-md-6">	
												<div class="input-group">
												  <span class="input-group-addon">Estado</span>
												  <select class="form-control" name="estado" autocomplete="off" required>
													<option value="s" <?php if($row['estado']=='s'){ echo 'selected'; } ?>>Activo</option>
													<option value="n" <?php if($row['estado']=='n'){ echo 'selected'; } ?>>No Activo</option>													
												</select>												
												</div>
											</div>                                 
                                       
										</div> 
										</div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>										 
                                    </div>
                                </div>
								</form>
                            </div>
                     <!-- End Modals-->
					 <!--  Modals-->
								 <div class="modal fade" id="cuadro<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<form name="form1" method="post" action="">
										<input type="hidden" value="<?php echo $row['id']; ?>" name="id">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													
														<h3 align="center" class="modal-title" id="myModalLabel">ANTECEDENTES PERSONALES</h3>
													</div>
										<?php if(permiso($_SESSION['cod_user'],'3')==TRUE){ ?>
										<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
											<div class="alert alert-info" align="center"><strong><?php echo $row['nombre']; ?></strong></div>
											<input type="hidden" name="nombre">															
											</div>
											<div class="col-md-6">
												<!--<div class="input-group">
												  <span class="input-group-addon">Sangre</span>
												  <select class="form-control" name="sangre" value="<?php echo $row['sangre']; ?>" autocomplete="off" required>
													<option value="" selected disabled>---SELECCIONE---</option>
													<option value="AME" <?php if ($row['sangre']=="AME") echo 'selected'; ?>>A RH-</option>
													<option value="AMA" <?php if ($row['sangre']=="AMA") echo 'selected';?>>A RH+</option>
													<option value="ABME" <?php if ($row['sangre']=="ABME") echo 'selected'; ?>>AB RH-</option>
													<option value="ABMA" <?php if ($row['sangre']=="ABMA") echo 'selected'; ?>>AB RH+</option>
													<option value="BME" <?php if ($row['sangre']=="BME") echo 'selected'; ?>>B RH-</option>
													<option value="BMA" <?php if ($row['sangre']=="BMA") echo 'selected'; ?>>B RH+</option>
													<option value="OME" <?php if ($row['sangre']=="OME") echo 'selected'; ?>>O RH-</option>
													<option value="OMA" <?php if ($row['sangre']=="OMA") echo 'selected'; ?>>O RH+</option>		
												</select>
												</div><br>-->
												<!--<div class="input-group">
												  <span class="input-group-addon">VIH</span>
												  <select class="form-control" name="vih" autocomplete="off" required>
													<option value="" selected disabled>---SELECCIONE---</option>
													<option value="p" <?php if($row['vih']=='p'){ echo 'selected'; } ?>>Positivo</option>
													<option value="n" <?php if($row['vih']=='n'){ echo 'selected'; } ?>>Negativo</option>																									
												</select>
												</div><br>-->
												<!--<div class="input-group">
												  <span class="input-group-addon">Peso</span>
												 <input class="form-control" name="peso" value="<?php echo $row['peso']; ?>" autocomplete="off" required><br>
												</div><br>-->
												<!--<div class="input-group">
												  <span class="input-group-addon">Talla</span>
												  <input class="form-control" name="talla" value="<?php echo $row['talla']; ?>" autocomplete="off" required><br>
												</div><br>-->
												
												
												<span class="input-group-addon"> 1.Alergias:</span>
                                                <textarea class="form-control" name="alergia"  value="<?php echo $row['alergia']; ?>" rows="3"><?php echo $row['alergia']; ?></textarea><br>																
											
												<span class="input-group-addon"> 2.Enfermedades Cronicas:</span>
                                                <textarea class="form-control" name="enf_cro"  value="<?php echo $row['enf_cro']; ?>" rows="3"><?php echo $row['enf_cro']; ?></textarea><br>
											</div>											
											<div class="col-md-6">
												<span class="input-group-addon"> 3.Cuadro de Vacunas:</span>
                                                <textarea class="form-control" name="cuadro_vac" value="<?php echo $row['cuadro_vac']; ?>"  rows="3"><?php echo $row['cuadro_vac']; ?></textarea><br>
												<span class="input-group-addon"> 4.Antecedentes Quirurgicos:</span>
                                                <textarea class="form-control" name="ant_quir" value="<?php echo $row['ant_quir']; ?>"  rows="3"><?php echo $row['ant_quir']; ?></textarea><br>
											</div>                                 
                                       
										</div> 
										</div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
										<?php }else{ echo mensajes("NO TIENES PERMISO PARA ENTRAR A ESTE FORMULARIO","rojo"); }?>
                                    </div>
                                </div>
								</form>
                            </div>
                     <!-- End Modals-->
					 <!-- Modal -->           			
							<div class="modal fade" id="eliminar<?php echo $url; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<form name="contado" action="index.php?del=<?php echo $url; ?>" method="get">
									<input type="hidden" name="id" value="<?php echo $url; ?>">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>													
													<h3 align="center" class="modal-title" id="myModalLabel">Seguridad</h3>
												</div>
													<div class="panel-body">
														<div class="row" align="center">                                       																										
														<strong>Hola! <?php echo $cajero_nombre; ?></strong><br><br>
														<div class="alert alert-danger">
																	<h4>¿Esta Seguro de Realizar esta Acción?<br><br> 
																	una vez Eliminado el paciente [ <?php echo $row['nombre']; ?> ]<br> 
																	no podran ser Recuperados sus datos.<br>
																	No recomendamos esta accion, sino la de "Activo" o No Activo, porque de este
																	depende mucha informcion en el Almacen de datos.
																	</h4>
														</div>																																																																																																								
														</div> 
													</div> 
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
														<a href="index.php?del=<?php echo $row['id']; ?>"  class="btn btn-danger" title="Eliminar">
															<i class="fa fa-times" ></i> <strong>Eliminar</strong>
														</a>																
													</div>										 
											</div>
										</div>
									</form>
							</div>
						<!-- End Modals-->
								<!--  Modals-->
										 <div class="modal fade" id="newcita<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<form name="form2" method="post" action="">
												<input type="hidden" name="idx" value="<?php echo $row['id']; ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															
																<h3 align="center" class="modal-title" id="myModalLabel">NUEVA CITA <br><?php echo $row['nombre']; ?></h3>
															</div>
															<div class="panel-body">
															<div class="row">                                       
															<div class="col-md-6">
																																												
																	<select class="form-control" name="tipo" autocomplete="off" required>
																		<option value="" selected disabled>--CONSULTA--</option>
																		<option value="GEN">PEDIATRIA</option>
																		<option value="NP">NEFROLOGIA PEDIATRICA</option>																																	
																	</select><br>												            																																
																</div>
																<div class="col-md-6">
																	<div class='input-group'>
																		<input type='date' name="fechai"  class="form-control" placeholder="Fecha Proxima Cita" required autocomplete="off" />
																		<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
																	</div><br>																
																	<div class='input-group'>
																		<input type='time' name="horario"  class="form-control" placeholder="Horario" required autocomplete="off" />
																		<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
																	</div>							   												
																	<!--<input type="date" class="form-control" name="fechai" min="1"  autocomplete="off" required><br>-->																															
																</div>  
															</div> 
															<div class="modal-footer">
																<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
																<button type="submit" class="btn btn-primary">Guardar</button>
															</div>										 
														</div>
													</div>
													</form>
												</div>
										 <!-- End Modals-->
	                                      </tr> 
											<?php } ?>
                                    </tbody>									
                                </table>
                                <div align="center">
                                    <ul class="pagination pagination-split" >
                                        <?php
                                        if(empty($_POST['bus'])){
                                            $tp = ceil($total/$maximo);#funcion que devuelve entero redondeado
                                            for ($n=1; $n<=$tp ; $n++){
                                                if($pag==$n){
                                                    echo '<li class="active"><a href="index.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';   
                                                }else{
                                                    echo '<li><a href="index.php?pag='.$n.'"><strong>'.$n.'</strong></a></li>';  
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>							
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  -->
<?php }else{ echo mensajes("NO TIENES PERMISO PARA ENTRAR A ESTE FORMULARIO","rojo"); }?>				
        </div>               
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="../../assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="../../assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../../assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="../../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../../assets/js/dataTables/dataTables.bootstrap.js"></script>
	<!-- CALENDARIO SCRIPTS -->
    <script src="../../assets/todo/bootstrap-datetimepicker.js"></script>
    <script src="../../assets/todo/locales/bootstrap-datetimepicker.es.js"></script>
	<!-- VALIDACIONES -->
	<script src="../../assets/js/jasny-bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
     <!-- DATATIMEPICKER -->
   <script  src="../../assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
   <script  src="../../assets/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
   <script type="text/javascript">
        $(function () {
           $('#form_date').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	 $('#form_date2').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('#form_time').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
      $('#form_datex').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });	
        });
   </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="../../assets/js/custom.js"></script>
</body>
</html>