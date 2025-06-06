<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>Musíte být přihlášeni.</p>";
    include '../includes/footer.php';
    exit;
}

$stmt = $pdo->prepare("SELECT c.*, p.title FROM comments c 
                       JOIN posts p ON c.post_id = p.id 
                       WHERE c.user_id = ? 
                       ORDER BY c.created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$comments = $stmt->fetchAll();
?>

<section class="main-content">
  <h1>Moje komentáře</h1>

  <?php if ($comments): ?>
    <?php foreach ($comments as $comment): ?>
      <div class="comment">
        <p><strong>Článek:</strong> <a href="<?= BASE_URL ?>blog/post.php?id=<?= $comment['post_id'] ?>">
          <?= htmlspecialchars($comment['title']) ?></a></p>
        <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
        <small><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></small>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Nemáte žádné komentáře.</p>
  <?php endif; ?>
</section>

<?php include '../includes/footer.php'; ?>
