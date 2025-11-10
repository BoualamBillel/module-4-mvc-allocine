CREATE DATABASE IF NOT EXISTS `allo-cine`;
USE `allo-cine`;

CREATE TABLE IF NOT EXISTS Film (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(255) NOT NULL,
    `date` DATE NOT NULL,
    `genre` ENUM('Action', 'Comedie', 'Drama', 'Fantaisie', 'Horreur','Documentaire', 'ScienceFiction', 'Autre') NOT NULL,
    `realisateur` VARCHAR(255) NOT NULL,
    `duree` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS Diffusion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    film_id INT NOT NULL,
    date_diffusion DATETIME NOT NULL,
    FOREIGN KEY (film_id) REFERENCES Film(id) ON DELETE CASCADE
);

-- Données de test pour Film
INSERT INTO Film (nom, date, genre, realisateur, duree) VALUES
('Inception', '2010-07-16', 'Science-Fiction', 'Christopher Nolan', 148),
('Le Fabuleux Destin d\'Amélie Poulain', '2001-04-25', 'Comedie', 'Jean-Pierre Jeunet', 122),
('Interstellar', '2014-11-05', 'Science-Fiction', 'Christopher Nolan', 169),
('La Haine', '1995-05-31', 'Drama', 'Mathieu Kassovitz', 98),
('Les Visiteurs', '1993-01-27', 'Comedie', 'Jean-Marie Poiré', 107),
('Le Seigneur des Anneaux', '2001-12-19', 'Fantaisie', 'Peter Jackson', 178),
('Shining', '1980-10-02', 'Horreur', 'Stanley Kubrick', 146),
('March of the Penguins', '2005-01-26', 'Documentaire', 'Luc Jacquet', 85),
('Mad Max: Fury Road', '2015-05-13', 'Action', 'George Miller', 120),
('Autre Film', '2022-09-15', 'Autre', 'Réalisateur Inconnu', 90),
('Parasite', '2019-05-30', 'Drama', 'Bong Joon-ho', 132),
('Avengers: Endgame', '2019-04-24', 'Action', 'Anthony et Joe Russo', 181),
('Le Roi Lion', '1994-06-15', 'Fantaisie', 'Roger Allers', 88),
('La La Land', '2016-12-07', 'Comedie', 'Damien Chazelle', 128),
('Blade Runner', '1982-06-25', 'Science-Fiction', 'Ridley Scott', 117);

-- Données de test pour Diffusion
INSERT INTO Diffusion (film_id, date_diffusion) VALUES
(1, '2025-11-10 20:00:00'),
(1, '2025-11-12 18:30:00'),
(2, '2025-11-11 21:00:00'),
(3, '2025-11-13 19:00:00'),
(4, '2025-11-14 17:00:00'),
(5, '2025-11-15 16:00:00'),
(6, '2025-11-16 20:30:00'),
(7, '2025-11-17 22:00:00'),
(8, '2025-11-18 15:00:00'),
(9, '2025-11-19 20:00:00'),
(10, '2025-11-20 18:00:00'),
(11, '2025-11-21 19:30:00'),
(12, '2025-11-22 21:00:00'),
(13, '2025-11-23 14:00:00'),
(14, '2025-11-24 20:00:00'),
(15, '2025-11-25 18:00:00');