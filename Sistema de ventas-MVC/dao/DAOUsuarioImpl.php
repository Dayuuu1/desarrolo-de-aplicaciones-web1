<?php
session_start();
require_once 'IDAOUsuario.php';
require_once '../model/Usuario.php';

class DAOUsuarioImpl implements IDAOUsuario
{

    public function login($nombre, $contraseña)
    {
        try {
            
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT * FROM usuario WHERE nombre = ?";
            $stmt = $con->prepare($stringSQL);
            $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
            $stmt->execute();

            
            if ($stmt->rowCount() > 0) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                
                if ($contraseña === $usuario['contraseña']) {
                   
                    $_SESSION['nombre'] = $usuario['nombre'];
                    $_SESSION['id_usuario'] = $usuario['id_usuario'];
                    $_SESSION['image_url'] = $usuario['image_url'];
                    $_SESSION['id_rol'] = $usuario['id_rol'];

                    
                    header("Location: ../view/index.php");
                    exit;
                } else {
                    $_SESSION['success_message'] = "Contraseña incorrecta.";
                    header("Location: ../index.php");
                    exit;
                }
            } else {
                $_SESSION['success_message'] = "Usuario no encontrado.";
                header("Location: ../index.php");
                exit;
            }
        } catch (Exception $ex) {
            throw new Exception("Error al realizar el login: " . $ex->getMessage());
        }
    }



    public function insertar(Usuario $objUsuario)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "INSERT INTO usuario (nombre, correo_electronico, contraseña, id_rol, image_url) VALUES (?, ?, ?, ?, ?)";
            $stmt = $con->prepare($stringSQL);

            $nombre = $objUsuario->getNombre();
            $correo_electronico = $objUsuario->getCorreo_electronico();
            $contraseña = $objUsuario->getContraseña();
            $id_rol = $objUsuario->getId_rol();
            $image_url = $objUsuario->getImage_url();

            $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
            $stmt->bindParam(2, $correo_electronico, PDO::PARAM_STR);
            $stmt->bindParam(3, $contraseña, PDO::PARAM_STR);
            $stmt->bindParam(4, $id_rol, PDO::PARAM_INT);
            $stmt->bindParam(5, $image_url, PDO::PARAM_STR);

            $filas = $stmt->execute();
        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }

    public function eliminar(Usuario $objUsuario)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "DELETE FROM usuario WHERE id_usuario = ?";
            $stmt = $con->prepare($stringSQL);

            $idUsuario = $objUsuario->getIdUsuario();

            $stmt->bindParam(1, $idUsuario, PDO::PARAM_INT);

            $filas = $stmt->execute();

        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }

    public function modificar(Usuario $objUsuario)
    {
        $msj = "";
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "UPDATE usuario SET nombre = ?, correo_electronico = ?, contraseña = ?, id_rol = ?, image_url = ? WHERE id_usuario = ?";
            $stmt = $con->prepare($stringSQL);

            $nombre = $objUsuario->getNombre();
            $correo_electronico = $objUsuario->getCorreo_electronico();
            $contraseña = $objUsuario->getContraseña();
            $id_rol = $objUsuario->getId_rol();
            $idUsuario = $objUsuario->getIdUsuario();
            $image_url = $objUsuario->getImage_url();

            $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
            $stmt->bindParam(2, $correo_electronico, PDO::PARAM_STR);
            $stmt->bindParam(3, $contraseña, PDO::PARAM_STR);
            $stmt->bindParam(4, $id_rol, PDO::PARAM_INT);
            $stmt->bindParam(5, $image_url, PDO::PARAM_STR);
            $stmt->bindParam(6, $idUsuario, PDO::PARAM_INT);


            $filas = $stmt->execute();

        } catch (Exception $ex) {
            throw $ex;
        }
        return $msj;
    }
    public function listar()
    {
        $listaUsuarios = [];
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT u.id_usuario, u.image_url, u.nombre, u.correo_electronico, u.contraseña,r.nombre_rol AS nombre_rol
            FROM usuario u
            INNER JOIN rol r ON u.id_rol = r.id_rol;";
            $stmt = $con->prepare($stringSQL);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $listaUsuarios[] = $row;
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $listaUsuarios;
    }

    public function obtenerUsuario($term)
    {
        $listaUsuarios = [];
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT * FROM usuario WHERE CONCAT(nombre, ' ', correo_electronico) LIKE :term";
            $stmt = $con->prepare($stringSQL);
            $stmt->bindValue(':term', '%' . $term . '%', PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $idUsuario = $row['id_usuario'];
                $nombre = $row['nombre'];
                $correo_electronico = $row['correo_electronico'];
                $contraseña = $row['contraseña'];
                $id_rol = $row['id_rol'];
                $image_url = $row['image_url'];

                $objUsuario = new Usuario($idUsuario, $nombre, $correo_electronico, $contraseña, $id_rol, $image_url);
                $listaUsuarios[] = $objUsuario;
                
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $listaUsuarios;
    }

    public function obtenerUltimoIdUsuario()
    {
        $ultimoId = null;
        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT MAX(id_usuario) AS ultimoId FROM usuario";
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
        $totalUsuarios = 0;

        try {
            $objConn = AccesoDB::getInstance();
            $con = $objConn->getConnection();
            $stringSQL = "SELECT COUNT(*) as total FROM usuario"; 
            $stmt = $con->prepare($stringSQL);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['total'])) {
                $totalUsuarios = $result['total']; 
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $totalUsuarios;
    }
}
