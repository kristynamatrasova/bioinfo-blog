<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Bioinformatický blog</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
</head>
<body>
<header>
  <nav>
    <ul>
      <li><a href="<?= BASE_URL ?>index.php">Domů</a></li>
      <?php if (!isset($_SESSION['user_id'])): ?>
        <li><a href="<?= BASE_URL ?>user/login.php">Přihlásit se</a></li>
        <li><a href="<?= BASE_URL ?>user/register.php">Registrovat</a></li>
      <?php else: ?>
        <li><a href="<?= BASE_URL ?>user/create.php">Přidat článek</a></li>
        <li><a href="<?= BASE_URL ?>user/logout.php">Odhlásit se</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>
<main>
