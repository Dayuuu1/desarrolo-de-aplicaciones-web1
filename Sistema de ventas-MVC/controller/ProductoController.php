<?php
require_once '../dao/DAOUsuarioImpl.php';
require_once '../dao/AccesoDB.php';
require_once '../dao/DAOProductoImpl.php';
require_once '../model/Productos.php';

class ProductoController
{
    private $daoProducto;

    public function __construct()
    {
        $this->daoProducto = new DAOProductoImpl();
    }

    public function insertarProducto(Producto $producto)
    {
        try {
            $mensaje = $this->daoProducto->insertar($producto);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al insertar productos: " . $ex->getMessage());
        }
    }

    public function modificarProducto(Producto $producto)
    {
        try {
            $mensaje = $this->daoProducto->modificar($producto);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al insertar productos: " . $ex->getMessage());
        }
    }

    public function eliminarProducto(Producto $producto)
    {
        try {
            $mensaje = $this->daoProducto->eliminar($producto);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al eliminar productos: " . $ex->getMessage());
        }
    }

    public function obtenerUltimoIdProducto()
    {
        try {
            $ultimoId = $this->daoProducto->obtenerUltimoIdUsuario(); //try
            $nuevoId  = $ultimoId + 1;
            return $nuevoId;
        } catch (Exception $ex) {
            throw new Exception("Error al mostrar el formulario de regisitros: " . $ex->getMessage());
        }
    }

    public function listarProducto()
    {
        try {
            $productos = $this->daoProducto->listar();
            return $productos;
        } catch (Exception $ex) {
            throw new Exception("Error al listar los usuarios: " . $ex->getMessage());
        }
    }
    public function totaProductos()
    {
        try {
            $total_productos = $this->daoProducto->total();
            return $total_productos;
        } catch (Exception $ex) {
            throw new Exception("Error al sacar total: " . $ex->getMessage());
        }
    }
    public function autocompletarProducto($term) {
        try {
            $listaProductos = $this->daoProducto->obtenerProducto($term);
            $datos = array();
            foreach ($listaProductos as $producto) {
                $datos[] = array(
                    'value' => $producto->getCodigo(),
                    'nombre' => $producto->getNombre_producto(),
                    'stock' => $producto->getStock(),
                    'precio' => $producto->getPrecio_unitario(),
                    'idp' => $producto->getIdProdcuto()
                );
            }
            echo json_encode($datos);
        } catch (Exception $ex) {
            echo json_encode([]);
        }
    }
}

$controller = new ProductoController();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    try {

        $codigo = $_POST['codigo'];
        $nombre_producto = $_POST['nombre_producto'];
        $stock = $_POST['stock'];
        $precio_unitario = $_POST['precio_unitario'];
        $id_proveedor = $_POST['id_proveedor'];
        
        $producto = new Producto(null, $codigo, $nombre_producto, $stock, $precio_unitario, $id_proveedor);

        $mensaje = $controller->insertarProducto($producto);
        $_SESSION['success_message'] = "Producto agregado exitosamente.";
        header("location: ../view/lista_productos.php");
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar'])) {
    try {
        $idProdcuto = $_POST['idProdcuto_edit'];
        $codigo = $_POST['codigo_edit'];
        $nombre_producto = $_POST['nombre_producto_edit'];
        $stock = $_POST['stock_edit'];
        $precio_unitario = $_POST['precio_unitario_edit'];
        $id_proveedor = $_POST['id_proveedor_edit'];
        
        $producto = new Producto($idProdcuto, $codigo,$nombre_producto, $stock, $precio_unitario, $id_proveedor);

        $mensaje = $controller->modificarProducto($producto);
        $_SESSION['success_message'] = "Producto modificaco exitosamente.";
        header("location: ../view/lista_productos.php");
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_eliminar_pro'])) {
    try {
        $idProdcuto = $_POST['idProducto_eliminar'];

        $producto = new Producto($idProdcuto, null, null, null, null, null);

        $mensaje = $controller->eliminarProducto($producto);
        $_SESSION['success_message'] = "Producto eliminado exitosamente.";
        header("location: ../view/lista_productos.php");
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['obtenerUltimoIdProducto'])) {
    try {
        $ultimoId = $controller->obtenerUltimoIdProducto($producto);
        echo $ultimoId;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}
if (isset($_GET['term'])) {
    $term = $_GET['term'];

    $objProducto = new ProductoController();

    $objProducto->autocompletarProducto($term);
}