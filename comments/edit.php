<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

if (!isset($_GET['id'], $_GET['post_id'])) {
  echo "Chybný požadavek.";
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
  echo "Nemáte oprávnění upravit tento komentář.";
  exit;
}

// Zpracování odeslání formuláře
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $text = trim($_POST['comment']);
  if ($text) {
    $update = $pdo->prepare("UPDATE comments SET comment = ? WHERE id = ?");
    $update->execute([$text, $comment_id]);
    header("Location: " . BASE_URL . "blog/post.php?id=" . $post_id);
    exit;
  } else {
    echo "<p style='color:red;'>Komentář nesmí být prázdný.</p>";
  }
}
?>

<h2>Upravit komentář</h2>
<form method="post">
  <textarea name="comment" rows="5"><?= htmlspecialchars($comment['comment']) ?></textarea><br>
  <button type="submit">Uložit změny</button>
</form>

<?php include '../includes/footer.php'; ?>
