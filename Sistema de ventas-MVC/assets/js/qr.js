const contenedorQR = document.getElementById('contenedorQR');
const formulario = document.getElementById('formulario');

const QR = new QRCode(contenedorQR);




QR.makeCode(formulario.link.value);