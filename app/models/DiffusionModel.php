<?php
require_once(__DIR__ . "/../core/Console.php");
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/FilmModel.php");

class DiffusionModel
{
    private PDO $bdd;
    private PDOStatement $addDiffusion;

    public function __construct()
    {
        $this->bdd = Database::getInstance();
        // Préparation des requetes préparés
        $this->addDiffusion = $this->bdd->prepare("INSERT INTO `Diffusion` (film_id, date_diffusion) VALUES (:film_id, :date_diffusion");
    }

    public function addDiffusion(int $film_id, DateTime|string $diffusion_date)
    {

        $filmModel = new FilmModel();
        if ($filmModel->verifyIfFilmAlreadyExist($film_id) === false) {
            console("Le film avec l'id $film_id n'existe pas !");
            exit();
        }
        if ($film_id <= 0) {
            console("Le filmId ne pas etre inférieur ou égal à 0");
            exit();
        }
            try {
                $date = $diffusion_date instanceof DateTime
                    ? $diffusion_date
                    : new DateTime($diffusion_date);
            } catch (Exception $e) {
                console("Erreur lors de la conversion de la date de diffusion en DateTime");
                exit();
            }
        
        $this->addDiffusion->execute([
            ":film_id" => $film_id,
            ":date_diffusion" => $date->format("Y-m-d H:i:s")
        ]);
    }
}

class DiffusionEntity
{
    private ?int $id = null;
    private int $filmId;
    private DateTime $dateDiffusion;

    // Constante de classe
    private const MINIMUM_FILM_ID = 1;

    //Getter
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilmId(): int
    {
        return $this->filmId;
    }

    public function getDiffusionDate(): DateTime
    {
        return $this->dateDiffusion;
    }

    // Setter
    public function setFilmId(int $filmId): void
    {
        if ($filmId < self::MINIMUM_FILM_ID) {
            throw new Error("filmId doit être supérieur ou égal à " . self::MINIMUM_FILM_ID);
        }
        $this->filmId = $filmId;
    }

    public function setDiffusionDate(string|DateTime $dateDiffusion): void
    {
        if (is_string($dateDiffusion)) {
            try {
                $date = new DateTime($dateDiffusion);
            } catch (Exception $e) {
                console("Format de date invalide : " . $dateDiffusion);
            }
        } elseif ($dateDiffusion instanceof DateTime) {
            $date = $dateDiffusion;
        } else {
            throw new InvalidArgumentException("La date doit etre une string ou un objet DateTime");
        }
        $this->dateDiffusion = $date;
    }

    public function __construct(int $filmId, DateTime $dateDiffusion, ?int $id)
    {
        $this->id = $id;
        $this->setFilmId($filmId);
        $this->setDiffusionDate($dateDiffusion);
    }
}