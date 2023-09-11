DROP DATABASE IF EXISTS blog;

CREATE DATABASE blog;

USE blog;

DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
  id int auto_increment NOT NULL,
  name varchar(50) NOT NULL,
  slug varchar(50) NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS users; 

CREATE TABLE users (
  id int auto_increment NOT NULL,
  username varchar(20) NOT NULL unique,
  email varchar(50) NOT NULL unique,
  password varchar(255) NOT NULL,
  reg_date date NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS entries;

CREATE TABLE entries (
  id int auto_increment NOT NULL,
  category_id int NOT NULL,
  user_id int NOT NULL,
  title varchar(250) NOT NULL,
  slug varchar(250) NOT NULL,
  content MEDIUMTEXT NOT NULL,
  post_date date NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(category_id) REFERENCES categories(id),
  FOREIGN KEY(user_id) REFERENCES users(id)
) ENGINE=InnoDB;

INSERT INTO categories (name, slug) VALUES
('Acción', 'accion'),
('SandBox', 'sandbox'),
('Musical', 'musical'),
('Novela gráfica', 'novela-grafica'),
('Terror psicológico', 'terror-psicologico');

INSERT INTO users (username, email, password, reg_date) VALUES
( 'butt37fly', 'admin@myblog.com', '$2y$10$i.ivTZnhG4vywALVhgFx4u.pPBYbuw5S2yJJ5AGGbnpDtwTF.9qwu', curdate() );

INSERT INTO entries (category_id, user_id, title, slug, content, post_date) VALUES
(1, 1, 'Call Of Duty: Modern Warfare', 'call-of-duty-modern-warfare', 'Call of Duty: Modern Warfare es un videojuego de disparos en primera persona desarrollado por Infinity Ward y publicado por Activision. Es el decimosexto juego de la saga Call of Duty y es un reinicio de la serie Modern Warfare. Fue lanzado el 25 de octubre de 2019.', '2023-09-02' ),
(2, 1, 'Grand Theft Auto: Vice City', 'grand-theft-auto-vice-city', 'Grand Theft Auto: Vice City, es un videojuego de acción-aventura de mundo abierto en tercera persona. Es el quinto título de la serie Grand Theft Auto y el segundo en gráficos 3D. Se trabajó en una versión para Nintendo GameCube pero fue cancelada por razones desconocidas.', '2023-09-02' ),
(3, 1, 'Arcaea', 'arcaea', 'Arcaea es un videojuego de ritmo desarrollado y publicado por Lowiro. El juego se lanzó en las plataformas móviles iOS y Android el 9 de marzo de 2017. El 18 de mayo de 2021 se lanzó una versión del juego para un solo jugador para Nintendo Switch.', '2023-09-03' ),
(1, 1, 'Mortal Kombat X', 'mortal-kombat-xx', 'Mortal Kombat X es un videojuego de lucha creado por Ed Boon, desarrollado por NetherRealm Studios y publicado por Warner Bros. Interactive Entertainment, fue anunciado en junio de 2014, mediante un vídeo que mostraba a Sub-Zero y Scorpion peleando entre sí.', '2023-09-03' ),
(5, 1, 'Silent Hill 2', 'silent-hill-2', 'Silent Hill 2 es un videojuego de terror del subgénero de horror de supervivencia, desarrollado por Team Silent y publicado por Konami. Fue lanzado para PlayStation 2 en los Estados Unidos el 24 de septiembre de 2001, tres días después, en Japón, y el 23 de noviembre del mismo año, en Europa.', '2023-09-03' ),
(2, 1, 'Red Dead Redemption', 'red-dead-redemption', 'Red Dead Redemption es un videojuego no lineal de acción-aventura wéstern desarrollado por Rockstar San Diego. El videojuego fue anunciado oficialmente el 4 de febrero de 2009, y se lanzó el 18 de mayo de 2010 en Norteamérica y el 21 de mayo en Europa y Australia para Xbox 360 y PlayStation 3.', curdate() );