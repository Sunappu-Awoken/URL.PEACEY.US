<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-sm navbar-dark" style="background-color:#2b0155!important;">
  <div class="container-fluid">
    <div id="topNav" class="ms-auto d-flex align-items-center">
      <!-- Logo always links to the public home -->
      <a href="index.php">
        <img src="https://peaceysystems.com/wp-content/uploads/2024/02/PeaceySystems_Logo25_Big-2048x356.png"
             alt="PeaceySystems Logo"
             style="height:32px;">
      </a>

      <?php if (!empty($_SESSION['admin_id'])): ?>
        <!-- When logged in, show Dashboard and Logout -->
        <a href="admin.php" class="btn btn-outline-light ms-3">ADMIN</a>
        <a href="logout.php" class="btn btn-light ms-3">Logout</a>
      <?php else: ?>
        <!-- When not logged in, show Login -->
        <a href="login.php" class="btn btn-light ms-3">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
