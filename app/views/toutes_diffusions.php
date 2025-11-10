<?php
$title = 'Toutes les diffusions';
ob_start();
?>
<div class="max-w-2xl mx-auto mt-10 bg-white rounded-xl shadow-lg overflow-hidden">
	<div class="p-8">
		<h1 class="text-2xl font-bold text-indigo-700 mb-6">Toutes les diffusions</h1>
		<?php if (isset($diffusions) && is_array($diffusions) && count($diffusions)) : ?>
			<ul class="space-y-3">
				<?php foreach ($diffusions as $diff) : ?>
					<li class="px-4 py-3 bg-indigo-50 rounded text-indigo-900 flex flex-wrap items-center gap-4">
						<span class="font-semibold">Film :</span>
						<span class="max-w-xs truncate inline-block align-middle" title="<?= htmlspecialchars($diff['film_nom']) ?>">
							<?= htmlspecialchars($diff['film_nom']) ?>
						</span>
						<span class="font-semibold">Date :</span> <?= date('d/m/Y H:i', strtotime($diff['date_diffusion'])) ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<div class="text-gray-500 text-lg">Aucune diffusion trouvée.</div>
		<?php endif; ?>
	</div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/template/layout.php';
?>
