<?php
$title = 'Accueil - Allo-Ciné';
ob_start();
?>

<div class="films-header">
    <h1>🎬 Bienvenue sur Allo-Ciné</h1>
    <p>Découvrez notre sélection de films</p>
</div>

<?php if (isset($films) && !empty($films)): ?>
    <div class="films-grid">
        <?php foreach ($films as $film): ?>
            <div class="film-card">
                <div class="film-content">
                    <h2 class="film-title"><?= htmlspecialchars($film->getNom()) ?></h2>
                    <div class="film-info">
                        <div class="film-info-row">
                            <span class="film-genre"><?= htmlspecialchars($film->getGenre()->value) ?></span>
                            <span class="film-duration">⏱ <?= htmlspecialchars($film->getDuree()) ?> min</span>
                        </div>
                        <div class="film-director">
                            🎬 Réalisé par <?= htmlspecialchars($film->getRealisateur()) ?>
                        </div>
                        <div class="film-date">
                            📅 Sortie : <?= htmlspecialchars($film->getDateDeSortie()->format('d/m/Y')) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="no-films">
        <p>Aucun film disponible pour le moment.</p>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/template/layout.php';
?>