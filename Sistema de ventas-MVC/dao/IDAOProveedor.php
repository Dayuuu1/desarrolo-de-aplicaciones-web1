<?php
require_once '../model/Proveedor.php';
interface IDAOProveedor{
    
    public function insertar(Proveedor $objProveedor);
    public function eliminar(Proveedor $objProveedor);
    public function modificar(Proveedor $objProveedor);
    public function listar();

    

}