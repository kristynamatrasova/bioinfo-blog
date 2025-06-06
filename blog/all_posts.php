<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';
?>

<section class="main-content">
  <h1>Všechny příspěvky</h1>

  <?php
  $stmt = $pdo->query("SELECT p.id, p.title, p.created_at, u.username FROM posts p 
                       JOIN users u ON p.user_id = u.id 
                       ORDER BY p.created_at DESC");
  while ($post = $stmt->fetch()):
  ?>
    <article class="article-preview">
      <h3><a href="<?= BASE_URL ?>blog/post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h3>
      <small>Autor: <?= htmlspecialchars($post['username']) ?> | <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></small>
    </article>
  <?php endwhile; ?>
</section>

<?php require_once '../includes/footer.php'; ?>
