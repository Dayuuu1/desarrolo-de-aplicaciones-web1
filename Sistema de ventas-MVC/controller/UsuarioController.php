<?php
require_once '../dao/AccesoDB.php';
require_once '../dao/DAOUsuarioImpl.php';
require_once '../model/Usuario.php';

class UsuarioController
{
    private $daoUsuario;

    public function __construct()
    {
        $this->daoUsuario = new DAOUsuarioImpl();
    }
    public function login($nombre, $contraseña)
    {
        try {
            $mensaje = $this->daoUsuario->login($nombre, $contraseña);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al insertar usuario: " . $ex->getMessage());
        }
    }

    public function insertarUsuario(Usuario $usuario)
    {
        try {
            $mensaje = $this->daoUsuario->insertar($usuario);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al insertar usuario: " . $ex->getMessage());
        }
    }

    public function modificarUsuario(Usuario $usuario)
    {
        try {
            $mensaje = $this->daoUsuario->modificar($usuario);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al insertar usuario: " . $ex->getMessage());
        }
    }

    public function eliminarUsuario(Usuario $objUsuario)
    {
        try {
            $mensaje = $this->daoUsuario->eliminar($objUsuario);
            return $mensaje;
        } catch (Exception $ex) {
            throw new Exception("Error al eliminar usuarios: " . $ex->getMessage());
        }
    }

    public function obtenerUltimoIdUsuario()
    {
        try {
            $ultimoId = $this->daoUsuario->obtenerUltimoIdUsuario(); //try
            $nuevoId  = $ultimoId + 1;
            return $nuevoId;
        } catch (Exception $ex) {
            throw new Exception("Error al mostrar el formulario de regisitros: " . $ex->getMessage());
        }
    }

    public function listarUsuario()
    {
        try {
            $usuarios = $this->daoUsuario->listar();
            return $usuarios;
        } catch (Exception $ex) {
            throw new Exception("Error al listar los usuarios: " . $ex->getMessage());
        }
    }
    public function totaUsuarios()
    {
        try {
            $total_usuarios = $this->daoUsuario->total();
            return $total_usuarios;
        } catch (Exception $ex) {
            throw new Exception("Error al listar los usuarios: " . $ex->getMessage());
        }
    }
}

$controller = new UsuarioController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    try {

        $nombre = $_POST['nombre'];
        $contraseña = $_POST['contraseña'];
        $mensaje = $controller->login($nombre, $contraseña);
        echo $mensaje;
        header("location: ../view/index.php");
       

    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    try {

        $nombre = $_POST['nombre'];
        $correo_electronico = $_POST['correo'];
        $contraseña = $_POST['clave'];
        $id_rol = $_POST['rol'];
        //imagen
        $img_name = $_FILES['my_image']['name'];
        $img_size = $_FILES['my_image']['size'];
        $tmp_name = $_FILES['my_image']['tmp_name'];
        $error = $_FILES['my_image']['error'];
        $new_img_name = "";

        if ($img_size > 125000) {
            $em = "este archivo es muy largo.";
            header("Location: ../view/index.php");
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = '../uploads/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
            } else {
                $em = "no puedes agregar este archivo";
                header("Location: ../view/index.php");
            }
        }

        $usuario = new Usuario(null, $nombre, $correo_electronico, $contraseña, $id_rol, $new_img_name);

        $mensaje = $controller->insertarUsuario($usuario);
        $_SESSION['success_message'] = "Usuario registrado exitosamente.";
        header("location: ../view/lista_usuarios.php");
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar'])) {
    try {
        $contra_no_editada = $_POST['contra_edit'];
        $imagen_actual = $_POST['img_no'];
        $idUsaurio = $_POST['id_edit'];
        $nombre = $_POST['nombre_edit'];
        $correo_electronico = $_POST['correo_edit'];
        $contraseña = $_POST['clave_edit'];
        $id_rol = $_POST['rol_edit'];
        $contraseña_a_guardar = empty($contraseña) ? $contra_no_editada : $contraseña;
        //imagen
        $img_name = $_FILES['my_image_edit']['name'];
        $img_size = $_FILES['my_image_edit']['size'];
        $tmp_name = $_FILES['my_image_edit']['tmp_name'];
        $error = $_FILES['my_image_edit']['error'];
        $new_img_name = $_POST['img_no'];

        if ($img_size > 125000) {
            $em = "este archivo es muy largo.";
            header("Location: ../view/index.php");
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = '../uploads/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
            } else {
                $em = "no puedes agregar este archivo";
                header("Location: ../view/index.php");
            }
        }


        $usuario = new Usuario($idUsaurio, $nombre, $correo_electronico, $contraseña_a_guardar, $id_rol, $new_img_name);

        $mensaje = $controller->modificarUsuario($usuario);
        $_SESSION['success_message'] = "Usuario modificado exitosamente.";
        header("location: ../view/lista_usuarios.php");
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_eliminar_usua'])) {
    try {
        $idUsaurio = $_POST['idUsaurio_eliminar'];

        $usuario = new Usuario($idUsaurio, null, null, null, null, null);

        $mensaje = $controller->eliminarUsuario($usuario);
        $_SESSION['success_message'] = "Usuario eliminado exitosamente.";
        header("location: ../view/lista_usuarios.php");
        exit;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['obtenerUltimoIdUsuario'])) {
    try {
        $ultimoId = $controller->obtenerUltimoIdUsuario($usuario);
        echo $ultimoId;
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}
