<?php
require_once '../dao/AccesoDB.php';
require_once '../dao/DAODetalleFacturaImpl.php';
require_once '../model/DetalleFactura.php';
require_once '../model/boleta.php';

class DetalleFacturaController
{
    private $daoDetalleFactura;

    public function __construct()
    {
        $this->daoDetalleFactura = new DAODetalleFacturaImpl();
    }

    public function insertarDetalleFactura(DetalleFactura $detalleFactura)
    {
        try {
            $mensaje = $this->daoDetalleFactura->insertar($detalleFactura);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al insertar detalle: " . $ex->getMessage());
        }
    }

    public function insertarBoleta(Boleta $boleta)
    {
        try {
            $mensaje = $this->daoDetalleFactura->insertarBoleta($boleta);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al insertar boleta: " . $ex->getMessage());
        }
    }
    public function listarBoleta()
    {
        try {
            $productos = $this->daoDetalleFactura->listarBoleta();
            return $productos;
        } catch (Exception $ex) {
            throw new Exception("Error al listar los usuarios: " . $ex->getMessage());
        }
    }

    public function totaBoletas()
    {
        try {
            $total_boletas = $this->daoDetalleFactura->total_filas_boleta();
            return $total_boletas;
        } catch (Exception $ex) {
            throw new Exception("Error al listar los clientes: " . $ex->getMessage());
        }
    }
    public function totaB()
    {
        try {
            $total_bole = $this->daoDetalleFactura->total();
            return $total_bole;
        } catch (Exception $ex) {
            throw new Exception("Error al sacar total: " . $ex->getMessage());
        }
    }

    //imprimir
    
}

$controller = new DetalleFacturaController();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    try {
        $resultado = $_POST['resultado'];
        $id_usuario = $_POST['id_usuario'];
        $boletat = $_POST['boletat'];
        $total_venta = $_POST['total_venta'];
        date_default_timezone_set('America/Lima');
        $fechaActual = date("Y-m-d H:i:s");
        $cliente_id = $_POST['cliente_id'];

        $boleta = new Boleta(null, $fechaActual, $cliente_id, $id_usuario, $total_venta); //aqui
        $mensaje = $controller->insertarBoleta($boleta);

        $resultado = rtrim($resultado, ';');

        
        $registros = explode(';', $resultado);

        
        foreach ($registros as $registro) {
            $datosSeparados = explode(',', $registro);

            
            if (count($datosSeparados) === 4) {
                $id_cliente = $datosSeparados[0];
                $id_producto = $datosSeparados[1];
                $cantidad_producto = $datosSeparados[2];
                $total = $datosSeparados[3];

                $detalleFactura = new DetalleFactura(null, $boletat, $id_producto, $cantidad_producto, $total); //aqui
                $mensaje = $controller->insertarDetalleFactura($detalleFactura);
            } else {
                echo "Error: Registro inválido.";
            }
        }        
        echo $mensaje;
        header("location: ../factura/generaFactura.php?numero_de_boleta=$boletat");      
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}


