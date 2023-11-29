<?php
session_start();
include '../../../conecta.php';

// Función para obtener la conexión a la base de datos
function obtenerConexion()
{
    global $host, $usuario, $contrasena, $base_datos;
    try {
        $conexion = new PDO("mysql:host=$host;dbname=$base_datos", $usuario, $contrasena);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->exec("SET NAMES utf8");
        return $conexion;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

// Función para obtener todos los registros de la tabla 'logs'
function obtenerRegistrosLogs()
{
    $conexion = obtenerConexion();
    $stmt = $conexion->query("SELECT * FROM logs");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Eliminar registro de la tabla 'logs'
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $idEliminar = $_GET['eliminar'];
    $conexion = obtenerConexion();

    try {
        $stmt = $conexion->prepare("DELETE FROM logs WHERE id = :id");
        $stmt->bindParam(':id', $idEliminar, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: gestionlog.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al eliminar el registro: " . $e->getMessage();
    }
}

// Obtener registros de la tabla 'logs'
$registrosLogs = obtenerRegistrosLogs();

// Cierre de conexión
$conexion = null;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/gestion_logs.css">
    <title>Gestión de Registros de Logs</title>
</head>

<body>
    <center>
        <h2>Gestión de Registros de Logs</h2>
    </center>

    <table>
        <tr>
            <th>ID</th>
            <th>Fecha y Hora</th>
            <th>Usuario</th>
            <th>Tipo de Operación</th>
            <th>Acciones</th>
        </tr>

        <?php foreach ($registrosLogs as $registro): ?>
            <tr>
                <td><?php echo $registro['id']; ?></td>
                <td><?php echo $registro['fecha_hora']; ?></td>
                <td><?php echo $registro['usuario']; ?></td>
                <td><?php echo $registro['tipo_operacion']; ?></td>
                <td>
                    <a href="?eliminar=<?php echo $registro['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este registro?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- pdf -->
    <a href="imprimir.php" target="_blank">Generar PDF</a>
</body>

</html>
