<?php
session_start();
include '../../../../conecta.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    try {
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $perfil = $_POST['perfil'];

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $conexion->prepare("UPDATE Usuarios SET nombre = :nombre, apellido = :apellido, email = :email, password = :password, perfil = :perfil WHERE id = :id");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':perfil', $perfil, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Usuario editado exitosamente.";
        } else {
            echo "Error al editar usuario.";
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
    <title>Editar Usuario</title>
</head>

<body>
    <h2>Editar Usuario</h2>

    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" value="<?php echo $usuario['apellido']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>

        <label for="perfil">Perfil:</label>
        <select name="perfil" required>
            <option value="admin" <?php echo ($usuario['perfil'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="user" <?php echo ($usuario['perfil'] === 'user') ? 'selected' : ''; ?>>User</option>
        </select>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>

</html>
