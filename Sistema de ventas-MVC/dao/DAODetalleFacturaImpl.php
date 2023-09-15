<?php
require_once 'DAOUsuarioImpl.php';
require_once 'IDAODetalleFactura.php';
require_once '../model/DetalleFactura.php';
require_once '../model/boleta.php';

class DAODetalleFacturaImpl implements IDAODetalleFactura
{

    public function insertar(DetalleFactura $objDetalleFactura)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "INSERT INTO detalle_boleta (id_boleta, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";

            $id_producto = $objDetalleFactura->getId_producto();
            $cantidad = $objDetalleFactura->getCantidad();

            $stringVerificarStock = "SELECT stock FROM productos WHERE id_producto = ?";
            $stmtVerificarStock = $con->prepare($stringVerificarStock);
            $stmtVerificarStock->bindParam(1, $id_producto, PDO::PARAM_INT);
            $stmtVerificarStock->execute();
            $resultStock = $stmtVerificarStock->fetch(PDO::FETCH_ASSOC);

            if ($resultStock && isset($resultStock['stock']) && $resultStock['stock'] >= $cantidad) {
                $id_boleta = $objDetalleFactura->getId_boleta();
                $precio_unitario = $objDetalleFactura->getPrecio_unitario();

                $stmt = $con->prepare($stringSQL);
                $stmt->bindParam(1, $id_boleta, PDO::PARAM_INT);
                $stmt->bindParam(2, $id_producto, PDO::PARAM_INT);
                $stmt->bindParam(3, $cantidad, PDO::PARAM_INT);
                $stmt->bindParam(4, $precio_unitario, PDO::PARAM_INT);
                $stmt->execute();

                $stringUpdateStock = "UPDATE productos SET stock = stock - ? WHERE id_producto = ?";
                $stmtUpdateStock = $con->prepare($stringUpdateStock);
                $stmtUpdateStock->bindParam(1, $cantidad, PDO::PARAM_INT);
                $stmtUpdateStock->bindParam(2, $id_producto, PDO::PARAM_INT);
                $stmtUpdateStock->execute();
            } else {
                $_SESSION['success_message'] = "Este producto tiene " . $resultStock['stock'] . " en stock.";
                header("location: ../view/venta.php");
                exit;
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }




    public function insertarBoleta(Boleta $objDetalleFactura)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "INSERT INTO boleta (fecha, id_cliente, id_usuario, totalBoleta) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($stringSQL);

            $fecha = $objDetalleFactura->getFecha();
            $id_cliente = $objDetalleFactura->getId_cliente();
            $id_usuario = $objDetalleFactura->getId_usuario();
            $totalBoleta = $objDetalleFactura->getTotalBoleta();


            $stmt->bindParam(1, $fecha, PDO::PARAM_STR);
            $stmt->bindParam(2, $id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(3, $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(4, $totalBoleta, PDO::PARAM_INT);



            $stmt->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }
    public function total_filas_boleta()
    {
        $totalIncrementos = 0;

        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SHOW TABLE STATUS LIKE 'boleta';";
            $stmt = $con->prepare($stringSQL);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['Auto_increment'])) {
                $totalIncrementos = $result['Auto_increment'];
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $totalIncrementos;
    }
    public function listarBoleta()
    {
        $listaBoletas = [];
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT b.id_boleta, b.fecha, c.nombre_cliente, u.nombre, b.totalBoleta
            FROM boleta b
            INNER JOIN cliente c ON b.id_cliente = c.id_cliente
            INNER JOIN usuario u ON b.id_usuario = u.id_usuario;";
            $stmt = $con->prepare($stringSQL);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $listaBoletas[] = $row;
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $listaBoletas;
    }
    public function total()
    {
        $totalVentas = 0;

        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT COUNT(*) as total FROM boleta";
            $stmt = $con->prepare($stringSQL);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['total'])) {
                $totalVentas = $result['total'];
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $totalVentas;
    }
}
