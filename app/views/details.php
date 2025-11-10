<?php
$title = 'Détail du film - ' . htmlspecialchars($film->getNom());

ob_start();
?>
<div class="max-w-2xl mx-auto mt-10 bg-white rounded-xl shadow-lg overflow-hidden">
	<div class="p-8">
		<h1 class="text-3xl font-bold text-indigo-700 mb-4 flex items-center gap-2">
			🎬 <?= htmlspecialchars($film->getNom()) ?>
		</h1>
		<div class="flex flex-wrap gap-2 mb-4">
			<span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-semibold">Genre : <?= htmlspecialchars($film->getGenre()->value) ?></span>
			<span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">⏱ Durée : <?= htmlspecialchars($film->getDuree()) ?> min</span>
		</div>
		<div class="mb-2 text-gray-600">
			<span class="font-semibold">Réalisateur :</span> <?= htmlspecialchars($film->getRealisateur()) ?>
		</div>
		<div class="mb-2 text-gray-600">
			<span class="font-semibold">Date de sortie :</span> <?= htmlspecialchars($film->getDateDeSortie()->format('d/m/Y')) ?>
		</div>
		<?php if (method_exists($film, 'getSynopsis') && $film->getSynopsis()) : ?>
		<div class="mt-4 text-gray-700">
			<span class="font-semibold">Synopsis :</span>
			<p class="mt-1"><?= nl2br(htmlspecialchars($film->getSynopsis())) ?></p>
		</div>
		<?php endif; ?>

		<?php if (isset($diffusionInfos) && is_array($diffusionInfos) && count($diffusionInfos)) : ?>
		<div class="mt-8">
			<h2 class="text-xl font-bold text-indigo-600 mb-2">Diffusions à venir</h2>
			<ul class="space-y-2">
				<?php foreach ($diffusionInfos as $diff) : ?>
					<li class="px-4 py-2 bg-indigo-50 rounded text-indigo-900 flex items-center gap-2">
						<span class="font-semibold">Séance :</span>
						<?= date('d/m/Y H:i', strtotime($diff['date_diffusion'])) ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>
		<form action="/film/delete_film/<?= $film->getId() ?>" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ce film ?');" class="mt-8">
			<button type="submit" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Supprimer le film</button>
		</form>
	</div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/template/layout.php';
?>