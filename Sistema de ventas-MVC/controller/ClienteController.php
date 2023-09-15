<?php
require_once '../dao/DAOUsuarioImpl.php';
require_once '../dao/AccesoDB.php';
require_once '../dao/DAOClienteImpl.php';
require_once '../model/Clientes.php';

class ClienteController
{
    private $daoCliente;

    public function __construct()
    {
        $this->daoCliente = new DAOClienteImpl();
    }

    public function insertarCliente(Cliente $cliente)
    {
        try {
            $mensaje = $this->daoCliente->insertar($cliente);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al insertar cliente: " . $ex->getMessage());
        }
    }

    public function modificarCliente(Cliente $cliente)
    {
        try {
            $mensaje = $this->daoCliente->modificar($cliente);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al insertar cliente: " . $ex->getMessage());
        }
    }

    public function eliminarCliente(Cliente $cliente)
    {
        try {
            $mensaje = $this->daoCliente->eliminar($cliente);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al eliminar cliente: " . $ex->getMessage());
        }
    }

    public function obtenerUltimoIdCliente()
    {
        try {
            $ultimoId = $this->daoCliente->obtenerUltimoIdCliente(); //try
            $nuevoId  = $ultimoId + 1;
            return $nuevoId;
        } catch (Exception $ex) {
            throw new Exception("Error al mostrar el formulario de regisitros: " . $ex->getMessage());
        }
    }

    public function listarCliente()
    {
        try {
            $clientes = $this->daoCliente->listar();
            return $clientes;
        } catch (Exception $ex) {
            throw new Exception("Error al listar los clientes: " . $ex->getMessage());
        }
    }
    public function totaClientes()
    {
        try {
            $total_clientes = $this->daoCliente->total();
            return $total_clientes;
        } catch (Exception $ex) {
            throw new Exception("Error al listar los clientes: " . $ex->getMessage());
        }
    }
    //ok    
    public function autocompletarCliente($term) {
        try {
            $listaClientes = $this->daoCliente->obtenerCliente($term);
            $datos = array();
            foreach ($listaClientes as $cliente) {
                $datos[] = array(
                    'value' => $cliente->getDni(),
                    'nombre' => $cliente->getNombre_cliente(),
                    'telefono' => $cliente->getTelefono(),
                    'id' => $cliente->getIdCliente()
                );
            }
            echo json_encode($datos);
        } catch (Exception $ex) {
            echo json_encode([]);
        }
    }
}

$controller = new ClienteController();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    try {
        $dni = $_POST['dni'];
        $nombre_cliente = $_POST['nombre_cliente'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];

        $cliente = new Cliente(null, $dni, $nombre_cliente, $direccion, $telefono);

        $mensaje = $controller->insertarCliente($cliente);
        $_SESSION['success_message'] = "Cliente agregado exitosamente.";
        header("location: ../view/lista_clientes.php");
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar'])) {
    try {
        $dni = $_POST['dni_edit'];
        $id_cliente = $_POST['id_cliente_edit'];
        $nombre_cliente = $_POST['nombre_cliente_edit'];
        $direccion = $_POST['direccion_edit'];
        $telefono = $_POST['telefono_edit'];


        $cliente = new Cliente($id_cliente, $dni,  $nombre_cliente, $direccion, $telefono);

        $mensaje = $controller->modificarCliente($cliente);
        $_SESSION['success_message'] = "Cliente modificado exitosamente.";
        header("location: ../view/lista_clientes.php");
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_eliminar_cli'])) {
    try {
        $id_cliente = $_POST['id_cliente_eliminar'];

        $cliente = new Cliente($id_cliente, null, null, null, null);

        $mensaje = $controller->eliminarCliente($cliente);
        $_SESSION['success_message'] = "Cliente eliminado exitosamente.";
        header("location: ../view/lista_clientes.php");
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['obtenerUltimoIdCliente'])) {
    try {
        $ultimoId = $controller->obtenerUltimoIdCliente($cliente);
        echo $ultimoId;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}
//ok
if (isset($_GET['term'])) {
    $term = $_GET['term'];

    $objCliente = new ClienteController();

    $objCliente->autocompletarCliente($term);
}