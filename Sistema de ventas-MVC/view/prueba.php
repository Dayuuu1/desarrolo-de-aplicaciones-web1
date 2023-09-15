<?php
require_once '../dao/AccesoDB.php'; 

function obtenerDetalleBoleta($id_boleta)
{
    try {
        $objConn = AccesoDB::getInstance();
        $con = $objConn->getConnection();
        $stringSQL = "SELECT db.id_detalle, db.id_boleta, p.nombre_producto, db.cantidad, db.precio_unitario
                      FROM detalle_boleta db
                      INNER JOIN productos p ON db.id_producto = p.id_producto
                      WHERE db.id_boleta = :id_boleta;";
        $stmt = $con->prepare($stringSQL);
        $stmt->bindParam(':id_boleta', $id_boleta, PDO::PARAM_INT);
        $stmt->execute();
        $detalle_boleta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $detalle_boleta;
    } catch (Exception $ex) {
        throw $ex;
    }
}

if (isset($_GET['numero_de_boleta'])) {
    try {
        $nr_boleta = $_GET['numero_de_boleta'];
        $detalles_boleta = obtenerDetalleBoleta($nr_boleta);

        if ($detalles_boleta) {
            echo "Detalle de la boleta con número $nr_boleta:<br>";
            foreach ($detalles_boleta as $detalle) {
                echo "ID Detalle: " . $detalle['id_detalle'] . "<br>";
                echo "ID Boleta: " . $detalle['id_boleta'] . "<br>";
                echo "Nombre Producto: " . $detalle['nombre_producto'] . "<br>";
                echo "Cantidad: " . $detalle['cantidad'] . "<br>";
                echo "Precio Unitario: " . $detalle['precio_unitario'] . "<br>";
                echo "---------------------------------<br>";
            }
        } else {
            echo "No se encontraron detalles para la boleta con número $nr_boleta";
        }
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
}
