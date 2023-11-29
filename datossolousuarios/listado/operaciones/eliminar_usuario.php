<?php
session_start();
include '../../../../conecta.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    try {
        $stmt = $conexion->prepare("DELETE FROM Usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Usuario eliminado exitosamente.";
        } else {
            echo "Error al eliminar usuario.";
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
