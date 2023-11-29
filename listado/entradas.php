<?php
session_start();
include '../../../conecta.php';

// Conecta a la base de datos
function obtenerConexion() {
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

// Obtener listado de entradas
function obtenerEntradas() {
    $conexion = obtenerConexion();
    $stmt = $conexion->query("SELECT * FROM Entradas ORDER BY fecha_creacion DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Cierre de conexión
$conexion = null;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/css3.css">
    <title>Listado de Entradas</title>
    
</head>

<body>
    <center>
        <h2>Listado de Entradas</h2>
    </center>

    <?php
    // Obtener listado de entradas
    $entradas = obtenerEntradas();
    ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Contenido</th>
            <th>Fecha de Creación</th>
            <th>ID Usuario</th>
            <th>Imagen</th>
            <th>Operaciones</th>
        </tr>

        <?php foreach ($entradas as $entrada) : ?>
            <tr>
                <td><?php echo $entrada['id']; ?></td>
                <td><?php echo $entrada['titulo']; ?></td>
                <td><?php echo $entrada['contenido']; ?></td>
                <td><?php echo $entrada['fecha_creacion']; ?></td>
                <td><?php echo $entrada['id_usuario']; ?></td>
                <td><img src="<?php echo $entrada['imagen']; ?>" alt="Imagen de la entrada" style="max-width: 50px;"></td>
                <td>
                    <!-- Enlaces de operaciones según el perfil del usuario -->
                    <a href='operaciones/editar_entrada.php?id=<?php echo $entrada['id']; ?>'>Editar</a>
                    | <a href='operaciones/eliminar_entrada.php?id=<?php echo $entrada['id']; ?>'>Eliminar</a>
                    | <a href='operaciones/detalle_entrada.php?id=<?php echo $entrada['id']; ?>'>Detalle</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>
