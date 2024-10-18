-- Créer la base de données
CREATE DATABASE IF NOT EXISTS cv_db;

-- Utiliser la base de données
USE cv_db;

CREATE TABLE IF NOT EXISTS admins (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Insérer un utilisateur admin (le mot de passe doit être haché en utilisant la fonction password_hash('password123', PASSWORD_DEFAULT) de PHP)
INSERT INTO admins (username, password) 
VALUES ('admin', '$2y$10$ybOP3hulir7vLGAC4A8xUe9nAEAVnGZHsPWcdo7.EWUANkcKwFVLi'); -- Mot de passe : password123

-- Créer la table Users
CREATE TABLE IF NOT EXISTS Users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Créer la table pour les informations personnelles
CREATE TABLE IF NOT EXISTS personal_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    Users_id INT Not NULL,
    name VARCHAR(100) NOT NULL,
    title VARCHAR(150) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    profile_description TEXT NOT NULL,
    FOREIGN KEY (Users_id) REFERENCES Users(id) ON DELETE CASCADE
);

-- Créer la table pour le CV
CREATE TABLE IF NOT EXISTS CV (
    id INT PRIMARY KEY AUTO_INCREMENT,
    Users_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    name VARCHAR(100) NOT NULL,
    profil VARCHAR(100) NOT NULL,
    contact VARCHAR(100) NOT NULL,
    competence VARCHAR(150) NOT NULL,
    centre_interet VARCHAR(150) NOT NULL,
    formation VARCHAR(150) NOT NULL,
    experience VARCHAR(150) NOT NULL,
    FOREIGN KEY (Users_id) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS CV_public (
    id INT PRIMARY KEY AUTO_INCREMENT,
    CV_id INT NOT NULL,
    FOREIGN KEY (CV_id) REFERENCES CV(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS project (
    id INT PRIMARY KEY AUTO_INCREMENT,
    User_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    FOREIGN KEY (User_id) REFERENCES Users(id) ON DELETE CASCADE
);