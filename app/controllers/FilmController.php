<?php
require_once(__DIR__ . "/../models/FilmModel.php");
require_once(__DIR__ . "/../models/DiffusionModel.php");
class FilmController
{
    public function view(string $method, array $params = [])
    {
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
    public function details($params = [])
    {
        $id = $params[0];
        $filmModel = new FilmModel();
        $film = $filmModel->get_film_by_id($id);
        $diffusionModel = new DiffusionModel();
        $diffusionInfos = $diffusionModel->getDiffusionInfo($id);

        require_once(__DIR__ . "/../views/details.php");
    }
    public function ajouter_film()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données du formulaire
            $nom = $_POST['film-name'];
            $date = new DateTime($_POST['film-date']);
            $genre = GENRE_ALLOWED::from($_POST['film-genre']);
            $realisateur = $_POST['film-realisateur'];
            $duree = $_POST['film-duree'];

            // Appel du modèle pour ajouter le film
            $filmModel = new FilmModel();
            $filmModel->add_film($nom, $date, $genre, $realisateur, $duree);

            // Redirection ou message de confirmation
            header('Location: /');
            exit;
        }

        require_once(__DIR__ . "/../views/ajouter_film.php");
    }
    public function delete_film($params = [])
    {
        $id = $params[0];
        $filmModel = new FilmModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filmModel->delete_film($id);
            header("Location: /");
            exit();
        }
    }
    public function show($params = [])
    {
        $id = $params[0];

        $filmModel = new FilmModel();
        $film = $filmModel->get_film_by_id($id);

        //Affichage dans la vue
        require_once(__DIR__ . "/../views/film.php");
    }

    public function getAll($params = [])
    {

        $filmModel = new FilmModel();
        $films = $filmModel->get_all_films();
        $filmsArray = array_map(function ($film) {
            return [
                'id' => $film->getId(),
                'nom' => $film->getNom(),
                'genre' => $film->getGenre()->value,
                'duree' => $film->getDuree(),
                'realisateur' => $film->getRealisateur(),
                'date' => $film->getDateDeSortie()->format("d/m/Y")
            ];
        }, $films);

        header("Content-type: application/json");
        echo json_encode($filmsArray);
    }

    public function get($params = [])
    {
        console("/film/get/:id");
        $id = $params[0];

        $diffusionModel = new DiffusionModel();
        $filmModel = new FilmModel();

        $film = $filmModel->get_film_by_id($id);
        $diffusion = $diffusionModel->getDiffusionInfo($id);
        $filmObject = [
            'film_id' => $film->getId(),
            'nom' => $film->getNom(),
            'genre' => $film->getGenre()->value,
            'duree' => $film->getDuree(),
            'realisateur' => $film->getRealisateur(),
            'dateDeSortie' => $film->getDateDeSortie()->format("d/m/Y"),

            'dateDiffusion' => array_map(function ($d) {
                return [
                    'id' => $d['id'],
                    'date_diffusion' => $d['date_diffusion']
                ];
            }, $diffusion)

        ];

        header("Content-type: application/json");
        echo json_encode($filmObject);
    }
}