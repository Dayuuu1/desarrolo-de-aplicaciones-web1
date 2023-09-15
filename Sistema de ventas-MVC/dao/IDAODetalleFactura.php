<?php
require_once '../model/DetalleFactura.php';
require_once '../model/boleta.php';
interface IDAODetalleFactura{
    
    public function insertar(DetalleFactura $objDetalleFactura);
    public function insertarBoleta(Boleta $objDetalleFactura);
    public function total_filas_boleta();
    public function listarBoleta();

    

}