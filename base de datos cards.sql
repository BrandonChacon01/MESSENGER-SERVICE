CREATE DATABASE cards CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cards;

CREATE TABLE users(
  id_user INT(12) AUTO_INCREMENT NOT NULL PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(200)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE administrador(
  id_user INT(12) AUTO_INCREMENT NOT NULL PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(200)
);

CREATE TABLE mensajes(
 id_mensaje INT(12) AUTO_INCREMENT NOT NULL PRIMARY KEY,
 user_id INT(12),
 mensaje TEXT,
 FOREIGN KEY (user_id) REFERENCES users(id_user)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE respuesta(
id_respuesta INT(12) AUTO_INCREMENT NOT NULL PRIMARY KEY,
 user_id INT(12),
 respuesta TEXT,
 FOREIGN KEY (user_id) REFERENCES users(id_user)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

insert into administrador(username, password) values
		('Brandon','$2y$10$gTfj56VUAzP7VjQb2Lbqqe/lEzIg.AWaRJTdvoSEpb1EuwA.dXtGq');

insert into users(username, password) values
		('Addai','$2y$10$z2yKqILtrOAmq4lGtKNosuk3oIWibipug0AyNoTwRqvIPFbXSVqzO');

INSERT INTO mensajes (user_id, mensaje) VALUES 
		('1', 'Mensaje');
        
INSERT INTO respuesta(user_id, respuesta) VALUES
		('1', 'Hola Brandon');

