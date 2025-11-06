<?php
require_once(__DIR__ . "/../models/FilmModel.php");
class FilmController
{

    public function index()
    {
        $filmModel = new FilmModel();
        $films = $filmModel->get_all_films(10);

        require_once(__DIR__ . "/../views/films.php");
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