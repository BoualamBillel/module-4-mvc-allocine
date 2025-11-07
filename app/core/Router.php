<?php
require_once(__DIR__ . "/../controllers/FilmController.php");

class Router {
    public static function getController(string $controllerName) {
        switch ($controllerName) {
            // Route /film
            case "":
                return new FilmController();
        }
    }
}