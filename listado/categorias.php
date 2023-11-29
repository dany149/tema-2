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

// Obtener listado de categorías
function obtenerCategorias() {
    $conexion = obtenerConexion();
    $stmt = $conexion->query("SELECT * FROM Categorias");
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
    <title>Listado de Categorías</title>
    
</head>

<body>
    <center>
        <h2>Listado de Categorías</h2>
    </center>

    <?php
    // Obtener listado de categorías
    $categorias = obtenerCategorias();
    ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Operaciones</th>
        </tr>

        <?php foreach ($categorias as $categoria) : ?>
            <tr>
                <td><?php echo $categoria['id']; ?></td>
                <td><?php echo $categoria['nombre']; ?></td>
                <td>
                    <!-- Enlaces de operaciones según el perfil del usuario -->
                    <a href='operaciones/editar_categoria.php?id=<?php echo $categoria['id']; ?>'>Editar</a>
                    | <a href='operaciones/eliminar_categoria.php?id=<?php echo $categoria['id']; ?>'>Eliminar</a>
                    | <a href='operaciones/detalle_categoria.php?id=<?php echo $categoria['id']; ?>'>Detalle</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>
