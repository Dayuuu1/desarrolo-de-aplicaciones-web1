/*Cargar al modal editar modulo*/

$(document).on('click', "a[id^=usuario]", function() {
  var idUsuario = $(this).data("id_usuario");
  var imagen_url = $(this).data("imagen");
  var contra = $(this).data("contra");
  value1 = $(this).closest('tr').find('td:eq(1)').text();
  value2 = $(this).closest('tr').find('td:eq(2)').text();
  value3 = $(this).closest('tr').find('td:eq(3)').text();

  $("#nombre_edit").val(value1);
  $("#correo_edit").val(value2);

  // Verificar el valor del rol y establecer el valor en el select
  if (value3 === "Administrador") {
      $("#rol_edit").val("1");
  } else if (value3 === "Vendedor") {
      $("#rol_edit").val("2");
  } else {
      // Si no es ni "Rol 1" ni "Rol 2", simplemente establecer el valor obtenido.
      $("#rol_edit").val(value3);
  }
  $("#id_edit").val(idUsuario);
  $("#img_no").val(imagen_url);
  $("#contra_edit").val(contra);
});


/*Cargar al modal eliminar*/
$(document).on('click', "a[id^=usuario]", function() {
    var idUsuario = $(this).data("id_usuario");
    var nombre = $(this).data("nombre_usuario");
    $("#idUsaurio_eliminar").val(idUsuario);
    $("#elimin_usuario").text(nombre);
  });


function cargarUltimoIdModulo() {
  $.ajax({
    url: '../controller/ModuloController.php',
    type: 'POST',
    data: { action: 'obtenerUltimoIdModulo' },
    success: function (response) {

      var ultimoId = parseInt(response);

      $('#id').val(ultimoId);
    },
    error: function (xhr, status, error) {
      // Manejar los errores de la solicitud AJAX
      console.log(error);
    }
  });
}
$(document).ready(function () {
  // Configurar el autocompletar en el campo "Seleccionar Docente"
  $("#docente").autocomplete({
    source: function (request, response) {
      // Hacer una solicitud AJAX para obtener los datos de los profesores
      $.ajax({
        url: "../../controller/ProfesorController.php",
        dataType: "json",
        data: {
          term: request.term
        },
        success: function (data) {
          response(data);
        }
      });
    },
    minLength: 2, // Número mínimo de caracteres antes de mostrar los resultados
    select: function (event, ui) {
      $("#docente").val(ui.item.label);
      $("#docente_id").val(ui.item.value);
      return false;
    }
  })
    .autocomplete("option", "appendTo", ".card-body");
});

document.getElementById("btnConfirmar").addEventListener("click", function () {
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