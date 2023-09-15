<?php
require_once '../controller/DetalleFacturaController.php';
$totalB = new DetalleFacturaController();
$totalBoletas = $totalB->totaBoletas();

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
    <link rel="stylesheet" href="../assets/js/vendor/jquery-nice-select/css/nice-select.css">
    <link rel="stylesheet" href="../assets/css/tablas/stylet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <title>Nueva venta</title>
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
                    <li><a href="lista_productos.php">Productos</a></li>
                    <li><a href="lista_clientes.php">Clientes</a></li>
                    <li><a href="lista_proveedores.php">proveedores</a></li>
                    <li><a href="lista_ventas.php">ventas</a></li>
                </ul>
            </li>
            <li><a href="venta.php" class="active"><i class='bx bxs-cart-alt icon'></i> Nueva venta</a></li>
            <li class="divider" data-text="Estadisticas de Tablas">Estadisticas de Tablas</li>
            <!--<li><a href="#"><i class='bx bx-table icon'></i> ventas</a></li>-->
            <li><a href="ganancias.php"><i class='bx bx-table icon'></i> Ganancias</a></li>
        </ul>
        <video id="preview" style="width: 300px;"></video>
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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Nueva Venta</a></li>
                </ol>
            </div>


            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Datos del cliente</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">

                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="me-sm-2">Dni</label>
                                    <input type="text" id="dni_cliente" name="dni_cliente" class="form-control" placeholder="dni">
                                </div>
                                <div class="col-sm-3" style="display: none;">
                                    <label class="me-sm-2">ID</label>
                                    <input type="text" id="id_cliente" name="id_cliente" class="form-control" placeholder="id">
                                </div>
                                <div class="col-sm-3 mt-2 mt-sm-0">
                                    <label class="me-sm-2">Nombre</label>
                                    <input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control blockquote" placeholder="nombre" disabled>
                                </div>
                                <div class="col-sm-3">
                                    <label class="me-sm-2">Telefono</label>
                                    <input type="text" id="telefono_cliente" name="telefono_cliente" class="form-control" placeholder="telefono" disabled>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Datos del producto</h4>
                        <button type="button" onclick="startScanner()" class="btn btn-instagram btn-xxs">Escáner <span class="btn-icon-end"><i class="fab fa-instagram"></i></span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <div class="row">

                                <div class="col-md-3">
                                    <label class="me-sm-2">Codigo</label>
                                    <input type="text" id="codigo_producto" name="codigo_producto" class="form-control" placeholder="codigo" require>
                                </div>
                                <div class="col-md-3 d-none">
                                    <label class="me-sm-2">ID</label>
                                    <input type="text" id="id_producto" name="id_producto" class="form-control" placeholder="id">
                                </div>
                                <div class="col-md-3 mt-2 mt-md-0">
                                    <label class="me-sm-2">Nombre</label>
                                    <input type="text" id="nombre_producto" name="nombre_producto" class="form-control blockquote" placeholder="nombre" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label class="me-sm-2">Stock</label>
                                    <input type="text" id="stock_producto" name="stock_producto" class="form-control" placeholder="stock" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label class="me-sm-2">Precio</label>
                                    <input type="text" id="precio_producto" name="precio_producto" class="form-control" placeholder="precio" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label class="me-sm-2">Cantidad</label>
                                    <input type="text" id="cantidad_producto" name="cantidad_producto" class="form-control" placeholder="cantidad">
                                    <br><br>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="button" id="asignarbtn" onclick="verificarYAsignar()" class="btn btn-rounded btn-info">
                                        <span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i></span>Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Datos de venta</h4>
                    </div>
                    <div class="card-body">
                        <form action="../controller/DetalleFacturaController.php" method="post" onsubmit="return verificarVenta()">
                            <div class="col-sm-3" style="display: none;">
                                <input type="text" id="resultado" name="resultado" class="form-control">
                                <input type="text" id="total_venta" name="total_venta" class="form-control">
                                <input type="text" id="cliente_id" name="cliente_id" class="form-control">
                                <input type="text" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>" class="form-control">
                                <input type="text" id="boletat" name="boletat" value="<?php echo $totalBoletas; ?>" class="form-control">
                            </div>

                            <button class="btn btn-rounded btn-success" id="guardar" name="guardar" onclick="verificarVenta()"><span class="btn-icon-start text-success"><i class="fa fa-download color-warning"></i>
                                </span>Generar venta</button>


                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped table-responsive-sm" id="tablaSuma">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>nombre</th>
                                        <th>precio</th>
                                        <th>cantidad</th>
                                        <th>total</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaResultados">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Total:</td>
                                        <td id="resultadoVenta" colspan="n">0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <!-- MAIN -->
    </section>

    <!-- del boostrap del docente-->
    <script type="text/javascript" src="../assets/js/jquery-3.7.0.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/instascan.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //esitar
        // buscar Cliente
        $(document).ready(function() {
            function limpiarCampos() {
                $("#nombre_cliente").val('');
                $("#id_cliente").val('');
                $("#telefono_cliente").val('');
            }

            // Configurar el autocompletar en el campo "Seleccionar Docente"
            $("#dni_cliente").on("input", function() {
                var dni = $(this).val();

                // Verificar si el DNI ingresado tiene menos de 8 caracteres
                if (dni.length < 8) {
                    limpiarCampos();
                } else if (dni.length === 8) {
                    // Hacer una solicitud AJAX para obtener los datos del cliente
                    $.ajax({
                        url: "../controller/ClienteController.php",
                        dataType: "json",
                        data: {
                            term: dni
                        },
                        success: function(data) {
                            if (data && data.length > 0) {
                                var cliente = data[0];
                                $("#nombre_cliente").val(cliente.nombre);
                                $("#id_cliente").val(cliente.id);
                                $("#telefono_cliente").val(cliente.telefono);
                            }
                        }
                    });
                }
            });
        });
        var scanner;

        // Inicializar el escáner de códigos QR
        scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });

        // Obtener información del producto al escanear un código QR
        scanner.addListener('scan', function(codigo) {
            document.getElementById('codigo_producto').value = codigo;
            buscarInformacionProducto(codigo);

            // Agregar un retraso de medio segundo antes de hacer clic en el botón
            setTimeout(function() {
                var miBoton = document.getElementById('asignarbtn');
                miBoton.click();
            }, 200);

            var audio = new Audio('../assets/img/noti.mp3');
            audio.play();


        });

        function buscarInformacionProducto(codigo) {
            if (codigo.length < 6) {
                limpiarCampos();
            } else if (codigo.length === 6) {
                var action = 'infoProducto';

                $.ajax({
                    url: "../controller/ProductoController.php",
                    dataType: "json",
                    data: {
                        term: codigo
                    },
                    success: function(data) {
                        if (data && data.length > 0) {
                            var producto = data[0];
                            $("#nombre_producto").val(producto.nombre);
                            $("#id_producto").val(producto.idp);
                            $("#stock_producto").val(producto.stock);
                            $("#precio_producto").val(producto.precio);
                            $("#cantidad_producto").val(1);
                        }
                    },
                    error: function(error) {
                        // Manejar el error aquí si es necesario
                    }
                });
            }
        }

        function limpiarCampos() {
            $("#nombre_producto").val('');
            $("#id_producto").val('');
            $("#stock_producto").val('');
            $("#precio_producto").val('');
            $("#cantidad_producto").val('');
        }

        function startScanner() {
            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No se encontraron cámaras en el dispositivo.');
                }
            });
        }

        // Agregar un controlador de eventos para el evento "input" del campo #codigo_producto
        $("#codigo_producto").on("input", function() {
            var codigo = $(this).val();
            buscarInformacionProducto(codigo);
        });
    </script>
    <script>
        function verificarYAsignar() {
            var codigoInput = document.getElementById("codigo_producto");

            if (codigoInput.value.trim() === "") {
                // Utiliza SweetAlert para mostrar el mensaje de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, elija un producto antes de agregar al carito.',
                });
            } else {
                asignar();
            }
        }

        function asignar() {
            // Tu función asignar() original o el código para asignar el valor del campo de código.
        }
        var datosGuardados = [];

        function asignar() {
            // Obtener los valores de los campos del formulario
            var codigo_producto = document.getElementById("codigo_producto").value;
            var nombre_producto = document.getElementById("nombre_producto").value;
            var id_producto = document.getElementById("id_producto").value;
            var id_cliente = document.getElementById("id_cliente").value;
            var precio_producto = document.getElementById("precio_producto").value;
            var cantidad_producto = document.getElementById("cantidad_producto").value;
            document.getElementById("cliente_id").value = id_cliente;


            // Crear una nueva fila en la tabla
            var table = document.getElementById("tablaResultados");
            var newRow = table.insertRow(table.rows.length);

            // Insertar las celdas con los valores obtenidos
            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);

            var total = precio_producto * cantidad_producto;

            cell1.innerHTML = codigo_producto;
            cell2.innerHTML = nombre_producto;
            cell3.innerHTML = precio_producto;
            cell4.innerHTML = cantidad_producto;
            cell5.innerHTML = total;


            datosGuardados += id_cliente + "," + id_producto + "," + cantidad_producto + "," + total + ";";
            mostrarDatosGuardados();

            document.getElementById("codigo_producto").value = "";
            document.getElementById("nombre_producto").value = "";
            document.getElementById("id_producto").value = "";
            document.getElementById("precio_producto").value = "";
            document.getElementById("cantidad_producto").value = "";
            document.getElementById("stock_producto").value = "";


        }

        function mostrarDatosGuardados() {
            document.getElementById("resultado").value = datosGuardados; // Mostrar los datos guardados en el elemento de salida
        }
    </script>
    <script>
        function sumarQuintaColumna() {
            var tabla = document.getElementById("tablaSuma");
            var columna = 4; // Índice de la quinta columna (comienza desde 0)

            var suma = 0;

            for (var i = 0; i < tabla.rows.length - 1; i++) {
                var fila = tabla.rows[i];
                var celda = fila.cells[columna];

                var valor = parseFloat(celda.innerText);
                if (!isNaN(valor)) {
                    suma += valor;
                }
            }

            var resultadoTd = document.getElementById("resultadoVenta");

            document.getElementById("total_venta").value = suma.toFixed(2);
            resultadoTd.textContent = suma.toFixed(2); // Mostrar la suma con dos decimales
        }

        // Llamamos a la función para calcular la suma inicialmente
        sumarQuintaColumna();

        // Creamos el observador para detectar cambios en la tabla y recalcular la suma
        var observer = new MutationObserver(function() {
            sumarQuintaColumna();
        });

        var config = {
            childList: true,
            subtree: true
        };
        var targetNode = document.getElementById("tablaResultados");
        observer.observe(targetNode, config);



        function verificarVenta() {
            // Obtener el tbody de la tabla
            var tbody = document.getElementById("tablaResultados");
            var dni_cliente = document.getElementById("dni_cliente");

            if (dni_cliente.value.trim() === "") {
                // Utiliza SweetAlert para mostrar el mensaje de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, ingrese un cliente.',
                });
                return false;
            }
            // Verificar si hay al menos una fila en el tbody
            if (tbody.getElementsByTagName("tr").length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debe agregar al menos un dato en el carrito antes de generar la venta.',
                });
                return false; // Bloquear el envío del formulario
            }

            // Si hay datos en la tabla, permitir el envío del formulario
            return true;
        }
    </script>

    <?php
    
    if (isset($_SESSION['success_message'])) {
        echo '<script type="text/javascript">';
        echo "Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: '{$_SESSION['success_message']}'
		});";
        echo '</script>';
        unset($_SESSION['success_message']);
    }
    ?>

</body>

</html>