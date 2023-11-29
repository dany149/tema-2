<?php
session_start();
include '../../../conecta.php';

try {
    // Llamada al procedimiento almacenado
    $stmt = $conexion->prepare("CALL InsertarLog(:fecha_hora, :usuario, :tipo_operacion)");

    // Asignar valores a los parámetros
    // Obtener la fecha y hora actual
    $fecha_hora = date('Y-m-d H:i:s'); 
    //usuario y tipo
    $usuario = 'admin'; 
    $tipo_operacion = 'tipo_de_operacion'; 

    $stmt->bindParam(':fecha_hora', $fecha_hora, PDO::PARAM_STR);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->bindParam(':tipo_operacion', $tipo_operacion, PDO::PARAM_STR);

    // Ejecutar el procedimiento almacenado
    $stmt->execute();

    echo "Registro en el log insertado correctamente.";
} catch (PDOException $e) {
    echo "Error al ejecutar el procedimiento almacenado: " . $e->getMessage();
}

// Cierre de conexión
$conexion = null;
?>
