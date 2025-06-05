<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/header.php';

$stmt = $pdo->query("SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<h2>Nejnovější články</h2>

<?php foreach ($posts as $post): ?>
  <div class="article-preview">
    <h3><a href="<?= BASE_URL ?>blog/post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h3>
    <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?>...</p>
    <small>Autor: <?= htmlspecialchars($post['username']) ?> | <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></small>
  </div>
<?php endforeach; ?>

<?php include 'includes/footer.php'; ?>
