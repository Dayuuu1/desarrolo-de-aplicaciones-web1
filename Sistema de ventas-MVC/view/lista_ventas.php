<?php


require_once '../controller/DetalleFacturaController.php';

$controllerB = new DetalleFacturaController();
$listaboletas = $controllerB->listarBoleta();
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

	<title>Ventas</title>
</head>

<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="index.php" class="brand card-title"><i class='bx bxs-smile icon'></i>Hi, <?php echo $_SESSION['nombre']; ?></a>
		<ul class="side-menu">
			<li><a href="index.php"><i class='bx bxs-dashboard icon'></i> Panel</a></li>
			<li class="divider" data-text="Principal">Principal</li>
			<li>
				<a href="#"><i class='bx bxs-inbox icon'></i> Listar <i class='bx bx-chevron-right icon-right'></i></a>
				<ul class="side-dropdown">
					<li><a href="lista_usuarios.php">Usuarios</a></li>
					<li><a href="lista_productos.php">Productos</a></li>
					<li><a class="active" href="lista_clientes.php">Clientes</a></li>
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




			<div class="row page-titles">

				<ol class="breadcrumb">

					<li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
					<li class="breadcrumb-item"><a href="javascript:void(0)">Ventas</a></li>
				</ol>
			</div>


			<br>
			<div class="card">

				<div class="card-body">

					<a href="venta.php"><button class="btn btn-rounded btn-info" data-bs-toggle="modal" data-bs-target="#basicModal"><span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
							</span>Nueva Venta</button></a>


					<br><br>
					<div class="table-responsive">

						<table id="example3" class="display" style="min-width: 845px">
							<thead>
								<tr>
									<th>Fecha</th>
									<th>Cliente</th>
									<th>Vendedor</th>
									<th>Total</th>
									<th>Ticket</th>

								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($listaboletas as $item) {
								?>
									<tr>
										<td><?php echo $item["fecha"]; ?></td>
										<td><?php echo $item["nombre_cliente"]; ?></td>
										<td><?php echo $item["nombre"]; ?></td>
										<td><?php echo $item["totalBoleta"]; ?></td>
										<td>
											<div class="add">
												<a href="../factura/generaFactura.php?numero_de_boleta=<?php echo $item["id_boleta"]; ?>"><button style="background: none;border:none; color:blue;cursor:pointer;font-size: 20px;" type="button" class="btn btn-primary view_factura"><span class="las la-eye"></span></button></a>
											</div>
										</td>





									</tr>
								<?php
								}
								?>




							</tbody>
						</table>
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

	<!-- -->


</body>

</html>