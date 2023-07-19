function print_empleados(id_tabla) {
    limpiar_tabla(id_tabla);
    let nombre = ['Luis']
    let Apellido = ['Luis']
    let basico = [5000]
    let descuento = [600]
    let bono = [250]
    let mitabla = document.getElementById(id_tabla);

    for (let i = 0; i < nombre.length; i++) {
        let nueva_fila = mitabla.insertRow(-1);

        let celda1 = nueva_fila.insertCell(0);
        let celda2 = nueva_fila.insertCell(1);
        let celda3 = nueva_fila.insertCell(2);
        let celda4 = nueva_fila.insertCell(3);
        let celda5 = nueva_fila.insertCell(4);

        celda1.innerHTML = nombre[i];
        celda2.innerHTML = Apellido[i];
        celda3.innerHTML = basico[i];
        celda4.innerHTML = descuento[i];
        celda5.innerHTML = bono[i];

    }

}



function limpiar_tabla(gsd) {
    let tabla = document.getElementById(gsd);

    for (let i = tabla.rows.length - 1; i > 0; i--) {
        tabla.deleteRow(i);
    }
}
//gaaaa 2 
function suma_producto(ar1, ar2) {
    let sum_prod = 0.0;
    for (let i = 0; i < ar1.length; i++) {
        sum_prod += ar1[i] * ar2[i];

    }
    return sum_prod;
}

function suma_array(arr) {
    let sum_aee = 0.0;
    for (let i = 0; i < arr.length; i++) {
        sum_aee += arr[i];

    }
    return sum_aee;
}

function propom(notas, creditos) {
    let prom;
    prom = suma_producto(notas, creditos) / suma_array(creditos)
    return prom;
}

function imprimir() {
    let nota = [15, 11, 14, 15, 12, 11];
    let credito = [2, 3, 3, 4, 2, 1];
    document.write('Tu promedio es: ' + propom(nota, credito));
}