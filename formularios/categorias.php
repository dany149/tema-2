<?php
session_start();
// Incluir el script de conexión a la base de datos
include '../../../conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];

    try {
        $stmt = $conexion->prepare("INSERT INTO Categorias (nombre) VALUES (:nombre)");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Categoría agregada exitosamente.";
        } else {
            echo "Error al agregar categoría.";
        }
    } catch (PDOException $e) {
        echo "Error de base de datos: " . $e->getMessage();
    }
}

// Cierre de conexión
$conexion = null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/css2.css">
    <title>Formulario de Categorías</title>
</head>

<body>
    <h2>Formulario de Categorías</h2>

    <form method="POST" action="categorias.php">
        <label for="nombre">Nombre de la Categoría:</label>
        <input type="text" name="nombre" required>

        <button type="submit">Agregar Categoría</button>
    </form>
</body>

</html>
