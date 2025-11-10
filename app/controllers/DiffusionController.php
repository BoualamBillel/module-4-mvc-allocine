<?php
require_once(__DIR__ . "/../models/FilmModel.php");
require_once(__DIR__ . "/../models/DiffusionModel.php");
class DiffusionController
{
    public function view(string $method, array $params = [])
    {
        try {
            call_user_func([$this, $method], $params);
        } catch (Error $e) {
            console($e->getMessage());
        }
    }
    public function toutes_diffusions()
    {
        $diffusionModel = new DiffusionModel();
        $diffusions = $diffusionModel->getAllDiffusion();

        require_once(__DIR__ . "/../views/toutes_diffusions.php");
    }
    public function add()
    {
        $diffusionModel = new DiffusionModel();
        $filmModel = new FilmModel();
        $films = $filmModel->get_all_films();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $film_id = $_POST['film-id'];
            $date_diffusion = new DateTime($_POST['date-diffusion']);

            $diffusionModel->addDiffusion($film_id, $date_diffusion);
            header("Location: /diffusion/toutes_diffusions");

        }
        
        require_once(__DIR__ . "/../views/ajouter_diffusion.php");
    }
}