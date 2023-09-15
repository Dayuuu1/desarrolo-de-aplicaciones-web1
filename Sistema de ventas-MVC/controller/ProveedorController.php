<?php
require_once '../dao/DAOUsuarioImpl.php';
require_once '../dao/AccesoDB.php';
require_once '../dao/DAOProveedorImpl.php';
require_once '../model/Proveedor.php';

class ProveedorController
{
    private $daoProveedor;

    public function __construct()
    {
        $this->daoProveedor = new DAOProveedorImpl();
    }

    public function insertarProveedor(Proveedor $proveedor)
    {
        try {
            $mensaje = $this->daoProveedor->insertar($proveedor);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al insertar proveedor: " . $ex->getMessage());
        }
    }

    public function modificarProveedor(Proveedor $proveedor)
    {
        try {
            $mensaje = $this->daoProveedor->modificar($proveedor);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al insertar proveedor: " . $ex->getMessage());
        }
    }

    public function eliminarProveedor(Proveedor $proveedor)
    {
        try {
            $mensaje = $this->daoProveedor->eliminar($proveedor);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al eliminar proveedor: " . $ex->getMessage());
        }
    }

    public function obtenerUltimoIdProveedor()
    {
        try {
            $ultimoId = $this->daoProveedor->obtenerUltimoIdProveedor(); //try
            $nuevoId  = $ultimoId + 1;
            return $nuevoId;
        } catch (Exception $ex) {
            throw new Exception("Error al mostrar el formulario de regisitros: " . $ex->getMessage());
        }
    }

    public function listarCliente()
    {
        try {
            $proveedores = $this->daoProveedor->listar();
            return $proveedores;
        } catch (Exception $ex) {
            throw new Exception("Error al listar los clientes: " . $ex->getMessage());
        }
    }
    
}

$controller = new ProveedorController();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    try {

        $nombre_proveedor = $_POST['nombre_proveedor'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        
        $proveedor = new Proveedor(null, $nombre_proveedor, $direccion, $telefono);

        $mensaje = $controller->insertarProveedor($proveedor);
        $_SESSION['success_message'] = "Proveedor agregado exitosamente.";
        header("location: ../view/lista_proveedores.php");//falta
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar'])) {
    try {
        $id_proveedor = $_POST['id_proveedor_edit'];
        $nombre_proveedor = $_POST['nombre_proveedor_edit'];
        $direccion = $_POST['direccion_edit'];
        $telefono = $_POST['telefono_edit'];
        
        
        $proveedor = new Proveedor($id_proveedor, $nombre_proveedor, $direccion, $telefono);

        $mensaje = $controller->modificarProveedor($proveedor);
        $_SESSION['success_message'] = "Proveedor modificado exitosamente.";
        header("location: ../view/lista_proveedores.php");
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_eliminar_prove'])) {
    try {
        $id_proveedor = $_POST['id_proveedor_eliminar'];

        $proveedor = new Proveedor($id_proveedor, null, null, null);

        $mensaje = $controller->eliminarProveedor($proveedor);
        $_SESSION['success_message'] = "Proveedor eliminado exitosamente.";
        header("location: ../view/lista_proveedores.php");
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['obtenerUltimoIdProveedor'])) {
    try {
        $ultimoId = $controller->obtenerUltimoIdProveedor($proveedor);
        echo $ultimoId;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}
