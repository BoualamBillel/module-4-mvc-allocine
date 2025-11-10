import { getAllFilms, getFilmById } from './films-fetch.js';

function createFilmCard(film) {
    // Création des éléments du DOM
    const cardDiv = document.createElement("div");
    const cardFilmName_elem = document.createElement("h1");
    const cardFilmGenre_elem = document.createElement("p");
    const cardFilmDuree_elem = document.createElement("p");
    const cardFilmRealisateur_elem = document.createElement("p");
    const cardFilmDate_elem = document.createElement("p");


    // Insertion des données
    // Ajout des classes Tailwind pour le style
    cardDiv.className = "bg-white rounded-xl shadow-lg overflow-hidden hover:scale-105 transition-transform duration-300 p-6 mb-4";
    cardFilmName_elem.className = "text-2xl font-bold text-indigo-700 mb-2";
    cardFilmGenre_elem.className = "px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-semibold inline-block mr-2 mb-2";
    cardFilmDuree_elem.className = "px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm inline-block mr-2 mb-2";
    cardFilmRealisateur_elem.className = "text-gray-600 mb-2";
    cardFilmDate_elem.className = "text-gray-500";

    // Insertion des données
    cardFilmName_elem.innerText = film.nom;
    cardFilmGenre_elem.innerText = film.genre;
    cardFilmDuree_elem.innerText = `⏱ ${film.duree} min`;
    cardFilmRealisateur_elem.innerText = `🎬 ${film.realisateur}`;
    cardFilmDate_elem.innerText = `📅 Sortie : ${film.dateDeSortie || film.date}`;

    // Stockage de l'id dans la div
    cardDiv.dataset.filmId = film.id;

    //Insertion des éléments dans la div
    cardDiv.appendChild(cardFilmName_elem);
    cardDiv.appendChild(cardFilmGenre_elem);
    cardDiv.appendChild(cardFilmDuree_elem);
    cardDiv.appendChild(cardFilmRealisateur_elem);
    cardDiv.appendChild(cardFilmDate_elem);

    return cardDiv;
}


export async function renderFilmsList(containerId = 'film-grid') {
    const searchBarInput = document.getElementById("search-bar-input");
    const container = document.getElementById(containerId);
    if (!container) return;
    let films = await getAllFilms();

    // Affiche les films dans le DOM selon le tableau
    function renderGrid(filmsToDisplay) {
        container.innerHTML = '';
        if (!filmsToDisplay.length) {
            container.innerHTML = `<div class="text-center text-gray-500 text-xl py-8">Aucun film disponible pour le moment.</div>`;
            return;
        }
        const grid = document.createElement('div');
        grid.className = 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mt-8';
        filmsToDisplay.forEach(film => {
            const card = createFilmCard(film);
            grid.appendChild(card);
            card.addEventListener("click", () => {
                window.location.href = `/film/details/${film.id}`;
            });
        });
        container.appendChild(grid);
    }

    renderGrid(films);

    if (searchBarInput) {
        searchBarInput.addEventListener("input", (e) => {
            const searchValue = e.target.value.toLowerCase();
            const filteredFilms = films.filter(film =>
                film.nom.toLowerCase().includes(searchValue)
            );
            renderGrid(filteredFilms);
        });
    }
}


if (document.getElementById('film-grid')) {
    renderFilmsList('film-grid');
}