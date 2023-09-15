<?php
require_once '../model/Productos.php';
interface IDAOProducto{
    
    public function insertar(Producto $objProducto);
    public function eliminar(Producto $objProducto);
    public function modificar(Producto $objProducto);
    public function listar();
    public function total();
    

}