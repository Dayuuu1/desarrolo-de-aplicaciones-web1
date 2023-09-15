<?php

//total de usuarios
require_once '../controller/UsuarioController.php';
$totalU = new UsuarioController();
$totalUsuarios = $totalU->totaUsuarios();
//total de ventas
require_once '../controller/DetalleFacturaController.php';
$totalb = new DetalleFacturaController();
$totalBole = $totalb->totaB();

//total de productos
require_once '../controller/ProductoController.php';
$totalP = new ProductoController();
$totalProdcutos = $totalP->totaProductos();
//total de clientes
require_once '../controller/ClienteController.php';
$totalC = new ClienteController();
$totalClientes = $totalC->totaClientes();
//para ver si inicio sesion
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
	<link rel="stylesheet" href="../assets/js/vendor/jquery-nice-select/css/nice-select.css">
	<link rel="stylesheet" href="../assets/css/tablas/stylet.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
	<title>Panel</title>
</head>

<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="index.php" class="brand card-title"><i class='bx bxs-smile icon'></i> Hi, <?php echo $_SESSION['nombre']; ?></a>
		<ul class="side-menu">
			<li><a href="index.php" class="active"><i class='bx bxs-dashboard icon'></i> Panel</a></li>
			<li class="divider" data-text="Principal">Principal</li>
			<li>
				<a href="#"><i class='bx bxs-inbox icon'></i> Listar <i class='bx bx-chevron-right icon-right'></i></a>
				<ul class="side-dropdown">
					<li><a href="lista_usuarios.php">Usuarios</a></li>
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
			<div class="row page-titles">

				<ol class="breadcrumb">

					<li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
					<li class="breadcrumb-item"><a href="javascript:void(0)">Panel</a></li>
				</ol>
			</div>
			<div class="info-data">
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $totalClientes; ?></h2>
							<p>Clientes</p>
						</div>
						<i class='bx bx-trending-up icon'></i>
					</div>
					<span class="progress" data-value="1%"></span>
					<span class="label">1%</span>
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $totalBole; ?></h2>
							<p>Ventas</p>
						</div>
						<i class='bx bx-trending-up icon '></i>
					</div>
					<span class="progress" data-value="2%"></span>
					<span class="label">2%</span>
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $totalProdcutos; ?></h2>
							<p>Productos</p>
						</div>
						<i class='bx bx-trending-up icon'></i>
					</div>
					<span class="progress" data-value="1%"></span>
					<span class="label">1%</span>
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $totalUsuarios; ?></h2>
							<p>Usuarios</p>
						</div>
						<i class='bx bx-trending-up icon'></i>
					</div>
					<span class="progress" data-value="3%"></span>
					<span class="label">3%</span>
				</div>
			</div>
			<div class="data">
				<div class="content-data">
					<!--en proceso-->
					<div class="head">
						<h3>Reporte de ventas por cliente</h3>
						<div class="menu">
							<i class='bx bx-dots-horizontal-rounded icon'></i>
							<ul class="menu-link">
								<li><a href="#">Editar</a></li>
								<li><a href="#">Guardar</a></li>
								<li><a href="#">Eliminar</a></li>
							</ul>
						</div>
					</div>
					<div class="chart">
						<div id="chart"></div>
					</div>
				</div>
				<!--en proceso-->
				<div class="content-data">
					<div class="head">
						<h3>chat</h3>
						<div class="menu">
							<i class='bx bx-dots-horizontal-rounded icon'></i>
							<ul class="menu-link">
								<li><a href="#">editar</a></li>
								<li><a href="#">guardar</a></li>
								<li><a href="#">borrar</a></li>
							</ul>
						</div>
					</div>
					<div class="chat-box" id="chatBox">
						<p class="day"><span>Hoy</span></p>
						<div class="msg">
							<img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
							<div class="chat">
								<div class="profile">
									<span class="username">Holger</span>
									<span class="time">18:11</span>
								</div>
								<p>Hola, quiero pedir permiso para no <br>laborar mañana.</p>
							</div>
						</div>
						<div class="msg me">
							<div class="chat">
								<div class="profile">
									<span class="time">18:17</span>
								</div>
								<p>Digame el motivo de su permiso.</p>
							</div>
						</div>
						<div class="msg">
							<img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
							<div class="chat">
								<div class="profile">
									<span class="username">Holger</span>
									<span class="time">18:18</span>
								</div>
								<p>Un familiar se encuentra mal de<br>salud.</p>
							</div>
						</div>
						<div class="msg me">
							<div class="chat">
								<div class="profile">
									<span class="time">18:20</span>
								</div>
								<p>Presentese en la oficina mas tarde.</p>
							</div>
						</div>
						<div class="msg">
							<img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
							<div class="chat">
								<div class="profile">
									<span class="username">Holger</span>
									<span class="time">18:21</span>
								</div>
								<p>ok.</p>
							</div>
						</div>
					</div>
					<form action="#" id="messageForm">
						<div class="form-group">
							<input type="text" id="messageInput" placeholder="Type...">
							<button type="submit" class="btn-send"><i class='bx bxs-send'></i></button>
						</div>
					</form>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../assets/js/script.js"></script>
	<script>
		// Obtener referencia a los elementos relevantes del DOM
		const chatBox = document.getElementById('chatBox');
		const messageForm = document.getElementById('messageForm');
		const messageInput = document.getElementById('messageInput');

		// Manejar el evento de envío del formulario
		messageForm.addEventListener('submit', function(event) {
			event.preventDefault(); // Evitar que el formulario se envíe y recargue la página

			const message = messageInput.value.trim(); // Obtener el mensaje ingresado, eliminando espacios en blanco al inicio y al final

			if (message !== '') {
				// Crear un nuevo elemento de mensaje
				const newMessageElement = document.createElement('div');
				newMessageElement.classList.add('msg', 'me');
				newMessageElement.innerHTML = `
                <div class="chat">
                    <div class="profile">
                        <span class="time">${getCurrentTime()}</span>
                    </div>
                    <p>${message}</p>
                </div>
            `;

				// Agregar el nuevo elemento de mensaje al chatBox
				chatBox.appendChild(newMessageElement);

				// Limpiar el campo de entrada de texto
				messageInput.value = '';

				// Hacer scroll hacia abajo
				chatBox.scrollTop = chatBox.scrollHeight;
			}
		});

		// Función para obtener la hora actual (formato HH:mm)
		function getCurrentTime() {
			const now = new Date();
			const hours = String(now.getHours()).padStart(2, '0');
			const minutes = String(now.getMinutes()).padStart(2, '0');
			return `${hours}:${minutes}`;
		}
	</script>
</body>

</html>