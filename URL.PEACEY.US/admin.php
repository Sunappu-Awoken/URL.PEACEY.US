<?php
require_once __DIR__ . '/fn.php';
session_start();

if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Read filters from query
$search = trim($_GET['search'] ?? '');
$date   = $_GET['date'] ?? '';

// Fetch filtered links from database
$links = getAllLinks($search, $date);

// Include head (styles + nav)
include __DIR__ . '/inc/head.inc.php';
?>
<main class="container py-5">
  <h1>Admin Dashboard</h1>

  <!-- Filter Form -->
  <form method="get" class="row g-3 mb-4">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Search URL"
             value="<?= htmlspecialchars($search) ?>">
    </div>
    <div class="col-md-4">
      <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($date) ?>">
    </div>
    <div class="col-md-4 d-flex">
      <button type="submit" class="btn btn-primary me-2">Filter</button>
      <a href="admin.php" class="btn btn-secondary">Reset</a>
    </div>
  </form>

  <!-- Links Table -->
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
      <tr>
        <th>URL to Shorten</th>
        <th>Description</th>
        <th>Short URL</th>
        <th>Created At</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($links)): ?>
        <?php foreach ($links as $data): ?>
          <tr>
            <td><?= htmlspecialchars($data['url']) ?></td>
            <td><?= htmlspecialchars($data['description']) ?></td>
            <td>
              <a href="<?= htmlspecialchars(buildShortUrl($data['alias'])) ?>" target="_blank">
                <?= htmlspecialchars(buildShortUrl($data['alias'])) ?>
              </a>
            </td>
            <td><?= htmlspecialchars($data['created_at']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="4" class="text-center">No links match your criteria.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>
</body>
</html>