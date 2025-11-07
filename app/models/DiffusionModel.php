<?php

class DiffusionModel
{

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

    public function __construct(int $filmId, DateTime $dateDiffusion, ?int $id) {
        $this->id = $id;
        $this->setFilmId($filmId);
        $this->setDiffusionDate($dateDiffusion);
    }
}