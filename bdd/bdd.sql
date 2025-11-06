CREATE DATABASE IF NOT EXISTS `allo-cine`;
USE `allo-cine`;

CREATE TABLE IF NOT EXISTS Film (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `date` DATE NOT NULL,
    `genre` ENUM('Action', 'Comedie', 'Drama', 'Fantaisie', 'Horreur','Documentaire', 'Science-Fiction', 'Autre') NOT NULL,
    `realisateur` VARCHAR(255) NOT NULL,
    `duree` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS Diffusion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    film_id INT NOT NULL,
    date_diffusion DATETIME NOT NULL,
    FOREIGN KEY (film_id) REFERENCES Film(id)
);


-- Données de test
INSERT INTO Film (nom, date, genre, realisateur, duree) VALUES
('Inception', '2010-07-16', 'ScienceFiction', 'Christopher Nolan', 148),
('Le Fabuleux Destin d\'Amélie Poulain', '2001-04-25', 'Comedie', 'Jean-Pierre Jeunet', 122),
('Interstellar', '2014-11-05', 'ScienceFiction', 'Christopher Nolan', 169),
('La Haine', '1995-05-31', 'Drama', 'Mathieu Kassovitz', 98),
('Les Visiteurs', '1993-01-27', 'Comedie', 'Jean-Marie Poiré', 107),
('Le Seigneur des Anneaux', '2001-12-19', 'Fantaisie', 'Peter Jackson', 178),
('Shining', '1980-10-02', 'Horreur', 'Stanley Kubrick', 146),
('March of the Penguins', '2005-01-26', 'Documentaire', 'Luc Jacquet', 85),
('Mad Max: Fury Road', '2015-05-13', 'Action', 'George Miller', 120),
('Autre Film', '2022-09-15', 'Autre', 'Réalisateur Inconnu', 90);