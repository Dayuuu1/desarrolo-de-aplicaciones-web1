<?php

require_once 'IDAOProveedor.php';
require_once '../model/Proveedor.php';

class DAOProveedorImpl implements IDAOProveedor
{

    public function insertar(Proveedor $objProveedor)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "INSERT INTO proveedor (nombre_proveedor, direccion, telefono) VALUES (?, ?, ?)";
            $stmt = $con->prepare($stringSQL);

            $nombre_proveedor = $objProveedor->getNombre_proveedor();
            $direccion = $objProveedor->getDireccion();
            $telefono = $objProveedor->getTelefono();
            
           

            $stmt->bindParam(1, $nombre_proveedor, PDO::PARAM_STR);
            $stmt->bindParam(2, $direccion, PDO::PARAM_STR);
            $stmt->bindParam(3, $telefono, PDO::PARAM_STR);
            
            

            $filas = $stmt->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }
    //editando
    public function eliminar(Proveedor $objProveedor)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "DELETE FROM proveedor WHERE id_proveedor = ?";
            $stmt = $con->prepare($stringSQL);

            $id_proveedor = $objProveedor->getId_proveedor();

            $stmt->bindParam(1, $id_proveedor, PDO::PARAM_INT);

            $filas = $stmt->execute();

   
        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }

    public function modificar(Proveedor $objProveedor)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "UPDATE proveedor SET nombre_proveedor = ?, direccion = ?, telefono = ? WHERE id_proveedor = ?";
            $stmt = $con->prepare($stringSQL);

            $nombre_proveedor = $objProveedor->getNombre_proveedor();
            $direccion = $objProveedor->getDireccion();
            $telefono = $objProveedor->getTelefono();
            $id_proveedor = $objProveedor->getId_proveedor();
            
            

            $stmt->bindParam(1, $nombre_proveedor, PDO::PARAM_STR);
            $stmt->bindParam(2, $direccion, PDO::PARAM_STR);
            $stmt->bindParam(3, $telefono, PDO::PARAM_STR);
            $stmt->bindParam(4, $id_proveedor, PDO::PARAM_INT);
            

            $filas = $stmt->execute();


        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }
    public function listar()
    {
        $listaProveedores = [];
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT * FROM proveedor";
            $stmt = $con->prepare($stringSQL);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $listaProveedores[] = $row;
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $listaProveedores;
    }

    

    public function obtenerUltimoIdProveedor()
    {
        $ultimoId = null;
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT MAX(id_proveedor) AS ultimoId FROM proveedor";
            $stmt = $con->prepare($stringSQL);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result && isset($result['ultimoId'])) {
                $ultimoId = $result['ultimoId'];
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $ultimoId;
    }
    
}
