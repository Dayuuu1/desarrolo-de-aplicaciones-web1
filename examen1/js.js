//para listar
function print_empleados() {

    let cod = ['1']
    let nombre = ['Luis']
    let Apellido = ['Quispe']
    let age = [21]
    let type = ['M']
    let puntaje = [700]
    let situacion = ['aprobado']
    let mitabla = document.getElementById("example");

    for (let i = 0; i < nombre.length; i++) {
        let nueva_fila = mitabla.insertRow(-1);

        let celda1 = nueva_fila.insertCell(0);
        let celda2 = nueva_fila.insertCell(1);
        let celda3 = nueva_fila.insertCell(2);
        let celda4 = nueva_fila.insertCell(3);
        let celda5 = nueva_fila.insertCell(4);
        let celda6 = nueva_fila.insertCell(5);
        let celda7 = nueva_fila.insertCell(6);

        celda1.innerHTML = cod[i];
        celda2.innerHTML = nombre[i];
        celda3.innerHTML = Apellido[i];
        celda4.innerHTML = age[i];
        celda5.innerHTML = type[i];
        celda6.innerHTML = puntaje[i];
        celda7.innerHTML = situacion[i];

    }
    document.getElementById("miBoton").disabled = true;

}
var rIndex,
    table = document.getElementById("example");

// check the empty input
function checkEmptyInput() {
    var isEmpty = false,

        nombre = document.getElementById("nombre").value,
        Apellido = document.getElementById("Apellido").value,
        age = document.getElementById("Edad").value;
    puntaje = document.getElementById("puntaje").value;

    if (nombre === "") {
        alert("ingrese un nombre");
        isEmpty = true;
    } else if (Apellido === "") {
        alert("Ingrese un apellido");
        isEmpty = true;
    } else if (age === "") {
        alert("Ingrese la edad");
        isEmpty = true;
    } else if (puntaje === "") {
        alert("ingrese el puntaje");
        isEmpty = true;
    }
    return isEmpty;
}
//*********************************************************
var contador = 1;


//*************************************************************
function addHtmlTableRow() {

    if (!checkEmptyInput()) {
        var newRow = table.insertRow(table.length),
            cell1 = newRow.insertCell(0),
            cell2 = newRow.insertCell(1),
            cell3 = newRow.insertCell(2),
            cell4 = newRow.insertCell(3),
            cell5 = newRow.insertCell(4),
            cell6 = newRow.insertCell(5),
            cell7 = newRow.insertCell(6),

            nombre = document.getElementById("nombre").value,
            Apellido = document.getElementById("Apellido").value,
            age = document.getElementById("Edad").value;
        type = document.getElementById("tipo").value;
        puntaje = document.getElementById("puntaje").value;
        var lista = document.getElementById("example");
        contador++;
        cell1.innerHTML = contador;

        cell2.innerHTML = nombre;
        cell3.innerHTML = Apellido;
        cell4.innerHTML = age;
        cell5.innerHTML = type;
        cell6.innerHTML = puntaje;
        if (puntaje >= 700) {
            cell7.innerHTML = "aprobado";
        } else {
            cell7.innerHTML = "desaprobado";
        }

        selectedRowToInput();

        document.getElementById("nombre").value = "";
        document.getElementById("Apellido").value = "";
        document.getElementById("Edad").value = "";
        document.getElementById("puntaje").value = "";

    }
}
//*********************************
function selectedRowToInput() {

    for (var i = 1; i < table.rows.length; i++) {
        table.rows[i].onclick = function() {

            rIndex = this.rowIndex;

            document.getElementById("nombre").value = this.cells[1].innerHTML;
            document.getElementById("Apellido").value = this.cells[2].innerHTML;
            document.getElementById("Edad").value = this.cells[3].innerHTML;
            document.getElementById("tipo").value = this.cells[4].innerHTML;
            document.getElementById("puntaje").value = this.cells[5].innerHTML;

        };
    }
}
selectedRowToInput();
//*****************************************
function editHtmlTbleSelectedRow() {
    var
        nombre = document.getElementById("nombre").value,
        Apellido = document.getElementById("Apellido").value,
        age = document.getElementById("Edad").value;
    type = document.getElementById("tipo").value;
    puntaje = document.getElementById("puntaje").value;
    if (!checkEmptyInput()) {

        table.rows[rIndex].cells[1].innerHTML = nombre;
        table.rows[rIndex].cells[2].innerHTML = Apellido;
        table.rows[rIndex].cells[3].innerHTML = age;
        table.rows[rIndex].cells[4].innerHTML = type;
        table.rows[rIndex].cells[5].innerHTML = puntaje;
        if (puntaje >= 700) {
            table.rows[rIndex].cells[6].innerHTML = "aprobado";
        } else {
            table.rows[rIndex].cells[6].innerHTML = "desaprobado";
        }

    }
}
//****************************************************************
function removeSelectedRow() {
    table.deleteRow(rIndex);
    document.getElementById("cod").value = "";
    document.getElementById("nombre").value = "";
    document.getElementById("Apellido").value = "";
    document.getElementById("Edad").value = "";
    document.getElementById("type").value = "";
    document.getElementById("puntaje").value = "";

}
//**************************** para que se busque con el boton
/*document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que el formulario se envíe y la página se recargue

    const inputBusqueda = document.getElementById('inputBusqueda').value;
    buscarDato(inputBusqueda);
});*/
//para que se busque automaticamente
document.getElementById('inputBusqueda').addEventListener('input', function() {
    const inputBusqueda = this.value.toLowerCase();
    buscarDato(inputBusqueda);
});

function buscarDato(nombre) {
    const tabla = document.getElementById('example');
    const filas = tabla.getElementsByTagName('tr');

    for (let i = 0; i < filas.length; i++) {
        const celdas = filas[i].getElementsByTagName('td');

        for (let j = 0; j < celdas.length; j++) {
            const contenidoCelda = celdas[j].innerText || celdas[j].textContent;
            const contenidoCeldaFormateado = contenidoCelda.toLowerCase(); // Convertir el contenido de la celda a minúsculas
            if (contenidoCeldaFormateado.includes(nombre)) {
                filas[i].style.display = ''; // Muestra la fila si encuentra una coincidencia
                break;
            } else {
                filas[i].style.display = 'none'; // Oculta la fila si no hay coincidencias
            }
        }
    }
}