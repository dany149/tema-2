<?php
session_start();
// Incluir el script de conexión a la base de datos
include '../../../conecta.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $perfil = $_POST['perfil'];

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Procesar la imagen
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_temp = $_FILES['imagen']['tmp_name'];
    $imagen_ruta = "../../../images/" . $imagen_nombre;

    // Mover la imagen al directorio de imágenes
    move_uploaded_file($imagen_temp, $imagen_ruta);

    try {
        // Insertar nuevo usuario en la base de datos
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, apellido, email, password, perfil, imagen) VALUES (:nombre, :apellido, :email, :password, :perfil, :imagen)");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':perfil', $perfil, PDO::PARAM_STR);
        $stmt->bindParam(':imagen', $imagen_ruta, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $mensaje_exito = "Usuario agregado exitosamente.";
        } else {
            $mensaje_error = "Error al agregar usuario.";
        }
    } catch (PDOException $e) {
        $mensaje_error = "Error de base de datos: " . $e->getMessage();
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
    <title>Agregar Usuario</title>
</head>

<body>
    <center>
    <h1>Agregar Nuevo Usuario</h1>
    </center>
    <!-- Mostrar mensaje de éxito o error, si existen -->
    <?php if (isset($mensaje_exito)) : ?>
        <div style="color: green;"><?php echo $mensaje_exito; ?></div>
    <?php endif; ?>

    <?php if (isset($mensaje_error)) : ?>
        <div style="color: red;"><?php echo $mensaje_error; ?></div>
    <?php endif; ?>

    <!-- Formulario para agregar usuarios -->
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>

        <label for="perfil">Perfil:</label>
        <select name="perfil" required>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>

        <label for="imagen">Imagen de perfil:</label>
        <input type="file" name="imagen" accept="image/*">

        <button type="submit">Agregar Usuario</button>
    </form>
    <a href="../../cerrar.php">Cerrar Sesión</a>
</body>

</html>
