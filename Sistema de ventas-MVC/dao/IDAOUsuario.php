<?php
require_once '../model/Usuario.php';
interface IDAOUsuario{
    
    public function insertar(Usuario $objUsuario);
    public function eliminar(Usuario $objUsuario);
    public function modificar(Usuario $objUsuario);
    public function listar();
    public function total();
    

}