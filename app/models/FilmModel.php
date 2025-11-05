<?php
require_once(__DIR__ . "/../core/Console.php");
require_once(__DIR__ . "/../core/Database.php");
class FilmModel
{
    private PDO $bdd;


    function __construct()
    {
        $this->bdd = Database::getInstance();
    }


}

class FilmEntity
{
    private ?int $id = null;
    private string $nom;
    private DateTime $date_sortie;
    private string $genre;
    private string $realisateur;
    private int $duree;

    // Constante de classe
    private const REALISATOR_NAME_MIN_LENGHT = 3;
    private const FILM_NAME_MIN_LENGHT = 1;

    private const DUREE_MIN = 10;

    private const GENRE_ALLOWED = [
        'Action',
        'Comedie',
        'Drama',
        'Fantaisie',
        'Horreur',
        'Documentaire',
        'Science-Fiction',
        'Autre'
    ];

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

    public function getGenre(): string
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

    public function setGenre(string $genre)
    {
        if (!in_array($genre, $this::GENRE_ALLOWED)) {
            throw new Error("Genre invalide, les genres acceptés sont : " . implode(", ", $this::GENRE_ALLOWED));
        } else {
            $this->genre = $genre;
        }
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

    public function __construct(?int $id = null ,string $nom, DateTime $dateDeSortie, string $genre, string $realisateur, int $duree)
    {
        $this->id = $id;
        $this->setNom($nom);
        $this->setDateDeSortie($dateDeSortie);
        $this->setGenre($genre);
        $this->setRealisateur($realisateur);
        $this->setDuree($duree);
    }
}