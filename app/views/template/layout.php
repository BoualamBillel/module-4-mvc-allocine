<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Allo-Ciné' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/public/css/style.css">
    <?= $additionalCSS ?? '' ?>
</head>
<body>
    <?php include __DIR__ . '/header.php'; ?>

    <main class="container">
        <?= $content ?? '' ?>
    </main>

    <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
