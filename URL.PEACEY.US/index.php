<?php
require_once __DIR__ . '/fn.php';
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$error    = '';
$shortUrl = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $originalUrl = trim($_POST['origURL'] ?? '');
    $description = trim($_POST['desc']    ?? '');

    if (!validateUrl($originalUrl)) {
        $error = 'Please enter a valid URL.';
    } else {
        $alias = generateAlias(6);
        if (saveLink($originalUrl, $alias, $description)) {
            $shortUrl = buildShortUrl($alias);
        } else {
            $error = 'There was an error saving your link. Please try again.';
        }
    }
}

// Handle redirect for short codes
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $path !== '' && $path !== basename(__FILE__)) {
    $original = getOriginalUrl($path);
    if ($original) {
        header('Location: ' . $original, true, 302);
        exit;
    }
    http_response_code(404);
    echo '<h1>404 Not Found</h1><p>Link not found.</p>';
    exit;
}

include __DIR__ . '/inc/head.inc.php';
?>
<main class="container py-5">

  <!-- Alerts -->
  <?php if ($error): ?>
    <div class="alert alert-danger text-center">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php elseif ($shortUrl): ?>
    <div class="alert alert-success text-center">
      Short link created:
      <a href="<?= htmlspecialchars($shortUrl) ?>" target="_blank">
        <?= htmlspecialchars($shortUrl) ?>
      </a>
    </div>
  <?php endif; ?>

  <!-- Shortener Form Card -->
  <div class="card mx-auto appBox">
    <div class="card-body">
      <form method="post" class="row g-3">
        <div class="col-md-6">
          <label for="origURL" class="form-label">URL to shorten</label>
          <input id="origURL" name="origURL" type="url" class="form-control"
                 placeholder="https://example.com"
                 value="<?= htmlspecialchars($_POST['origURL'] ?? '') ?>" required>
        </div>
        <div class="col-md-6">
          <label for="desc" class="form-label">Description</label>
          <input id="desc" name="desc" type="text" class="form-control"
                 placeholder="Enter a description"
                 value="<?= htmlspecialchars($_POST['desc'] ?? '') ?>">
        </div>
        <div class="col-12 d-grid">
          <button type="submit" class="btn btn-primary">Shorten</button>
        </div>
      </form>
    </div>
  </div>

</main>
</body>
</html>
