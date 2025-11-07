<?php
require_once(__DIR__ . "/../models/FilmModel.php");
class FilmController
{
    public function view(string $method, array $params = []){
        try {
            call_user_func([$this, $method], $params);
        } catch (Error $e) {
            console($e->getMessage());
        }
    }   
    public function index()
    {
        $filmModel = new FilmModel();
        $films = $filmModel->get_all_films();

        require_once(__DIR__ . "/../views/index.php");
    }
    public function show($params = [])
    {
        $id = $params[0];

        $filmModel = new FilmModel();
        $film = $filmModel->get_film_by_id($id);

        //Affichage dans la vue
        require_once(__DIR__ . "/../views/film.php");
    }
}