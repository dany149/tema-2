<?php
session_start();
// Incluir el script de conexión a la base de datos
include '../../../conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $id_usuario = $_POST['id_usuario'];

    // Procesar la imagen
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_temp = $_FILES['imagen']['tmp_name'];
    $imagen_ruta = "../../../images/" . $imagen_nombre;

    // Mover la imagen al directorio de imágenes
    move_uploaded_file($imagen_temp, $imagen_ruta);

    try {
        $stmt = $conexion->prepare("INSERT INTO Entradas (titulo, contenido, id_usuario, imagen) VALUES (:titulo, :contenido, :id_usuario, :imagen)");
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':contenido', $contenido, PDO::PARAM_STR);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':imagen', $imagen_ruta, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Entrada agregada exitosamente.";
        } else {
            echo "Error al agregar entrada.";
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
    <title>Formulario de Entradas</title>
</head>

<body>
    <h2>Formulario de Entradas</h2>

    <form method="POST" action="entradas.php" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required>

        <label for="contenido">Contenido:</label>
        <textarea name="contenido" rows="4" required></textarea>

        <label for="id_usuario">ID Usuario:</label>
        <input type="number" name="id_usuario" required>

        <label for="imagen">Imagen de la entrada:</label>
        <input type="file" name="imagen" accept="image/*">

        <button type="submit">Agregar Entrada</button>
    </form>
</body>

</html>
