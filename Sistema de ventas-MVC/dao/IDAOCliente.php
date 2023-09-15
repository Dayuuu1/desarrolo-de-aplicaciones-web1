<?php
require_once '../model/Clientes.php';
interface IDAOCliente{
    
    public function insertar(Cliente $objCliente);
    public function eliminar(Cliente $objCliente);
    public function modificar(Cliente $objCliente);
    public function listar();
    public function total();
    

}