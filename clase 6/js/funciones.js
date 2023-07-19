/*function prueba() {
    alert("gaaa");
}

function suma(a, b) {
    return a + b;
}

function procesar() {
    let n1, n2, n3;
    let s;


    n1 = document.getElementById("n1").value;
    n1 = parseInt(n1);
    n2 = document.getElementById("n2").value;
    n2 = parseInt(n2);
    n3 = document.getElementById("n3").value;
    n3 = parseInt(n3);
    s = suma(suma(n1, n2), n3);
    document.getElementById("resp").value = s;
    alert("el mayor es:" + mayor(mayor(n1, n2), n3));
}

function mayor(x, y) {
    let may;
    if (x > y) {
        may = x;
    } else {
        may = y;
    }
    return may;
}*/

function calcular_com(venta) {
    let c;
    c = 0;
    if (venta >= 0 && venta <= 200) {
        c = venta * 0.0;
    } else if (venta <= 1000) {
        c = venta * 0.1;
    } else if (venta <= 2000) {
        c = venta * 0.15;
    } else if (venta <= 3000) {
        c = venta * 0.2;
    } else if (venta <= 4000) {
        c = venta * 0.25;
    } else {
        c = venta * 0.4;
    }

    document.write(c);

}