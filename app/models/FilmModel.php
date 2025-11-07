<?php
require_once(__DIR__ . "/../core/Console.php");
require_once(__DIR__ . "/../core/Database.php");

// Creation du type ENUM
enum GENRE_ALLOWED: string
{
    case Action = "Action";
    case Comedie = "Comedie";
    case Drama = "Drama";
    case Fantaisie = "Fantaisie";
    case Horreur = "Horreur";
    case Documentaire = "Documentaire";
    case ScienceFiction = "ScienceFiction";
    case Autre = "Autre";
}
class FilmModel
{
    private PDO $bdd;
    private PDOStatement $add_film;
    private PDOStatement $get_all_films;
    private PDOStatement $get_film_by_id;
    private PDOStatement $verifyIfFilmAlreadyExist;
    private PDOStatement $delete_film;


    function __construct()
    {
        // Instanciation de la BDD
        $this->bdd = Database::getInstance();
        // Préparations des requetes préparés
        $this->add_film = $this->bdd->prepare("INSERT INTO `Film`(nom, date, genre,  realisateur, duree) VALUES (:nom, :date, :genre, :realisateur, :duree)");
        $this->get_all_films = $this->bdd->prepare("SELECT * FROM `Film`");
        $this->get_film_by_id = $this->bdd->prepare("SELECT * FROM `Film`WHERE id = :id");
        $this->verifyIfFilmAlreadyExist = $this->bdd->prepare("SELECT * FROM `Film`WHERE id = :id");
        $this->delete_film = $this->bdd->prepare("DELETE * FROM `Film` WHERE id = :id");
    }

    // Renvoit True si le film existe
    public function verifyIfFilmAlreadyExist(int $id): bool
    {
        if ($id <= 0) {
            console("L'id du film recherché ne peut pas etre inférieur ou égal à 0");
            exit();
        } else {
            try {
                $this->verifyIfFilmAlreadyExist->bindValue(":id", $id);
                $this->verifyIfFilmAlreadyExist->execute();
                $result = $this->verifyIfFilmAlreadyExist->fetch();
            } catch (PDOException $e) {
                console("Erreur lors de la recherche de film par id");
                exit();
            }
            if ($result === false) {
                return false;
            } else {
                return true;
            }
        }
    }
    public function add_film(string $nom, DateTime $date, string $genre, string $realisateur, int $duree)
    {
        $filmAlreadyExist = $this->verifyIfFilmAlreadyExist($nom);
        if ($filmAlreadyExist === true) {
            console("Un film avec ce nom existe deja dans la BDD");
            exit();
        } else {
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
    }

    public function get_all_films(): array
    {

        try {
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
                // Conversion de la date en type DateTime
                $filmDateTime = new DateTime($film["date"]);
                $genre_str = GENRE_ALLOWED::from($film["genre"]);
                console($genre_str);

                $filmEntity[] = new FilmEntity(
                    $film['nom'],
                    $filmDateTime,
                    $genre_str,
                    $film['realisateur'],
                    $film['duree'],
                    $film['id']
                );
            }

            return $filmEntity;
        }
    }

    public function get_film_by_id($id): FilmEntity
    {
        if ($id <= 0) {
            console("L'id ne peut pas etre inférieur ou égal à 0");
            exit();
        } else {
            try {
                $this->get_film_by_id->bindValue(":id", $id);
                $this->get_film_by_id->execute();
                $rawFilm = $this->get_film_by_id->fetch();
            } catch (PDOException $e) {
                console("Erreur SQL lors de la récupération du film par ID : " . $e->getMessage());
                exit();
            }
            if ($rawFilm === false) {
                console("Aucun film trouvé avec cet id");
                exit();
            } else {
                $film = new FilmEntity(
                    $rawFilm['id'],
                    $rawFilm['nom'],
                    $rawFilm['date'],
                    $rawFilm['genre'],
                    $rawFilm['realisateur'],
                    $rawFilm['duree']
                );
                return $film;
            }
        }
    }

    public function delete_film($id)
    {
        if ($id <= 0) {
            console("L'id ne peut pas etre inférieur ou égal à 0");
            exit();
        } else {
            try {
                $this->delete_film->bindValue(":id", $id);
                $this->delete_film->execute();
                console("Film avec l'ID " . $id . " supprimé avec succès !");
            } catch (PDOException $e) {
                console("Erreur SQL lors de la suppresion d'un film");
                exit();
            }
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

    public function __construct(string $nom, DateTime $dateDeSortie, GENRE_ALLOWED $genre, string $realisateur, int $duree, ?int $id = null)
    {
        $this->id = $id;
        $this->setNom($nom);
        $this->setDateDeSortie($dateDeSortie);
        $this->setGenre($genre);
        $this->setRealisateur($realisateur);
        $this->setDuree($duree);
    }
}