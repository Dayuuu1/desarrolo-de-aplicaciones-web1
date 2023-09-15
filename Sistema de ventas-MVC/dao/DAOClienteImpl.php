<?php

require_once 'IDAOCliente.php';
require_once '../model/Clientes.php';

class DAOClienteImpl implements IDAOCliente
{

    public function insertar(Cliente $objCliente)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "INSERT INTO cliente (dni, nombre_cliente, direccion, telefono) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($stringSQL);

            $dni = $objCliente->getDni();
            $nombre_cliente = $objCliente->getNombre_cliente();
            $direccion = $objCliente->getDireccion();
            $telefono = $objCliente->getTelefono();


            $stmt->bindParam(1, $dni, PDO::PARAM_INT);
            $stmt->bindParam(2, $nombre_cliente, PDO::PARAM_STR);
            $stmt->bindParam(3, $direccion, PDO::PARAM_STR);
            $stmt->bindParam(4, $telefono, PDO::PARAM_STR);



            $stmt->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }
    //editando
    public function eliminar(Cliente $objCliente)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "DELETE FROM cliente WHERE id_cliente = ?";
            $stmt = $con->prepare($stringSQL);

            $id_cliente = $objCliente->getIdCliente();

            $stmt->bindParam(1, $id_cliente, PDO::PARAM_INT);

            $filas = $stmt->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }

    public function modificar(Cliente $objCliente)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "UPDATE cliente SET dni = ?, nombre_cliente = ?, direccion = ?, telefono = ? WHERE id_cliente = ?";
            $stmt = $con->prepare($stringSQL);

            $dni = $objCliente->getDni();
            $nombre_cliente = $objCliente->getNombre_cliente();
            $direccion = $objCliente->getDireccion();
            $telefono = $objCliente->getTelefono();
            $id_cliente = $objCliente->getIdCliente();


            $stmt->bindParam(1, $dni, PDO::PARAM_INT);
            $stmt->bindParam(2, $nombre_cliente, PDO::PARAM_STR);
            $stmt->bindParam(3, $direccion, PDO::PARAM_STR);
            $stmt->bindParam(4, $telefono, PDO::PARAM_STR);
            $stmt->bindParam(5, $id_cliente, PDO::PARAM_INT);


            $stmt->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }
    public function listar()
    {
        $listaClientes = [];
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT * FROM cliente";
            $stmt = $con->prepare($stringSQL);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $listaClientes[] = $row;
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $listaClientes;
    }

    public function obtenerCliente($term)
    {
        $listaClientes = [];
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT * FROM cliente WHERE CONCAT(dni, ' ', nombre_cliente) LIKE :term";
            $stmt = $con->prepare($stringSQL);
            $stmt->bindValue(':term', '%' . $term . '%', PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $id_cliente = $row['id_cliente'];
                $dni = $row['dni'];
                $nombre_cliente = $row['nombre_cliente'];
                $direccion = $row['direccion'];
                $telefono = $row['telefono'];

                $objCliente = new Cliente($id_cliente, $dni, $nombre_cliente, $direccion, $telefono);
                $listaClientes[] = $objCliente;
              
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $listaClientes;
    }

    public function obtenerUltimoIdCliente()
    {
        $ultimoId = null;
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT MAX(id_cliente) AS ultimoId FROM cliente";
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
    public function total()
    {
        $totalClientes = 0;

        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT COUNT(*) as total FROM cliente"; 
            $stmt = $con->prepare($stringSQL);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC); 

            if ($result && isset($result['total'])) {
                $totalClientes = $result['total'];
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $totalClientes;
    }
}
