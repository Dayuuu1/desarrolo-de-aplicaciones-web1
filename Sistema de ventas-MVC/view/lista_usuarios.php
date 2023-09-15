<?php

require_once '../controller/UsuarioController.php';

$controllerU = new UsuarioController();
$listaUsuarios = $controllerU->listarUsuario();

if (!isset($_SESSION['nombre'])) {
	// Redireccionar a otro archivo (puedes cambiar "otra_pagina.php" por la página que desees)
	header("Location: ../index.php");
	exit(); // Asegura que el script se detenga después de la redirección
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../assets/img/logito.png">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="../assets/css/style.css">
	<link rel="stylesheet" href="../assets/css/tablas/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../assets/js/vendor/jquery-nice-select/css/nice-select.css">
	<link rel="stylesheet" href="../assets/css/tablas/stylet.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

	<title>Usuarios</title>
</head>

<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="index.php" class="brand card-title"><i class='bx bxs-smile icon'></i> Hi, <?php echo $_SESSION['nombre']; ?></a>
		<ul class="side-menu">
			<li><a href="index.php"><i class='bx bxs-dashboard icon'></i> Panel</a></li>
			<li class="divider" data-text="Principal">Principal</li>
			<li>
				<a href="#"><i class='bx bxs-inbox icon'></i> Listar <i class='bx bx-chevron-right icon-right'></i></a>
				<ul class="side-dropdown">
					<li><a class="active" href="lista_usuarios.php">Usuarios</a></li>
					<li><a href="lista_productos.php">Productos</a></li>
					<li><a href="lista_clientes.php">Clientes</a></li>
					<li><a href="lista_proveedores.php">proveedores</a></li>
					<li><a href="lista_ventas.php">ventas</a></li>
				</ul>
			</li>
			<li><a href="venta.php"><i class='bx bxs-cart-alt icon'></i> Nueva venta</a></li>
			<li class="divider" data-text="Estadisticas de Tablas">Estadisticas de Tablas</li>
			<!--<li><a href="#"><i class='bx bx-table icon'></i> ventas</a></li>-->
			<li><a href="ganancias.php"><i class='bx bx-table icon'></i> Ganancias</a></li>
		</ul>

	</section>
	<!-- SIDEBAR -->

	<!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu toggle-sidebar'></i>
			<form action="#">
				<div class="form-group">
					<input type="text" placeholder="Search...">
					<i class='bx bx-search icon'></i>
				</div>
			</form>
			<a href="#" class="nav-link">
				<i class='bx bxs-bell icon'></i>
				<span class="badge">5</span>
			</a>
			<a href="#" class="nav-link">
				<i class='bx bxs-message-square-dots icon'></i>
				<span class="badge">8</span>
			</a>
			<span class="divider"></span>
			<div class="profile">
				<img src="../uploads/<?php echo $_SESSION["image_url"]; ?>" alt="">
				<ul class="profile-link">
					<li><a href="#"><i class='bx bxs-user-circle icon'></i> perfil</a></li>
					<li><a href="#"><i class='bx bxs-cog'></i> opciones</a></li>
					<li><a href="salir.php"><i class='bx bxs-log-out-circle'></i> cerrar sesion</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>



			<div class="modal fade show" id="basicModal" style="padding-right: 15px; display: none;" aria-modal="true" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Agregar usuario</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal">
							</button>
						</div>
						<form action="../controller/UsuarioController.php" method="post" autocomplete="off" enctype="multipart/form-data">
							<div class="modal-body">
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">Nombre</label>
									<div class="col-sm-10">
										<input type="text" class="form-control form-control-sm" name="nombre" id="nombre" placeholder="Ingrese su nombre" required>
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">Correo</label>
									<div class="col-sm-10">
										<input type="email" class="form-control form-control-sm" placeholder="Ingrese Correo" name="correo" id="correo">
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">contraseña</label>
									<div class="col-sm-10">
										<input type="password" class="form-control form-control-sm" placeholder="Ingrese Contraseña" name="clave" id="clave">
									</div>
								</div>

								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label" for="validationCustom05">Rol
										<span class="text-danger">*</span>
									</label>
									<div class="col-sm-10">
										<select class="nice-select form-control" name="rol" id="rol">
											<option value="1">administrador</option>
											<option value="2">vendedor</option>
										</select>
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">Foto</label>
									<div class="col-sm-10">
										<input type="file" class="form-file-input form-control" name="my_image">
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Cerrar</button>
								<button class="btn btn-primary" name="guardar" id="guardar">Guardar</button>
							</div>

						</form>

					</div>
				</div>

			</div>
			<div class="row page-titles">

				<ol class="breadcrumb">

					<li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
					<li class="breadcrumb-item"><a href="javascript:void(0)">Usuarios</a></li>
				</ol>
			</div>


			<br>
			<div class="card">

				<div class="card-body">
					<?php if ($_SESSION['id_rol'] == 1) { ?>
						<button type="button" class="btn btn-rounded btn-info" data-bs-toggle="modal" data-bs-target="#basicModal"><span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
							</span>Nuevo Usuario</button>
					<?php } ?>

					<br><br>
					<div class="table-responsive">

						<table id="example3" class="display" style="min-width: 845px">
							<thead>
								<tr>
									<th>Foto</th>
									<th>Nombre</th>
									<th>Correo</th>
									<th>Rol</th>
									<?php if ($_SESSION['id_rol'] == 1) { ?>
										<th>Accion</th>
									<?php } ?>
								</tr>
							</thead>

							<tbody>
								<?php
								foreach ($listaUsuarios as $item) {
								?>
									<tr>
										<td><img class="rounded-circle" width="35" src="../uploads/<?php echo $item["image_url"]; ?>" alt=""></td>
										<td><?php echo $item["nombre"]; ?></td>
										<td><?php echo $item["correo_electronico"]; ?></td>
										<td><?php echo $item["nombre_rol"]; ?></td>


										<?php if ($_SESSION['id_rol'] == 1) { ?>
											<td>
												<a href="frm_editar" class="btn btn-primary shadow btn-xs sharp me-1 editar-usuario" data-bs-toggle="modal" data-bs-target="#edit_modal" id="usuario<?php echo $item["id_usuario"]; ?>" data-id_usuario="<?php echo $item["id_usuario"]; ?>" data-imagen="<?php echo $item["image_url"]; ?>" data-contra="<?php echo $item["contraseña"]; ?>">
													<i class="fas fa-pencil-alt"></i>
												</a>

												<a href="frmD_eliminar" class="btn btn-danger shadow btn-xs sharp btn eliminar-usuario" data-bs-toggle="modal" data-bs-target="#eliminar_modal" id="usuario<?php echo $item["id_usuario"]; ?>" data-id_usuario="<?php echo $item["id_usuario"]; ?>" data-nombre_usuario="<?php echo $item["nombre"]; ?>">
													<i class="fa fa-trash"></i>
												</a>
											</td>
										<?php } ?>
									</tr>
								<?php
								}
								?>




							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal fade show" id="edit_modal" style="padding-right: 15px; display: none;" aria-modal="true" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Editar usuario</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal">
							</button>
						</div>
						<form action="../controller/UsuarioController.php" method="post" autocomplete="off" enctype="multipart/form-data">
							<div class="modal-body">
								<div class="mb-3 row " style="display: none;">
									<label class="col-sm-2 col-form-label col-form-label-sm">Imagen</label>
									<div class="col-sm-10">
										<input type="text" class="form-control form-control-sm" name="img_no" id="img_no" placeholder="imagen" required>
									</div>
								</div>
								<div class="mb-3 row" style="display: none;">
									<label class="col-sm-2 col-form-label col-form-label-sm">ID</label>
									<div class="col-sm-10">
										<input type="text" class="form-control form-control-sm" name="id_edit" id="id_edit" placeholder="Ingrese el nuevo nombre" required>
									</div>
								</div>
								<div class="mb-3 row" style="display: none;">
									<label class="col-sm-2 col-form-label col-form-label-sm">Contraseña</label>
									<div class="col-sm-10">
										<input type="text" class="form-control form-control-sm" name="contra_edit" id="contra_edit" placeholder="contra_edit" required>
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">Nombre</label>
									<div class="col-sm-10">
										<input type="text" class="form-control form-control-sm" name="nombre_edit" id="nombre_edit" placeholder="Ingrese el nuevo nombre" required>
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">Correo</label>
									<div class="col-sm-10">
										<input type="email" class="form-control form-control-sm" placeholder="Ingrese el nuevo Correo" name="correo_edit" id="correo_edit">
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">contraseña</label>
									<div class="col-sm-10">
										<input type="password" class="form-control form-control-sm" placeholder="Ingrese nueva Contraseña" name="clave_edit" id="clave_edit">
									</div>
								</div>

								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label" for="validationCustom05">Rol
										<span class="text-danger">*</span>
									</label>
									<div class="col-sm-10">
										<select class="nice-select form-control" name="rol_edit" id="rol_edit">
											<option value="1">administrador</option>
											<option value="2">vendedor</option>
										</select>
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">Foto</label>
									<div class="col-sm-10">
										<input type="file" class="form-file-input form-control" name="my_image_edit">
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Cerrar</button>
								<button class="btn btn-primary" name="modificar" id="modificar">Editar</button>
							</div>

						</form>

					</div>
				</div>

			</div>
			<div class="modal fade show" id="eliminar_modal" style="padding-right: 15px; display: none;" aria-modal="true" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Eliminar usuario</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal">
							</button>
						</div>
						<form action="../controller/UsuarioController.php" method="post" autocomplete="off">
							<div class="modal-body">
								<div class="mb-3 row ">

									<div class="col-sm-10" style="display: none;">
										<input type="text" class="form-control form-control-sm" name="idUsaurio_eliminar" id="idUsaurio_eliminar" placeholder="id_eliminar" required>
									</div>
									<h3>Estas seguro de querer eliminar a <span id="elimin_usuario"></span></h3>
								</div>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary " data-bs-dismiss="modal">Cerrar</button>
								<button class="btn btn-danger light" name="id_eliminar_usua" id="id_eliminar_usua">Eliminar</button>
							</div>

						</form>

					</div>
				</div>

			</div>
		</main>

	</section>


	<!-- para el select -->

	<script src="../assets/js/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
	<script src="../assets/js/vendor/global/global.min.js"></script>
	<script src="../assets/js/vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="../assets/js/phug/plugins-init/datatables.init.js"></script>
	<script src="../assets/js/script.js"></script>


	<script src="../assets/js/phug/custom.min.js"></script>

	<!--para las alertas -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- del boostrap del docente-->
	<script type="text/javascript" src="../assets/js/jquery-3.7.0.min.js"></script>
	<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="../assets/js/funciones.js"></script>
	<!-- -->
	<script>
		function toggleSidebarOnWidth() {
			const screenWidth = window.innerWidth;

			if (screenWidth <= 1010) {
				sidebar.classList.add('hide');
				allSideDivider.forEach(item => {
					item.textContent = '-'
				})
				allDropdown.forEach(item => {
					const a = item.parentElement.querySelector('a:first-child');
					a.classList.remove('active');
					item.classList.remove('show');
				})
			} else {
				sidebar.classList.remove('hide');
			}
		}
		window.addEventListener('resize', function() {
			// Llamar a la función toggleSidebarOnWidth en el evento resize
			toggleSidebarOnWidth();
		});

		// Llamar a la función toggleSidebarOnWidth al cargar la página para establecer el estado inicial de la barra lateral
		toggleSidebarOnWidth();
		$(document).ready(function() {
			$('#example3').DataTable({
				"pageLength": 5 // Configuración para mostrar 5 registros por página
				// Otras configuraciones y opciones que puedas necesitar
			});
		});
	</script>

	<?php
	if (isset($_SESSION['success_message'])) {
		echo '<script type="text/javascript">';
		echo "Swal.fire({
			icon: 'success',
			title: 'Exito',
			text: '{$_SESSION['success_message']}'
		});";
		echo '</script>';
		unset($_SESSION['success_message']);
	}
	?>

</body>

</html>