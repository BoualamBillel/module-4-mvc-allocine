<?php
$title = "Ajouter un film";
ob_start();
?>
<div class="add-film-form max-w-xl mx-auto mt-10 bg-white rounded-xl shadow-lg p-8">
    <form action="" method="post" class="space-y-4">
        <div>
            <label for="film-name" class="block mb-1 font-semibold">Titre du film</label>
            <input type="text" class="form-input w-full px-3 py-2 border rounded" name="film-name" id="film-name" required>
        </div>
        <div>
            <label for="film-date" class="block mb-1 font-semibold">Date de sortie</label>
            <input type="date" class="form-input w-full px-3 py-2 border rounded" name="film-date" id="film-date" required>
        </div>
        <div>
            <label for="film-genre" class="block mb-1 font-semibold">Genre</label>
            <select name="film-genre" id="film-genre" class="form-genre w-full px-3 py-2 border rounded" required>
                <option value="Action">Action</option>
                <option value="Comedie">Comedie</option>
                <option value="Drama">Drama</option>
                <option value="Fantaisie">Fantaisie</option>
                <option value="Horreur">Horreur</option>
                <option value="Documentaire">Documentaire</option>
                <option value="ScienceFiction">Science-Fiction</option>
                <option value="Autre">Autre</option>
            </select>
        </div>
        <div>
            <label for="film-realisateur" class="block mb-1 font-semibold">Réalisateur</label>
            <input type="text" class="form-input w-full px-3 py-2 border rounded" name="film-realisateur" id="film-realisateur" required>
        </div>
        <div>
            <label for="film-duree" class="block mb-1 font-semibold">Durée (minutes)</label>
            <input type="number" class="form-input w-full px-3 py-2 border rounded" name="film-duree" id="film-duree" required>
        </div>
        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Ajouter le film</button>
    </form>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/template/layout.php';
?>