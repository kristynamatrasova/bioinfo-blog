<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

if (!isset($_GET['id'])) {
  echo "<p>Článek nenalezen.</p>";
  include '../includes/footer.php';
  exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
  echo "<p>Článek neexistuje.</p>";
  include '../includes/footer.php';
  exit;
}

// komentáře
$comments = $pdo->prepare("SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = ? ORDER BY c.created_at DESC");
$comments->execute([$id]);
$commentList = $comments->fetchAll();

// odeslání komentáře
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
  $comment = trim($_POST['comment']);
  if ($comment) {
    $insert = $pdo->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");
    $insert->execute([$id, $_SESSION['user_id'], $comment]);
    header("Location: post.php?id=" . $id);
    exit;
  }
}
?>

<section class="article-detail">
  <h1><?= htmlspecialchars($post['title']) ?></h1>
  <p class="meta">Autor: <?= htmlspecialchars($post['username']) ?> | <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></p>
  <p class="content"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
</section>

<section class="comments-section">
  <h2>Komentáře</h2>

  <?php if ($commentList): ?>
    <?php foreach ($commentList as $c): ?>
      <div class="comment">
        <strong><?= htmlspecialchars($c['username']) ?></strong>
        <p><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
        <span class="comment-time"><?= date('d.m.Y H:i', strtotime($c['created_at'])) ?></span>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Zatím žádné komentáře.</p>
  <?php endif; ?>

  <?php if (isset($_SESSION['user_id'])): ?>
    <form method="post" class="comment-form">
      <textarea name="comment" placeholder="Napište komentář..." required></textarea>
      <button type="submit">Odeslat</button>
    </form>
  <?php else: ?>
    <p><a href="<?= BASE_URL ?>user/login.php">Přihlaste se</a>, abyste mohli komentovat.</p>
  <?php endif; ?>
</section>

<?php include '../includes/footer.php'; ?>
