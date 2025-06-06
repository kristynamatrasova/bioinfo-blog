<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

if (!isset($_GET['id'])) {
    echo "<p>Příspěvek nenalezen.</p>";
    include '../includes/footer.php';
    exit;
}

$id = (int) $_GET['id'];

// Získání příspěvku
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    echo "<p>Příspěvek neexistuje.</p>";
    include '../includes/footer.php';
    exit;
}

// Oprávnění: autor nebo admin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != $post['user_id'] && !($_SESSION['is_admin'] ?? false))) {
    echo "<p>Nemáte oprávnění upravit tento příspěvek.</p>";
    include '../includes/footer.php';
    exit;
}

// Uložení změn
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title && $content) {
        $update = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $update->execute([$title, $content, $id]);
        header("Location: " . BASE_URL . "blog/post.php?id=" . $id);
        exit;
    } else {
        echo "<p class='error'>Vyplňte všechna pole.</p>";
    }
}
?>

<main class="main-content">
  <h1>Upravit příspěvek</h1>
  <form method="post">
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
    <textarea name="content" rows="10" required><?= htmlspecialchars($post['content']) ?></textarea>
    <button type="submit">Uložit změny</button>
  </form>
</main>

<?php include '../includes/footer.php'; ?>
