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
?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../../css/css2.css">
    <title>Detalle de Entrada</title>
</head>

<body>
    <h2>Detalle de Entrada</h2>

    <p>ID: <?php echo $entrada['id']; ?></p>
    <p>Título: <?php echo $entrada['titulo']; ?></p>
    <p>Contenido: <?php echo $entrada['contenido']; ?></p>
    <p>ID Usuario: <?php echo $entrada['id_usuario']; ?></p>

    <a href="../entradas.php">Volver al Listado</a>
</body>

</html>
