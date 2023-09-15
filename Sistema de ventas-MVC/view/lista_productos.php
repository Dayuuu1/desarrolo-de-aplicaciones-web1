<?php

require_once '../controller/ProductoController.php';

$controllerP = new ProductoController();
$listaproductos = $controllerP->listarProducto();
require_once '../controller/ProveedorController.php';

$controllerProve = new ProveedorController();
$listaproveedores = $controllerProve->listarCliente();
if (!isset($_SESSION['nombre'])) {

	header("Location: ../index.php");
	exit();
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
					<li><a href="lista_usuarios.php">Usuarios</a></li>
					<li><a class="active" href="lista_productos.php">Productos</a></li>
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
							<h5 class="modal-title">Agregar producto</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal">
							</button>
						</div>
						<form action="../controller/ProductoController.php" method="post" autocomplete="off" enctype="multipart/form-data">
							<div class="modal-body">
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">Codigo</label>
									<div class="col-sm-10">
										<input type="text" class="form-control form-control-sm" name="codigo" id="codigo" placeholder="Ingrese codigo del producto" required>
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">Nombre</label>
									<div class="col-sm-10">
										<input type="text" class="form-control form-control-sm" name="nombre_producto" id="nombre_producto" placeholder="Ingrese nombre del producto" required>
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">stock</label>
									<div class="col-sm-10">
										<input type="number" class="form-control form-control-sm" placeholder="Ingrese stock" name="stock" id="stock">
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">Precio</label>
									<div class="col-sm-10">
										<input type="number" class="form-control form-control-sm" placeholder="Ingrese precio del producto" name="precio_unitario" id="precio_unitario">
									</div>
								</div>

								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label" for="validationCustom05">Proveedor
										<span class="text-danger">*</span>
									</label>
									<div class="col-sm-10">
										<select class="nice-select form-control" name="id_proveedor" id="id_proveedor">
											<?php
											foreach ($listaproveedores as $item) {
											?>
												<option value="<?php echo $item["id_proveedor"]; ?>"><?php echo $item["nombre_proveedor"]; ?></option>
											<?php
											}
											?>
										</select>
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
					<li class="breadcrumb-item"><a href="javascript:void(0)">Productos</a></li>
				</ol>
			</div>


			<br>
			<div class="card">

				<div class="card-body">
					<?php if ($_SESSION['id_rol'] == 1) { ?>
						<button type="button" class="btn btn-rounded btn-info" data-bs-toggle="modal" data-bs-target="#basicModal"><span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
							</span>Nuevo Producto</button>
					<?php } ?>

					<br><br>
					<div class="table-responsive">

						<table id="example3" class="display" style="min-width: 845px">
							<thead>
								<tr>
									<th>Codigo</th>
									<th>QR</th>
									<th>Nombre</th>
									<th>stock</th>
									<th>precio</th>
									<th>proveedor</th>
									<?php if ($_SESSION['id_rol'] == 1) { ?>
										<th>Accion</th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($listaproductos as $item) {
								?>
									<tr>
										<td><?php echo $item["codigo"]; ?></td>
										<td>
											<div class="qrCode"></div>
										</td>
										<td><?php echo $item["nombre_producto"]; ?></td>
										<td><?php echo $item["stock"]; ?></td>
										<td><?php echo $item["precio_unitario"]; ?></td>
										<td><?php echo $item["nombre_proveedor"]; ?></td>


										<?php if ($_SESSION['id_rol'] == 1) { ?>
											<td>
												<a href="frm_editar" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#edit_modal" id="producto<?php echo $item["id_producto"]; ?>" data-id_producto="<?php echo $item["id_producto"]; ?>">
													<i class="fas fa-pencil-alt"></i>
												</a>

												<a href="frmD_eliminar" class="btn btn-danger shadow btn-xs sharp btn" data-bs-toggle="modal" data-bs-target="#eliminar_modal" id="producto<?php echo $item["id_producto"]; ?>" data-id_producto="<?php echo $item["id_producto"]; ?>" data-nombre_producto="<?php echo $item["nombre_producto"]; ?>">
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
							<h5 class="modal-title">Editar producto</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal">
							</button>
						</div>
						<form action="../controller/ProductoController.php" method="post" autocomplete="off" enctype="multipart/form-data">
							<div class="modal-body">

								<div class="mb-3 row" style="display: none;">
									<label class="col-sm-2 col-form-label col-form-label-sm">ID</label>
									<div class="col-sm-10">
										<input type="text" class="form-control form-control-sm" name="idProdcuto_edit" id="idProdcuto_edit" placeholder="Ingrese id" required>
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">Codigo</label>
									<div class="col-sm-10">
										<input type="text" class="form-control form-control-sm" name="codigo_edit" id="codigo_edit" placeholder="Ingrese el nuevo codigo" required>
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">Nombre</label>
									<div class="col-sm-10">
										<input type="text" class="form-control form-control-sm" name="nombre_producto_edit" id="nombre_producto_edit" placeholder="Ingrese el nuevo nombre" required>
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">stock</label>
									<div class="col-sm-10">
										<input type="number" class="form-control form-control-sm" placeholder="Ingrese el nuevo stock" name="stock_edit" id="stock_edit">
									</div>
								</div>
								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label col-form-label-sm">precio</label>
									<div class="col-sm-10">
										<input type="number" class="form-control form-control-sm" placeholder="Ingrese nueva precio" name="precio_unitario_edit" id="precio_unitario_edit">
									</div>
								</div>

								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label" for="validationCustom05">proveedor
										<span class="text-danger">*</span>
									</label>
									<div class="col-sm-10">
										<select class="nice-select form-control" name="id_proveedor_edit" id="id_proveedor_edit">
											<?php
											foreach ($listaproveedores as $item) {
											?>
												<option value="<?php echo $item["id_proveedor"]; ?>"><?php echo $item["nombre_proveedor"]; ?></option>
											<?php
											}
											?>
										</select>
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
							<h5 class="modal-title">Eliminar producto</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal">
							</button>
						</div>
						<form action="../controller/ProductoController.php" method="post" autocomplete="off">
							<div class="modal-body">
								<div class="mb-3 row ">

									<div class="col-sm-10" style="display: none;">
										<input type="text" class="form-control form-control-sm" name="idProducto_eliminar" id="idProducto_eliminar" placeholder="idProducto_eliminar" required>
									</div>
									<h3>Estas seguro de querer eliminar <span id="elimin_producto"></span></h3>
								</div>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary " data-bs-dismiss="modal">Cerrar</button>
								<button class="btn btn-danger light" name="id_eliminar_pro" id="id_eliminar_pro">Eliminar</button>
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
	<!-- para el qr -->
	<script defer src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
	<script src="../assets/js/qr.js"></script>


	<!--para las alertas -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- del boostrap del docente-->
	<script type="text/javascript" src="../assets/js/jquery-3.7.0.min.js"></script>
	<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/bootstrap.bundle.min.js"></script>

	<!-- -->
	<script>
		/*Cargar al modal editar producto*/

		$(document).on('click', "a[id^=producto]", function() {
			var id_producto = $(this).data("id_producto");

			value1 = $(this).closest('tr').find('td:eq(0)').text();
			value2 = $(this).closest('tr').find('td:eq(2)').text();
			value3 = $(this).closest('tr').find('td:eq(3)').text();
			value4 = $(this).closest('tr').find('td:eq(4)').text();
			value5 = $(this).closest('tr').find('td:eq(5)').text();

			$("#codigo_edit").val(value1);
			$("#nombre_producto_edit").val(value2);
			$("#stock_edit").val(value3);
			$("#precio_unitario_edit").val(value4);
			$("#id_proveedor_edit").val(value5);


			if (value5 === "SATRA") {
				$("#id_proveedor_edit").val("1");
			} else if (value5 === "MAYORGA") {
				$("#id_proveedor_edit").val("2");
			} else if (value5 === "WISH") {
				$("#id_proveedor_edit").val("3");
			} else {

				$("#id_proveedor_edit").val(value5);
			}
			$("#idProdcuto_edit").val(id_producto);
		});



		/*Cargar al modal eliminar*/
		$(document).on('click', "a[id^=producto]", function() {
			var id_producto = $(this).data("id_producto");
			var nombre_producto = $(this).data("nombre_producto");
			$("#idProducto_eliminar").val(id_producto);
			$("#elimin_producto").text(nombre_producto);
		});


		function cargarUltimoIdModulo() {
			$.ajax({
				url: '../controller/ModuloController.php',
				type: 'POST',
				data: {
					action: 'obtenerUltimoIdModulo'
				},
				success: function(response) {

					var ultimoId = parseInt(response);

					$('#id').val(ultimoId);
				},
				error: function(xhr, status, error) {

					console.log(error);
				}
			});
		}
		$(document).ready(function() {

			$("#docente").autocomplete({
					source: function(request, response) {

						$.ajax({
							url: "../../controller/ProfesorController.php",
							dataType: "json",
							data: {
								term: request.term
							},
							success: function(data) {
								response(data);
							}
						});
					},
					minLength: 2,
					select: function(event, ui) {
						$("#docente").val(ui.item.label);
						$("#docente_id").val(ui.item.value);
						return false;
					}
				})
				.autocomplete("option", "appendTo", ".card-body");
		});

		document.getElementById("btnConfirmar").addEventListener("click", function() {

			Swal.fire({
				title: 'Estas seguro de eliminar este usuario?',
				text: "Este usuario se borrara de la base de datos",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Si, eliminar',
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire(
						'Eliminado!',
						'Este usuario a sido eliminado.',
						'success'
					)
				}
			})
		});
	</script>
	<script>
		$(document).ready(function() {

			$('.qrCode').each(function(index, element) {
				var codigo = $(this).closest('tr').find('td:first-child').text();
				generarQRCode(element, codigo);
			});
		});

		function agregarFila() {
			var codigo = document.getElementById("codigo").value;
			var nombre = document.getElementById("nombre").value;

			var tabla = document.getElementById("table");
			var fila = tabla.insertRow();

			var celdaCodigo = fila.insertCell();
			var celdaCodigoQR = fila.insertCell();
			var celdaNombre = fila.insertCell();

			celdaCodigo.innerHTML = codigo;
			celdaCodigoQR.innerHTML = '<div class="qrCode"></div>';
			celdaNombre.innerHTML = nombre;

			generarQRCode(celdaCodigoQR.firstChild, codigo);
		}

		function generarQRCode(elemento, codigo) {
			var qrCode = new QRCode(elemento, {
				text: codigo,
				width: 58,
				height: 58
			});
		}
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