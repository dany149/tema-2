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

// Obtener listado de usuarios
function obtenerUsuarios() {
    $conexion = obtenerConexion();
    $stmt = $conexion->query("SELECT * FROM Usuarios");
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
    <title>Listado de Usuarios</title>
    
</head>

<body>
    <center>
        <h2>Listado de Usuarios</h2>
    </center>

    <?php
    // Obtener listado de usuarios
    $usuarios = obtenerUsuarios();
    ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Perfil</th>
            <th>Operaciones</th>
        </tr>

        <?php foreach ($usuarios as $usuario) : ?>
            <tr>
                <td><?php echo $usuario['id']; ?></td>
                <td><?php echo $usuario['nombre']; ?></td>
                <td><?php echo $usuario['apellido']; ?></td>
                <td><?php echo $usuario['email']; ?></td>
                <td><?php echo $usuario['perfil']; ?></td>
                <td>
                    <!-- Enlaces de operaciones según el perfil del usuario -->
                    <a href='operaciones/editar_usuario.php?id=<?php echo $usuario['id']; ?>'>Editar</a>
                    | <a href='operaciones/eliminar_usuario.php?id=<?php echo $usuario['id']; ?>'>Eliminar</a>
                    
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>
