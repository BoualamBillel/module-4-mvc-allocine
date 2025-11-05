<?php
require_once(__DIR__ . "/../core/Console.php");
class Database
{

    public static function getInstance(): PDO
    {
        try {
            return new PDO(
                "mysql:host=bdd;dbname=allo-cine;charset=utf8",
                "root",
                "root",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

        } catch (PDOException $e) {
            console("Erreur de connexion à la BDD : " . $e->getMessage());
            exit();
        }

    }
}