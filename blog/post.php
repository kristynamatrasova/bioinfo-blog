<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

if (!isset($_GET['id'])) {
  echo "<p>Článek nenalezen.</p>";
  include '../includes/footer.php';
  exit;
}

$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
  echo "<p>Článek neexistuje.</p>";
  include '../includes/footer.php';
  exit;
}
?>

<article>
  <h1><?= htmlspecialchars($post['title']) ?></h1>
  <p><small>Autor: <?= htmlspecialchars($post['username']) ?> | 
    <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></small></p>
  <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
</article>

<?php include '../includes/footer.php'; ?>
