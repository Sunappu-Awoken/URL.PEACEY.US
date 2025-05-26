<?php
require_once __DIR__ . '/fn.php';
session_start();

if (!empty($_SESSION['admin_id'])) {
    header('Location: admin.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');
    if (verifyAdminCredentials($user, $pass)) {
        $admin = getAdminByUsername($user);
        $_SESSION['admin_id']   = $admin['id'];
        $_SESSION['admin_user'] = $admin['username'];
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}

include __DIR__ . '/inc/head.inc.php';
?>
<main class="container p-4">
 

  <?php if ($error): ?>
    <div class="alert alert-danger" style="max-width:400px; margin:1rem auto;">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <form method="post" class="mx-auto" style="max-width:400px;">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input id="username" type="text" name="username" class="form-control" required autofocus>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input id="password" type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Log In</button>
  </form>
</main>
</body>
</html>
