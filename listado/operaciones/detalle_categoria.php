<?php
session_start();
include '../../../../conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_categoria = $_GET['id'];

    try {
        $stmt = $conexion->prepare("SELECT * FROM Categorias WHERE id = :id");
        $stmt->bindParam(':id', $id_categoria, PDO::PARAM_INT);
        $stmt->execute();

        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$categoria) {
            echo "Categoría no encontrada.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error de base de datos: " . $e->getMessage();
        exit();
    }
} else {
    echo "Parámetros no válidos.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../../css/css2.css">
    <title>Detalle de Categoría</title>
</head>

<body>
    <h2>Detalle de Categoría</h2>

    <p>ID: <?php echo $categoria['id']; ?></p>
    <p>Nombre: <?php echo $categoria['nombre']; ?></p>

    <a href="../categorias.php">Volver al Listado</a>
</body>

</html>
