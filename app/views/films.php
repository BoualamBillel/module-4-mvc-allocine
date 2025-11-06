<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des films</title>
</head>
<body>
    <h1>Films</h1>
    <ul>
        <?php foreach ($films as $film): ?>
            <li>
                <?= htmlspecialchars($film->getNom()) ?>
                <?= htmlspecialchars($film->getGenre()) ?>
                <?= htmlspecialchars($film->getDuree()) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>