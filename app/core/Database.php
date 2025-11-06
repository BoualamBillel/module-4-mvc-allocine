<?php
require_once(__DIR__ . "/../core/Console.php");
class Database
{


    private function __construct()
    {
    }

    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    "mysql:host=bdd;dbname=allo-cine;charset=utf8",
                    "root",
                    "root",
                    [
                        PDO::ATTR_ERRMODE => pdo::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
                console("Connexion BDD Crée");
            } catch (PDOException $e) {
                
                console("Erreur de connexion à la BDD : " . $e->getMessage());
                console("SQL CODE n°".$e->getCode());

                exit();
            }
        }
        return self::$instance;

    }
}