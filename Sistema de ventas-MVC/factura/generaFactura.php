<?php
session_start();
if (empty($_SESSION['nombre'])) {
	header('location: ../');
}
require_once '../dao/AccesoDB.php';

function obtenerBoleta($nr_boleta)
{
	try {
		$objConn = AccesoDB::getInstance();
		$con = $objConn->getConnection();
		$stringSQL = "SELECT b.id_boleta, b.fecha, c.nombre_cliente, c.dni, c.telefono, c.direccion , u.nombre, b.totalBoleta
		FROM boleta b
		INNER JOIN cliente c ON b.id_cliente = c.id_cliente
		INNER JOIN usuario u ON b.id_usuario = u.id_usuario 
            WHERE b.id_boleta = :nr_boleta;";
		$stmt = $con->prepare($stringSQL);
		$stmt->bindParam(':nr_boleta', $nr_boleta, PDO::PARAM_INT);
		$stmt->execute();
		$boleta = $stmt->fetch(PDO::FETCH_ASSOC);
		return $boleta;
	} catch (Exception $ex) {
		throw $ex;
	}
}

function obtenerDetalleBoleta($id_boleta)
{
	try {
		$objConn = AccesoDB::getInstance();
		$con = $objConn->getConnection();
		$stringSQL = "SELECT db.id_detalle, db.id_boleta, p.nombre_producto, p.precio_unitario as prcio_producto, db.cantidad, db.precio_unitario
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

// Verificamos si se ha enviado el número de boleta
if (isset($_GET['numero_de_boleta'])) {
	try {
		$nr_boleta = $_GET['numero_de_boleta'];
		$boleta = obtenerBoleta($nr_boleta);
		$detalle_b = $_GET['numero_de_boleta'];
		$detalles_boleta = obtenerDetalleBoleta($detalle_b);

		// Aquí puedes mostrar los resultados, por ejemplo:
		if ($boleta) {
			require_once 'fpdf/fpdf.php';
			$pdf = new FPDF('P', 'mm', array(80, 200));
			$pdf->AddPage();
			$pdf->SetMargins(1, 0, 0);
			$pdf->SetTitle("Ventas");
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->Cell(60, 5, utf8_decode("SISTEMA DE VENTA MINIMARKET"), 0, 1, 'C');
			$pdf->Ln();
			//$pdf->image("img/logo.jpg", 50, 18, 15, 15, 'JPG');
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(15, 5, "Ruc: ", 0, 0, 'L');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(20, 5, "123741258963", 0, 1, 'L');
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(15, 5, utf8_decode("Teléfono: "), 0, 0, 'L');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(20, 5, "937370621", 0, 1, 'L');
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(15, 5, utf8_decode("Dirección: "), 0, 0, 'L');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(20, 5, utf8_decode("av. Unamad"), 0, 1, 'L');
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(15, 5, "Ticked: ", 0, 0, 'L');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(20, 5, $boleta['id_boleta'], 0, 0, 'L');
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(16, 5, "Fecha: ", 0, 0, 'R');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(25, 5, $boleta['fecha'], 0, 1, 'R');
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(60, 5, "Datos del cliente", 0, 1, 'L');
			$pdf->Cell(40, 5, "Nombre", 0, 0, 'L');
			$pdf->Cell(20, 5, utf8_decode("Teléfono"), 0, 0, 'L');
			$pdf->Cell(25, 5, utf8_decode("Dirección"), 0, 1, 'L');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(40, 5, utf8_decode($boleta['nombre_cliente']), 0, 0, 'L');
			$pdf->Cell(20, 5, utf8_decode($boleta['telefono']), 0, 0, 'L');
			$pdf->Cell(25, 5, utf8_decode($boleta['direccion']), 0, 1, 'L');
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(75, 5, "Detalle de Productos", 0, 1, 'L');
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(42, 5, 'Nombre', 0, 0, 'L');
			$pdf->Cell(8, 5, 'Cant', 0, 0, 'L');
			$pdf->Cell(15, 5, 'Precio', 0, 0, 'L');
			$pdf->Cell(15, 5, 'Total', 0, 1, 'L');
			$pdf->SetFont('Arial', '', 7);
			foreach ($detalles_boleta as $detallep) {

				$pdf->Cell(42, 5, utf8_decode($detallep['nombre_producto']), 0, 0, 'L');
				$pdf->Cell(8, 5, $detallep['cantidad'], 0, 0, 'L');
				$pdf->Cell(15, 5, number_format($detallep['prcio_producto'], 2, '.', ','), 0, 0, 'L');
				$importe = number_format($detallep['cantidad'] * $detallep['prcio_producto'], 2, '.', ',');
				$pdf->Cell(15, 5, $importe, 0, 1, 'L');
			};
			$pdf->Ln();
			$pdf->SetFont('Arial', 'B', 10);

			$pdf->Cell(76, 5, 'Total: ' . number_format($boleta['totalBoleta'], 2, '.', ','), 0, 1, 'R');
			$pdf->Ln();
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(80, 5, utf8_decode("Gracias por su preferencia"), 0, 1, 'C');
			$pdf->Output("compra.pdf", "I");
		} else {
			echo "No se encontró ninguna boleta con el número $nr_boleta";
		}
	} catch (Exception $ex) {
		echo "Error: " . $ex->getMessage();
	}
}
