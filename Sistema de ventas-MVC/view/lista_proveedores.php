<?php
require_once '../controller/ProveedorController.php';

$controllerProve = new ProveedorController();
$listaproveedores = $controllerProve->listarCliente();
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

    <title>Proveedores</title>
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
                    <li><a class="active" href="lista_proveedores.php">proveedores</a></li>
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
                            <h5 class="modal-title">Agregar Proveedor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <form action="../controller/ProveedorController.php" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label col-form-label-sm">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" name="nombre_proveedor" id="nombre_proveedor" placeholder="Ingrese nombre del proveedor" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label col-form-label-sm">direccion</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese direccion del proveedor" name="direccion" id="direccion">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label col-form-label-sm">telefono</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese telefono del proveedor" name="telefono" id="telefono">
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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Proveedores</a></li>
                </ol>
            </div>


            <br>
            <div class="card">

                <div class="card-body">

                    <button type="button" class="btn btn-rounded btn-info" data-bs-toggle="modal" data-bs-target="#basicModal"><span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                        </span>Nuevo Proveedor</button>


                    <br><br>
                    <div class="table-responsive">

                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Direccion</th>
                                    <th>Telefono</th>

                                    <?php if ($_SESSION['id_rol'] == 1) { ?>
                                        <th>Accion</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($listaproveedores as $item) {
                                ?>
                                    <tr>
                                        <td><?php echo $item["nombre_proveedor"]; ?></td>
                                        <td><?php echo $item["direccion"]; ?></td>
                                        <td><?php echo $item["telefono"]; ?></td>



                                        <?php if ($_SESSION['id_rol'] == 1) { ?>
                                            <td>
                                                <a href="frm_editar" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#edit_modal" id="proveedor<?php echo $item["id_proveedor"]; ?>" data-id_proveedor="<?php echo $item["id_proveedor"]; ?>">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                <a href="frmD_eliminar" class="btn btn-danger shadow btn-xs sharp btn" data-bs-toggle="modal" data-bs-target="#eliminar_modal" id="proveedor<?php echo $item["id_proveedor"]; ?>" data-id_proveedor="<?php echo $item["id_proveedor"]; ?>" data-nombre_proveedor="<?php echo $item["nombre_proveedor"]; ?>">
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
                            <h5 class="modal-title">Editar Proveedor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <form action="../controller/ProveedorController.php" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="modal-body">

                                <div class="mb-3 row" style="display: none;">
                                    <label class="col-sm-2 col-form-label col-form-label-sm">ID</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" name="id_proveedor_edit" id="id_proveedor_edit" placeholder="Ingrese id" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label col-form-label-sm">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" name="nombre_proveedor_edit" id="nombre_proveedor_edit" placeholder="Ingrese el nuevo nombre" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label col-form-label-sm">direccion</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese la nueva direccion" name="direccion_edit" id="direccion_edit">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label col-form-label-sm">telefono</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese nuevo telefono" name="telefono_edit" id="telefono_edit">
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
                            <h5 class="modal-title">Eliminar proveedor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <form action="../controller/ProveedorController.php" method="post" autocomplete="off">
                            <div class="modal-body">
                                <div class="mb-3 row ">

                                    <div class="col-sm-10" style="display: none;">
                                        <input type="text" class="form-control form-control-sm" name="id_proveedor_eliminar" id="id_proveedor_eliminar" placeholder="idProducto_eliminar" required>
                                    </div>
                                    <h3>Estas seguro de querer eliminar a <span id="elimin_proveedor"></span></h3>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary " data-bs-dismiss="modal">Cerrar</button>
                                <button class="btn btn-danger light" name="id_eliminar_prove" id="id_eliminar_prove">Eliminar</button>
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

    <!-- -->
    <script>
        /*Cargar al modal editar modulo*/

        $(document).on('click', "a[id^=proveedor]", function() {
            var id_proveedor = $(this).data("id_proveedor");

            value1 = $(this).closest('tr').find('td:eq(0)').text();
            value2 = $(this).closest('tr').find('td:eq(1)').text();
            value3 = $(this).closest('tr').find('td:eq(2)').text();


            $("#nombre_proveedor_edit").val(value1);
            $("#direccion_edit").val(value2);
            $("#telefono_edit").val(value3);


            // Verificar el valor del rol y establecer el valor en el select

            $("#id_proveedor_edit").val(id_proveedor);
        });



        /*Cargar al modal eliminar*/
        $(document).on('click', "a[id^=proveedor]", function() {
            var id_proveedor = $(this).data("id_proveedor");
            var nombre_proveedor = $(this).data("nombre_proveedor");
            $("#id_proveedor_eliminar").val(id_proveedor);
            $("#elimin_proveedor").text(nombre_proveedor);
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
                    // Manejar los errores de la solicitud AJAX
                    console.log(error);
                }
            });
        }
        $(document).ready(function() {
            // Configurar el autocompletar en el campo "Seleccionar Docente"
            $("#docente").autocomplete({
                    source: function(request, response) {
                        // Hacer una solicitud AJAX para obtener los datos de los profesores
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
                    minLength: 2, // Número mínimo de caracteres antes de mostrar los resultados
                    select: function(event, ui) {
                        $("#docente").val(ui.item.label);
                        $("#docente_id").val(ui.item.value);
                        return false;
                    }
                })
                .autocomplete("option", "appendTo", ".card-body");
        });

        document.getElementById("btnConfirmar").addEventListener("click", function() {
            // Utiliza SweetAlert para mostrar un mensaje de confirmación
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