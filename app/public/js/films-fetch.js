
export async function getAllFilms() {
    let films = [];
    try {
        const response = await fetch("http://localhost:8080/film/getAll");
        films = await response.json();
    } catch (error) {
        console.log("getAllFilms : Erreur lors de la récupération des films depuis la DB", error);
        return [];
    }
    return films;
}

export async function getFilmById(id) {
    let filmInfo = {};
    try {
        const response = await fetch(`http://localhost:8080/film/get/${id}`);
        filmInfo = await response.json();
    } catch (error) {
        console.log(`getFilmById : Erreur lors de la récupération des info du film ${id} : ${error}`);
        return {};
    }
    return filmInfo;
}