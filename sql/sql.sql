

CREATE TABLE IF NOT EXISTS Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    perfil ENUM('admin', 'user') NOT NULL
);

CREATE TABLE IF NOT EXISTS Entradas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id)
);

CREATE TABLE IF NOT EXISTS Categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);
--admin
INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `perfil`) VALUES (NULL, 'admin', 'admin', 'admin@admin.es', '$2y$10$wgLGjHpNZXIRF7sYu.30wexmpUlTvLNdq9jv9ExT3s6x1IiAAqZVW', 'admin');

--user
INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `perfil`) VALUES (NULL, 'user', 'user', 'user@user.es', '$2y$10$XRXd/5kkxCjU7Nmvipl8mOG0QjI28hgR.9Ay/WWQH0FaSsIszdMqa', 'user');

--añadimos el campo imagen
ALTER TABLE Usuarios
ADD COLUMN imagen VARCHAR(255) DEFAULT NULL;
ALTER TABLE Entradas
ADD COLUMN imagen VARCHAR(255) DEFAULT NULL;

--tabla log
CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha_hora DATETIME,
    usuario VARCHAR(255),
    tipo_operacion VARCHAR(255)
);

--log
DELIMITER //

CREATE PROCEDURE InsertarLog(
    IN p_fecha_hora DATETIME,
    IN p_usuario VARCHAR(255),
    IN p_tipo_operacion VARCHAR(255)
)
BEGIN
    INSERT INTO logs (fecha_hora, usuario, tipo_operacion)
    VALUES (p_fecha_hora, p_usuario, p_tipo_operacion);
END //

DELIMITER ;
