<?php
session_start();
include '../../../../conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_entrada = $_GET['id'];

    try {
        $stmt = $conexion->prepare("DELETE FROM entradas WHERE id = :id");
        $stmt->bindParam(':id', $id_entrada, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Entrada eliminada exitosamente.";
        } else {
            echo "Error al eliminar entrada.";
        }
    } catch (PDOException $e) {
        echo "Error de base de datos: " . $e->getMessage();
    }

    // Cierre de conexión
    $conexion = null;
    exit();
} else {
    echo "Parámetros no válidos.";
    exit();
}
?>
