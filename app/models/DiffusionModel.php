<?php
require_once(__DIR__ . "/../core/Console.php");
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/FilmModel.php");

class DiffusionModel
{
    private PDO $bdd;
    private PDOStatement $getAllDiffusion;
    private PDOStatement $addDiffusion;
    private PDOStatement $verifyIfDiffusionExist;
    private PDOStatement $deleteDiffusion;
    private PDOStatement $getDiffusionInfo;
    public function __construct()
    {
        $this->bdd = Database::getInstance();
        // Préparation des requetes préparés
    $this->getAllDiffusion = $this->bdd->prepare("SELECT Diffusion.*, Film.nom AS film_nom FROM Diffusion JOIN Film ON Diffusion.film_id = Film.id");
        $this->addDiffusion = $this->bdd->prepare("INSERT INTO `Diffusion` (film_id, date_diffusion) VALUES (:film_id, :date_diffusion)");
        $this->verifyIfDiffusionExist = $this->bdd->prepare("SELECT * FROM `Diffusion` WHERE id = :id");
        $this->deleteDiffusion = $this->bdd->prepare("DELETE  FROM `Diffusion` WHERE id = :id");
        $this->getDiffusionInfo = $this->bdd->prepare("SELECT * FROM `Diffusion` WHERE film_id = :film_id");

    }

    public function getAllDiffusion()
    {
        try {
            $this->getAllDiffusion->execute();
            $result = $this->getAllDiffusion->fetchAll();
        } catch (PDOException $e) {
            console("Erreur SQL lors de la récupération de toutes les diffusions : " . $e);
            exit();
        }
        if (!$result) {
            console("Aucune diffusion trouvée");
            return [];
        } else {
            return $result;
        }
    }
    public function addDiffusion(int $film_id, DateTime|string $diffusion_date)
    {

        $filmModel = new FilmModel();
        if ($film_id <= 0) {
            console("Le filmId ne pas etre inférieur ou égal à 0");
            exit();
        }
        if ($filmModel->verifyIfFilmAlreadyExist($film_id) === false) {
            console("Le film avec l'id $film_id n'existe pas !");
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

    // Renvoit True si la diffusion existe
    public function verifyIfDiffusionExist($id): bool
    {
        if ($id <= 0) {
            console("L'id de diffusion ne peut pas inférieur ou égal à 0");
            exit();
        }
        try {
            $this->verifyIfDiffusionExist->bindValue(":id", $id);
            $this->verifyIfDiffusionExist->execute();
            $result = $this->verifyIfDiffusionExist->fetch();
        } catch (PDOException $e) {
            console("Erreur SQL lors de la verification d'existence de la séance par id : " . $e->getMessage());
            exit();
        }
        if ($result === false) {
            return false;
        } else {
            return true;
        }
    }

    public function deleteDiffusion($id)
    {
        if ($id <= 0) {
            console("L'id de diffusion ne peut pas inférieur ou égal à 0");
            exit();
        }
        try {
            $this->deleteDiffusion->bindValue(":id", $id);
            $this->deleteDiffusion->execute();
        } catch (PDOException $e) {
            console("Erreur SQL lors de la suppresion de la diffusion " . $id . " : " . $e->getMessage());
            exit();
        }
    }

    public function getDiffusionInfo($film_id)
    {
        if ($film_id <= 0) {
            console("L'id de diffusion ne peut pas inférieur ou égal à 0");
            exit();
        }
        try {
            $this->getDiffusionInfo->execute([
                ":film_id" => $film_id
            ]);
            $result = $this->getDiffusionInfo->fetchAll();
        } catch (PDOException $e) {
            console("Erreur SQL lors de la récupération des infos de diffusion du film ID = " . $film_id . " : " . $e->getMessage());
            exit();
        }
        if (!$result) {
            console("Aucune diffusion trouvé");
            return [];
        } else {
            return $result;
        }
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
                exit();
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