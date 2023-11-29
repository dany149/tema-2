<?php
session_start();
include '../../../../conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    try {
        $stmt = $conexion->prepare("SELECT * FROM Usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            echo "Usuario no encontrado.";
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
    <title>Detalle de Usuario</title>
</head>

<body>
    <h2>Detalle de Usuario</h2>

    <p>ID: <?php echo $usuario['id']; ?></p>
    <p>Nombre: <?php echo $usuario['nombre']; ?></p>
    <p>Apellido: <?php echo $usuario['apellido']; ?></p>
    <p>Email: <?php echo $usuario['email']; ?></p>
    <p>Perfil: <?php echo $usuario['perfil']; ?></p>

    <a href="../usuarios.php">Volver al Listado</a>
</body>

</html>
