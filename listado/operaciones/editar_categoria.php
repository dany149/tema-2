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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];

    try {
        $stmt = $conexion->prepare("UPDATE Categorias SET nombre = :nombre WHERE id = :id");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id_categoria, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Categoría editada exitosamente.";
        } else {
            echo "Error al editar categoría.";
        }
    } catch (PDOException $e) {
        echo "Error de base de datos: " . $e->getMessage();
    }

    // Cierre de conexión
    $conexion = null;
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../../css/css2.css">
    <title>Editar Categoría</title>
</head>

<body>
    <h2>Editar Categoría</h2>

    <form method="POST" action="">
        <label for="nombre">Nombre de la Categoría:</label>
        <input type="text" name="nombre" value="<?php echo $categoria['nombre']; ?>" required>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>

</html>
