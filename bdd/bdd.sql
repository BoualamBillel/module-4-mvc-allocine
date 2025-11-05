CREATE DATABASE IF NOT EXISTS `allo-cine`;
USE `allo-cine`;

CREATE TABLE IF NOT EXISTS Film (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `date` DATE NOT NULL,
    `genre` ENUM('Action', 'Comedie', 'Drama', 'Fantasie', 'Horreur','Documentaire', 'Science-Fiction', 'Autre') NOT NULL,
    `realisateur` VARCHAR(255) NOT NULL,
    `duree` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS Diffusion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    film_id INT NOT NULL,
    date_diffusion DATETIME NOT NULL,
    FOREIGN KEY (film_id) REFERENCES Film(id)
);