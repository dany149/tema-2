<?php
session_start();
include '../../../../conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_categoria = $_GET['id'];

    try {
        $stmt = $conexion->prepare("DELETE FROM Categorias WHERE id = :id");
        $stmt->bindParam(':id', $id_categoria, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Categoría eliminada exitosamente.";
        } else {
            echo "Error al eliminar categoría.";
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
