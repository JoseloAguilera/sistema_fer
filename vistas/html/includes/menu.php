<!-- Top Bar Start -->
<div class="topbar">

	<!-- LOGO -->
	<div class="topbar-left">
		<div class="text-center">
			<a href="#" class="logo"><i class="mdi mdi-radar"></i> <span>AJAKA System</span></a>
			<?php var_dump($DateAndTime); ?>
		</div>
	</div>

	<!-- Button mobile view to collapse sidebar menu -->
	<nav class="navbar-custom">

		<ul class="list-inline float-right mb-0">
			<li class="list-inline-item notification-list hide-phone">
				<a class="nav-link waves-light waves-effect" href="new_compra.php" >
				<button type="button" class="btn btn-default btn-rounded dropdown-toggle waves-effect waves-light"> <i class='fa fa-shopping-bag'></i> <i class="caret"></i> COMPRA</button>	
				</a>
			</li>
			<li class="list-inline-item notification-list hide-phone">
				<a class="nav-link waves-light waves-effect" href="new_venta.php" >
				<button type="button" class="btn btn-default btn-rounded dropdown-toggle waves-effect waves-light"> <i class='fa fa-shopping-cart'></i> <i class="caret"></i> VENTA</button>	
				</a>
			</li>
			<li class="list-inline-item notification-list hide-phone">
				<a class="nav-link waves-light waves-effect" href="new_cotizacion.php" >
				<button type="button" class="btn btn-default btn-rounded dropdown-toggle waves-effect waves-light"> <i class='fa fa-file-text'></i> <i class="caret"></i> PRESUPUESTO</button>	
				</a>
			</li>
			
			<li class="list-inline-item notification-list hide-phone">
				<a class="nav-link waves-light waves-effect" href="#" id="btn-fullscreen">
					<i class="mdi mdi-crop-free noti-icon"></i>
				</a>
			</li>

			<li class="list-inline-item dropdown notification-list">
				<a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
				aria-haspopup="false" aria-expanded="false">
				<img src="../../assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle">
			</a>
			<div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">

				<!-- item-->
				<a href="javascript:void(0);" class="dropdown-item notify-item">
					<i class="mdi mdi-account-star-variant"></i> <span>Perfil</span>
				</a>

				<!-- item-->
				<a href="../../login.php?logout" class="dropdown-item notify-item">
					<i class="mdi mdi-logout"></i> <span>Salir</span>
				</a>

			</div>
		</li>

	</ul>

	<ul class="list-inline menu-left mb-0">
		<li class="float-left">
			<button class="button-menu-mobile open-left waves-light waves-effect">
				<i class="mdi mdi-menu"></i>
			</button>
		</li>
	</ul>

</nav>

</div>
<!-- Top Bar End -->
<!-- ========== Left Sidebar Start ========== -->

<div class="left side-menu">
	<div class="sidebar-inner slimscrollleft">
		<!--- Divider -->
		<div id="sidebar-menu">
			<ul>
				<li class="menu-title">Menu</li>

				<li>
					<a href="principal.php" class="waves-effect waves-primary"><i
						class="ti-home"></i><span> Inicio </span></a>
					</li>
					<li>
						<a href="../html/clientes.php" class="waves-effect waves-primary"><i
							class="ti-user"></i><span> Clientes </span></a>
						</li>
						<li>
							<a href="../html/proveedores.php" class="waves-effect waves-primary"><i
								class="ti-truck"></i><span> Proveedores </span></a>
							</li>
							<li class="has_sub">
								<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-package"></i><span> Productos </span>
									<span class="menu-arrow"></span></a>
									<ul class="list-unstyled">
										<li><a href="../html/lineas.php">Categorias</a></li>
										<li><a href="../html/productos.php">Productos</a></li>
										<li><a href="../html/kardex.php">Kardex</a></li>
										<li><a href="../html/ajustes.php">Ajuste de Inventario</a></li>
									</ul>
								</li>

								<li class="has_sub">
									<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-bag"></i><span> Compras </span> <span class="menu-arrow"></span></a>
									<ul class="list-unstyled">
										<li><a href="../html/new_compra.php">Nueva Compra</a></li>
										<li><a href="../html/bitacora_compras.php">Listado de Compras</a></li>
									</ul>
								</li>

								<!--<li>
									<a href="../html/traslados.php" class="waves-effect waves-primary"><i
										class="ti-truck"></i><span> Traslados </span></a>
									</li>-->

									<li class="has_sub">
										<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-shopping-cart-full"></i><span> Ventas
										</span> <span class="menu-arrow"></span></a>
										<ul class="list-unstyled">
											<li><a href="../html/new_venta.php">Nueva Venta</a></li>
											<li><a href="../html/bitacora_ventas.php">Listado de Ventas</a></li>
											<!--<li><a href="../html/caja.php">Caja</a></li>-->
										</ul>
									</li>
									<li class="has_sub">
										<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-receipt"></i><span> Presupuesto
										</span> <span class="menu-arrow"></span></a>
										<ul class="list-unstyled">
											<li><a href="../html/new_cotizacion.php">Nuevo Presupuesto</a></li>
											<li><a href="../html/bitacora_cotizacion.php">Listado de Presupuestos</a></li>
										</ul>
									</li>
										<li class="has_sub">
										<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-agenda"></i><span> Cobros y Pagos </span>
												<span class="menu-arrow"></span></a>
												<ul class="list-unstyled">
													<li><a href="../html/cxc.php">Abono Cliente</a></li>
													<li><a href="../html/cxp.php">Abono Proveedor</a></li>
												</ul>
											</li>

											<li class="has_sub">
												<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-files"></i><span> Reportes </span> <span class="menu-arrow"></span></a>
												<ul class="list-unstyled">
													<!--<li><a href="../html/rep_producto.php">Reporte Productos</a></li>-->
													<li><a href="../html/rep_ventas.php">Reporte de Ventas</a></li>
													<!--<li><a href="../html/rep_ventas_users.php">Ventas por Usuarios</a></li>-->
													<li><a href="../html/rep_compras.php">Reporte de Compras</a></li>
													<li><a href="../html/rep_caja_chica.php">Reporte Caja chica</a></li>
													<li><a href="../html/rep_caja_general.php">Corte de Caja General</a></li>
													<li><a href="../html/rep_financiero.php">Reporte Financiero</a></li>
												</ul>
											</li>

											<li class="has_sub">
												<a href="javascript:void(0);" class="waves-effect waves-primary"><i class="ti-settings"></i><span> Configuración </span> <span class="menu-arrow"></span></a>
												<ul class="list-unstyled">
													<li><a href="../html/empresa.php">Empresa</a></li>
													<li><a href="../html/sucursales.php">Sucursales</a></li>
													<li><a href="../html/comprobantes.php">Comprobantes</a></li>
													<!--<li><a href="../html/impuestos.php">Impuestos</a></li>-->
													<li><a href="../html/grupos.php">Grupos de Usuarios</a></li>
													<li><a href="../html/usuarios.php">Usuario</a></li>
													<li><a href="../html/backup.php">Backup</a></li>
													<li><a href="../html/restore.php">Restore</a></li>
												</ul>
											</li>

										</ul>

										<div class="clearfix"></div>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<!-- Left Sidebar End -->
