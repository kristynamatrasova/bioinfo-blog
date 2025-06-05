<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: ' . BASE_URL . 'user/login.php');
  exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);
  if ($title && $content) {
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $title, $content]);
    header('Location: ' . BASE_URL . 'index.php');
    exit;
  } else {
    $error = 'Vyplňte prosím všechna pole.';
  }
}
?>

<h2>Přidat nový článek</h2>
<?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
<form method="post">
  <input type="text" name="title" placeholder="Název článku" required>
  <textarea name="content" placeholder="Obsah článku" rows="10" required></textarea>
  <button type="submit">Publikovat</button>
</form>

<?php include '../includes/footer.php'; ?>
