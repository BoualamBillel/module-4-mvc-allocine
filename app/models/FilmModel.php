<?php
require_once(__DIR__ . "/../core/Console.php");
require_once(__DIR__ . "/../core/Database.php");

// Creation du type ENUM
enum GENRE_ALLOWED
{
    case Action;
    case Comedie;
    case Drama;
    case Fantaisie;
    case Horreur;
    case Documentaire;
    case ScienceFiction;
    case Autre;
}
class FilmModel
{
    private PDO $bdd;
    private PDOStatement $add_film;
    private PDOStatement $get_all_films;


    function __construct()
    {
        // Instanciation de la BDD
        $this->bdd = Database::getInstance();
        // Préparations des requetes préparés
        $this->add_film = $this->bdd->prepare("INSERT INTO `Film`(nom, date, genre,  realisateur, duree) VALUES (:nom, :date, :genre, :realisateur, :duree)");
        $this->get_all_films = $this->bdd->prepare("SELECT * FROM `Film LIMIT :limit");
    }

    public function add_film(string $nom, DateTime $date, string $genre, string $realisateur, int $duree)
    {
        // TODO - Verifier si le film n'existe pas deja dans la BDD
        try {
            $this->add_film->bindValue(":nom", $nom);
            $this->add_film->bindValue(":date", $date->format('Y-m-d'));
            $this->add_film->bindValue(":genre", $genre);
            $this->add_film->bindValue(":realisateur", $realisateur);
            $this->add_film->bindValue(":duree", $duree);
            $this->add_film->execute();

            // Message de succès
            console("Film ajouté avec succès : $nom ($genre, $duree min)");
        } catch (PDOException $e) {
            // Message d'erreur
            console("Erreur lors de l'ajout d'un film dans la BDD : " . $e->getMessage());
            exit();
        }
    }

    public function get_all_films(int $limit): array
    {
        if ($limit <= 0) {
            console("La limite de récupération de films présent dans la BDD ne peut pas etre égale ou inférieure à 0");
            exit();
        }

        try {
            $this->get_all_films->bindValue(":limit", $limit);
            $this->get_all_films->execute();
            $raw_films = $this->get_all_films->fetchAll();
        } catch (PDOException $e) {
            console("Erreur SQL lors de la récupération des films de la BDD : " . $e->getMessage());
            exit();
        }

        if (count($raw_films) <= 0) {
            console("Aucun film présent dans la BDD");
            exit();
        } else {
            // Formater la réponse dans un tableau
            $filmEntity = [];
            foreach ($raw_films as $film) {
                $filmEntity[] = new FilmEntity(
                    $film['id'],
                    $film['nom'],
                    $film['date'],
                    $film['genre'],
                    $film['realisateur'],
                    $film['duree']
                );
            }
            return $filmEntity;
        }
    }

}


class FilmEntity
{
    private ?int $id = null;
    private string $nom;
    private DateTime $date_sortie;
    private GENRE_ALLOWED $genre;
    private string $realisateur;
    private int $duree;

    // Constante de classe
    private const REALISATOR_NAME_MIN_LENGHT = 3;
    private const FILM_NAME_MIN_LENGHT = 1;

    private const DUREE_MIN = 10;


    //Getter
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getDateDeSortie(): DateTime
    {
        return $this->date_sortie;
    }

    public function getGenre(): GENRE_ALLOWED
    {
        return $this->genre;
    }

    public function getRealisateur(): string
    {
        return $this->realisateur;
    }

    public function getDuree(): int
    {
        return $this->duree;
    }

    // Setter
    public function setNom(string $nom)
    {
        if (strlen($nom) < $this::FILM_NAME_MIN_LENGHT) {
            throw new Error("Le nom du film est trop court, le nombre minimum de caractères est de  " . $this::FILM_NAME_MIN_LENGHT);
        } else {
            $this->nom = $nom;
        }
    }

    public function setDateDeSortie(string|DateTime $dateDeSortie)
    {
        if (is_string($dateDeSortie)) {
            try {
                $date = new DateTime(($dateDeSortie));
            } catch (Exception $e) {
                throw new InvalidArgumentException("Format de date invalide : " . $dateDeSortie);
            }
        } elseif ($dateDeSortie instanceof DateTime) {
            $date = $dateDeSortie;
        } else {
            throw new InvalidArgumentException("La date doit etre une string ou un objet DateTime");
        }
        $this->date_sortie = $date;
    }

    public function setGenre(GENRE_ALLOWED $genre)
    {
        // Verifie la valeur si la valeur de $genre fait des partie des cases presentes dans l'enumération de genre autorisés
        if (!in_array($genre, GENRE_ALLOWED::cases())) {
            console("Erreur : genre non autorisé (" . $genre->name . ")");
            throw new Error("Genre invalide, les genres acceptés sont : " . implode(", ", array_map(fn($g) => $g->name, GENRE_ALLOWED::cases())));
        }
        $this->genre = $genre;
    }

    public function setRealisateur(string $realisateur)
    {
        if (strlen($realisateur) < $this::REALISATOR_NAME_MIN_LENGHT) {
            throw new Error("Le nom du réalisateur est trop court, le nombre minimum de caractères est de " . $this::REALISATOR_NAME_MIN_LENGHT);
        } else {
            $this->realisateur = $realisateur;
        }
    }

    public function setDuree(int $duree)
    {
        if ($duree < $this::DUREE_MIN) {
            throw new Error("La durée du film est invalide, la durée minimum est de " . $this::DUREE_MIN);
        } else {
            $this->duree = $duree;
        }
    }

    public function __construct(?int $id = null, string $nom, DateTime $dateDeSortie, GENRE_ALLOWED $genre, string $realisateur, int $duree)
    {
        $this->id = $id;
        $this->setNom($nom);
        $this->setDateDeSortie($dateDeSortie);
        $this->setGenre($genre);
        $this->setRealisateur($realisateur);
        $this->setDuree($duree);
    }
}