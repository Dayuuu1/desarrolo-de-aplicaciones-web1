<?php

require_once 'IDAOProducto.php';
require_once '../model/Productos.php';

class DAOProductoImpl implements IDAOProducto
{

    public function insertar(Producto $objProducto)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "INSERT INTO productos (codigo, nombre_producto, stock, precio_unitario, id_proveedor) VALUES (?, ?, ?, ?, ?)";
            $stmt = $con->prepare($stringSQL);

            $codigo = $objProducto->getCodigo();
            $nombre_producto = $objProducto->getNombre_producto();
            $stock = $objProducto->getStock();
            $precio_unitario = $objProducto->getPrecio_unitario();
            $id_proveedor = $objProducto->getId_proveedor();

            $stmt->bindParam(1, $codigo, PDO::PARAM_INT);
            $stmt->bindParam(2, $nombre_producto, PDO::PARAM_STR);
            $stmt->bindParam(3, $stock, PDO::PARAM_INT);
            $stmt->bindParam(4, $precio_unitario, PDO::PARAM_INT);
            $stmt->bindParam(5, $id_proveedor, PDO::PARAM_INT);


            $stmt->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }
    //editando
    public function eliminar(Producto $objProducto)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "DELETE FROM productos WHERE id_producto = ?";
            $stmt = $con->prepare($stringSQL);

            $id_producto = $objProducto->getIdProdcuto();

            $stmt->bindParam(1, $id_producto, PDO::PARAM_INT);

            $filas = $stmt->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }

    public function modificar(Producto $objProducto)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "UPDATE productos SET codigo = ?, nombre_producto = ?, stock = ?, precio_unitario = ?, id_proveedor = ? WHERE id_producto = ?";
            $stmt = $con->prepare($stringSQL);

            $codigo = $objProducto->getCodigo();
            $nombre_producto = $objProducto->getNombre_producto();
            $stock = $objProducto->getStock();
            $precio_unitario = $objProducto->getPrecio_unitario();
            $id_proveedor = $objProducto->getId_proveedor();
            $id_producto = $objProducto->getIdProdcuto();

            $stmt->bindParam(1, $codigo, PDO::PARAM_INT);
            $stmt->bindParam(2, $nombre_producto, PDO::PARAM_STR);
            $stmt->bindParam(3, $stock, PDO::PARAM_INT);
            $stmt->bindParam(4, $precio_unitario, PDO::PARAM_STR);
            $stmt->bindParam(5, $id_proveedor, PDO::PARAM_INT);
            $stmt->bindParam(6, $id_producto, PDO::PARAM_INT);


            $stmt->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }
    public function listar()
    {
        $listaProductos = [];
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT p.codigo, p.id_producto, p.nombre_producto, p.stock, p.precio_unitario, v.nombre_proveedor as nombre_proveedor
            from productos p
            inner join proveedor v on p.id_proveedor = v.id_proveedor;";
            $stmt = $con->prepare($stringSQL);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $listaProductos[] = $row;
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $listaProductos;
    }

    public function obtenerProducto($term)
    {
        $listaProductos = [];
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT * FROM productos WHERE CONCAT(codigo, ' ', nombre_producto) LIKE :term";
            $stmt = $con->prepare($stringSQL);
            $stmt->bindValue(':term', '%' . $term . '%', PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $id_producto = $row['id_producto'];
                $codigo = $row['codigo'];
                $nombre_producto = $row['nombre_producto'];
                $stock = $row['stock'];
                $precio_unitario = $row['precio_unitario'];
                $id_proveedor = $row['id_proveedor'];

                $objProducto = new Producto($id_producto, $codigo, $nombre_producto, $stock, $precio_unitario, $id_proveedor);
                $listaProductos[] = $objProducto;
                
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $listaProductos;
    }

    public function obtenerUltimoIdUsuario()
    {
        $ultimoId = null;
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT MAX(id_producto) AS ultimoId FROM productos";
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
        $totalProductos = 0; 

        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT COUNT(*) as total FROM productos"; 
            $stmt = $con->prepare($stringSQL);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['total'])) {
                $totalProductos = $result['total'];
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $totalProductos;
    }
}
