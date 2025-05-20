<?php include __DIR__ . '/../partials/head.php'; ?>

<img 
    src="<?= htmlspecialchars($data['logo']) ?>" 
    alt="PeaceCY Logo" 
    style="display:block; margin:1rem auto; max-width:300px;"
>

<h1><?= htmlspecialchars($data['title']) ?></h1>
<p>This is your landing page powered by MVC.</p>

<?php include __DIR__ . '/../partials/footer.php'; ?>
