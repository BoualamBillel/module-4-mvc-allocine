<?php
require_once(__DIR__ . "/Router.php");

class App {
    public static function start() {
        // Récupération de l'URI
        $uri = $_SERVER['REQUEST_URI'];

        $uri_elements = explode("/", $uri);

        $controllerName = isset($uri_elements[1]) ? $uri_elements[1] : "";
        $methodName = isset($uri_elements[2]) ? $uri_elements[2] : "index";
        $params = array_splice($uri_elements, 3);
        // Je recupere le controller
        $controller = Router::getController($controllerName);

        // Appel de la méthode view
        // La méthode view va executer la méthode en fonction de l'url
        $controller->view($methodName, $params);
    }
}