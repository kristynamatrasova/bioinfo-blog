<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

if (!isset($_GET['id'], $_GET['post_id'])) {
  echo "Neplatný požadavek.";
  exit;
}

$comment_id = (int)$_GET['id'];
$post_id = (int)$_GET['post_id'];

// Získání komentáře
$stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ?");
$stmt->execute([$comment_id]);
$comment = $stmt->fetch();

if (!$comment) {
  echo "Komentář neexistuje.";
  exit;
}

// Kontrola oprávnění
if (
  !isset($_SESSION['user_id']) || 
  ($_SESSION['user_id'] != $comment['user_id'] && !($_SESSION['is_admin'] ?? 0))
) {
  echo "Nemáte oprávnění smazat tento komentář.";
  exit;
}

// Smazání
$delete = $pdo->prepare("DELETE FROM comments WHERE id = ?");
$delete->execute([$comment_id]);

header("Location: " . BASE_URL . "blog/post.php?id=" . $post_id);
exit;
