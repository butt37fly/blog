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
( 'butt37fly', 'admin@myblog.com', '$2y$10$KlkWJX5B/Gj4i0BKOry4eeZfSPZc0/NmQf9nwHcqKIRJHUALxjocK', curdate() );

INSERT INTO entries (category_id, user_id, title, slug, content, post_date) VALUES
(1, 1, 'Mi primer entrada', 'mi-primer-entrada', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore ducimus necessitatibus iste ab porro, rem, pariatur, facere similique ipsa animi rerum magnam dicta consequatur architecto maxime nobis dignissimos voluptatum. Eaque!', '2023-09-02' ),
(2, 1, 'Mi segunda entrada', 'mi-segunda-entrada', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore ducimus necessitatibus iste ab porro, rem, pariatur, facere similique ipsa animi rerum magnam dicta consequatur architecto maxime nobis dignissimos voluptatum. Eaque!', '2023-09-02' ),
(3, 1, 'Mi tercera entrada', 'mi-tercera-entrada', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore ducimus necessitatibus iste ab porro, rem, pariatur, facere similique ipsa animi rerum magnam dicta consequatur architecto maxime nobis dignissimos voluptatum. Eaque!', '2023-09-03' ),
(1, 1, 'Mi cuarta entrada', 'mi-cuarta-entrada', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore ducimus necessitatibus iste ab porro, rem, pariatur, facere similique ipsa animi rerum magnam dicta consequatur architecto maxime nobis dignissimos voluptatum. Eaque!', '2023-09-03' ),
(2, 1, 'Mi quinta entrada', 'mi-quinta-entrada', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore ducimus necessitatibus iste ab porro, rem, pariatur, facere similique ipsa animi rerum magnam dicta consequatur architecto maxime nobis dignissimos voluptatum. Eaque!', curdate() );