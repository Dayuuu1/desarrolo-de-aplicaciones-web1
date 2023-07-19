let cursos = ["Desarrollo web", "ing de software", "inverstigacion de operaciones", "metodos numericos", "taller de tesis"];
let unidad = ["Primera unidad", "Segunda unidad", "Tercera unidad"];
$(document).ready(function() {
    cursos.forEach(function(item) {
        $("#curso").append("<option>" + item + "</option>");
    })
});
$(document).ready(function() {
    unidad.forEach(function(item) {
        $("#Unidad").append("<option>" + item + "</option>");
    })

});
$(document).ready(function() {

    $("#procesar").click(function() {
        let nombre = $("#nombre").val();
        let apellido = $("#apellidos").val();
        let conceptual = $("#conceptual").val();
        let procedimental = $("#procedimental").val();
        let actitudinal = $("#actitudinal").val();
        let unidad = $("#Unidad").val();
        let curso = $("#curso").val();

        let promedio = conceptual * 0.5 + procedimental * 0.3 + actitudinal * 0.2;

        $("#respuesta").append("<tr></tr>");
        $("#respuesta tbody tr:last").append("<td>" + "nombre" + "</td>" + "<td>" + nombre + "</td>");
        $("#respuesta").append("<tr></tr>");
        $("#respuesta tbody tr:last").append("<td>" + "apellido" + "</td>" + "<td>" + apellido + "</td>");
        $("#respuesta").append("<tr></tr>");
        $("#respuesta tbody tr:last").append("<td>" + "curso" + "</td>" + "<td>" + curso + "</td>");
        $("#respuesta").append("<tr></tr>");
        $("#respuesta tbody tr:last").append("<td>" + "Unidad" + "</td>" + "<td>" + unidad + "</td>");
        $("#respuesta").append("<tr></tr>");
        $("#respuesta tbody tr:last").append("<td>" + "promedio" + "</td>" + "<td>" + promedio + "</td>");

    })



});