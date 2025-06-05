<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Bioinformatický blog</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body>
  <header class="top-bar">
    <div class="container">
      <div class="logo">
        <a href="<?= BASE_URL ?>index.php">
          <img src="<?= BASE_URL ?>img/logo.png" alt="Logo" class="logo-img">
          <span class="logo-text">Bioinformatický blog</span>
        </a>
      </div>
      <nav class="main-nav">
        <ul>
          <li><a href="<?= BASE_URL ?>index.php">Domů</a></li>
          <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="<?= BASE_URL ?>user/create.php">Přidat článek</a></li>
            <li><a href="<?= BASE_URL ?>user/logout.php">Odhlásit se (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
          <?php else: ?>
            <li><a href="<?= BASE_URL ?>user/login.php">Přihlásit se</a></li>
            <li><a href="<?= BASE_URL ?>user/register.php">Registrovat</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>
  <main class="main-content">
