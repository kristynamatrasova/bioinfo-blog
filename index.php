<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/header.php';

$stmt = $pdo->query("
  SELECT p.id, p.title, p.content, p.created_at, u.username 
  FROM posts p
  JOIN users u ON p.user_id = u.id
  ORDER BY p.created_at DESC
");

$posts = $stmt->fetchAll();
?>

<section>
  <h2>Poslední články</h2>
  <?php foreach ($posts as $post): ?>
    <article class="article-preview">
      <h3><a href="<?= BASE_URL ?>blog/post.php?id=<?= $post['id'] ?>">
        <?= htmlspecialchars($post['title']) ?>
      </a></h3>
      <p><?= nl2br(htmlspecialchars(mb_substr($post['content'], 0, 200))) ?>...</p>
      <p><small>Autor: <?= htmlspecialchars($post['username']) ?> | 
        <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></small></p>
    </article>
  <?php endforeach; ?>
</section>

<?php include 'includes/footer.php'; ?>
