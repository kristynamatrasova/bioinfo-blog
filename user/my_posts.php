<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>Musíte být přihlášeni.</p>";
    include '../includes/footer.php';
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$posts = $stmt->fetchAll();
?>

<section class="main-content">
  <h1>Moje příspěvky</h1>

  <?php if ($posts): ?>
    <?php foreach ($posts as $post): ?>
      <div class="article-preview">
        <h3><a href="<?= BASE_URL ?>blog/post.php?id=<?= $post['id'] ?>">
          <?= htmlspecialchars($post['title']) ?></a></h3>
        <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 150))) ?>...</p>
        <small><?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></small>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Nemáte žádné příspěvky.</p>
  <?php endif; ?>
</section>

<?php include '../includes/footer.php'; ?>
