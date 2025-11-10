<?php
$title = 'Accueil - Allo-Ciné';
ob_start();
?>

<div class="films-header">
    <h1>🎬 Bienvenue sur Allo-Ciné</h1>
    <p>Découvrez notre sélection de films</p>
</div>
<div class="flex justify-center mt-6 mb-4">
    <input type="text" placeholder="Rechercher un film par son titre" id="search-bar-input"
        class="w-full max-w-md px-4 py-2 border border-indigo-300 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-indigo-500 text-lg transition" />
</div>
<div id="film-grid"></div>
<script type="module" src="public/js/films-dom.js"></script>
<?php
$content = ob_get_clean();
include __DIR__ . '/template/layout.php';
?>