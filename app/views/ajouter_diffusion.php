<?php
$title = "Ajouter une séance";
ob_start();
?>
<div class="max-w-xl mx-auto mt-10 bg-white rounded-xl shadow-lg p-8">
	<h1 class="text-2xl font-bold text-indigo-700 mb-6">Ajouter une séance</h1>
	<form action="" method="post" class="space-y-4">
		<div>
			<label for="film-id" class="block mb-1 font-semibold">Film</label>
			<select name="film-id" id="film-id" class="w-full px-3 py-2 border rounded" required>
				<option value="" disabled>Sélectionner un film</option>
				<?php if (isset($films) && is_array($films)) : ?>
					<?php foreach ($films as $film) : ?>
						<option value="<?= htmlspecialchars($film->getId()) ?>">
							<?= htmlspecialchars($film->getNom()) ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</div>
		<div>
			<label for="date-diffusion" class="block mb-1 font-semibold">Date et heure de la séance</label>
			<input type="datetime-local" name="date-diffusion" id="date-diffusion" class="w-full px-3 py-2 border rounded" required>
		</div>
		<button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Ajouter la séance</button>
	</form>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/template/layout.php';
?>
