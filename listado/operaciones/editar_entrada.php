<?php
session_start();
include '../../../../conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_entrada = $_GET['id'];

    try {
        $stmt = $conexion->prepare("SELECT * FROM entradas WHERE id = :id");
        $stmt->bindParam(':id', $id_entrada, PDO::PARAM_INT);
        $stmt->execute();

        $entrada = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$entrada) {
            echo "Entrada no encontrada.";
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
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $id_usuario = $_POST['id_usuario'];

    try {
        $stmt = $conexion->prepare("UPDATE Entradas SET titulo = :titulo, contenido = :contenido, id_usuario = :id_usuario WHERE id = :id");
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':contenido', $contenido, PDO::PARAM_STR);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id_entrada, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Entrada editada exitosamente.";
        } else {
            echo "Error al editar entrada.";
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
    <title>Editar Entrada</title>
</head>

<body>
    <h2>Editar Entrada</h2>

    <form method="POST" action="">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" value="<?php echo $entrada['titulo']; ?>" required>

        <label for="contenido">Contenido:</label>
        <textarea name="contenido" rows="4" required><?php echo $entrada['contenido']; ?></textarea>

        <label for="id_usuario">ID Usuario:</label>
        <input type="number" name="id_usuario" value="<?php echo $entrada['id_usuario']; ?>" required>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>

</html>
