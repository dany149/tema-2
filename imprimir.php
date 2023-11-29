<?php
require_once('tcpdf/tcpdf.php');
include '../../../conecta.php';

// Función para obtener todos los registros de la tabla 'logs'
function obtenerRegistrosLogs()
{
    $conexion = obtenerConexion();
    $stmt = $conexion->query("SELECT * FROM logs");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener registros de la tabla 'logs'
$registrosLogs = obtenerRegistrosLogs();

// Crear instancia de TCPDF
$pdf = new TCPDF();
$pdf->SetAutoPageBreak(true, 15);

// Añadir una página
$pdf->AddPage();

// Configurar fuentes y estilos
$pdf->SetFont('times', '', 12);
$pdf->SetFillColor(200, 220, 255);
$pdf->SetTextColor(0, 0, 0);

// Títulos de la tabla en el PDF
$titles = array('ID', 'Fecha y Hora', 'Usuario', 'Tipo de Operación');
$pdf->SetFont('times', 'B', 12);

// Añadir fila de títulos
foreach ($titles as $title) {
    $pdf->Cell(40, 10, $title, 1, 0, 'C', 1);
}

// Configurar fuentes y estilos para los datos de la tabla
$pdf->SetFont('times', '', 12);

foreach ($registrosLogs as $registro) {
    // Añadir fila a la tabla en el PDF
    $pdf->Ln();
    foreach ($registro as $value) {
        $pdf->MultiCell(40, 10, $value, 1, 'C');
    }
}

// Mostrar el PDF en el navegador
$pdf->Output('registros_logs.pdf', 'I');
?>
