function print_empleados(id_tabla){
    limpiar_tabla(id_tabla);
    let nombres=['luis','juan','ana','maria','liz','coren','paris','martin','jose','andres']
    let apellidos=[ 'holgado','huamani','lopez','rios','duran','apaza','garcia','flores','del solar','condori']
    let basico=[5000,	1000,	5200	,3500	,3600,	1800,	5000	,3000	,1800,	4200]
    let descuento=[600,	120	,624,	420	,432,	216	,600	,360,	216,	504]
    let bono=[250,	50	,260,	175	,180,	90,	250,	150,	90,	210]

    let mitabla=document.getElementById(id_tabla);

    for(let i=0; i<nombres.length;i++){
        let nueva_fila=mitabla.insertRow(-1);

        let celda1=nueva_fila.insertCell(0);
        let celda2=nueva_fila.insertCell(1);
        let celda3=nueva_fila.insertCell(2);
        let celda4=nueva_fila.insertCell(3);
        let celda5=nueva_fila.insertCell(4);

        celda1.innerHTML=nombres[i];
        celda2.innerHTML=apellidos[i];
        celda3.innerHTML=basico[i];
        celda4.innerHTML=descuento[i];
        celda5.innerHTML=bono[i];

        if(i % 2 === 0){
            nueva_fila.classList.add('fila-par');
        }else{
            nueva_fila.classList.add('fila-impar');
        }


    }
}

function limpiar_tabla(idTabla){
    let tabla= document.getElementById(idTabla);

    for(let i=tabla.rows.length - 1;i>0;i--){
        tabla.deleteRow(i);
    }
}

/*otros de ejemplos */

function suma_productos(arr_1, arr_2){
    let sum_prod=0.0;

    for(let i=0;i<arr_1.length;i++){
        sum_prod+=arr_1[i]*arr_2[i];
    }
    return sum_prod;
}

function sumar_array(arr){
    let sum_arr=0.0;
    for(let i=0;i<arr.length;i++){
        sum_arr+=arr[i];
    }
    return sum_arr;
}
function prom_ponderado(notas,creditos){
    let prom;
    prom=suma_productos(notas,creditos)/sumar_array(creditos);
    return prom;
}

function imprimir_promedio(){
    let nota=[15,16,14,13,10,8];
    let credito=[3,4,3,3,5,2];
    document.write('Tu promedio es: '+prom_ponderado(nota,credito));
}

