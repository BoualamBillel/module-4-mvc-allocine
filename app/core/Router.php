<?php
require_once(__DIR__ . "/../controllers/FilmController.php");
require_once(__DIR__ . "/../controllers/DiffusionController.php");

class Router {
    public static function getController(string $controllerName) {
        switch ($controllerName) {
            // Route /film
            case "":
            case "film":
                return new FilmController();
            case "diffusion":
                return new DiffusionController();
        }
    }
}