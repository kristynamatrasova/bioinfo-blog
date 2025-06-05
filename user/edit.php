<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

if (!isset($_GET['id'])) {
    echo "<p>Chybí ID příspěvku.</p>";
    include '../includes/footer.php';
    exit;
}

$id = (int)$_GET['id'];

// Načtení příspěvku
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    echo "<p>Příspěvek nenalezen.</p>";
    include '../includes/footer.php';
    exit;
}

// Oprávnění: autor nebo admin
if (!isset($_SESSION['user_id']) || (
    $_SESSION['user_id'] != $post['user_id'] &&
    !($_SESSION['is_admin'] ?? 0)
)) {
    echo "<p>Nemáte oprávnění upravit tento příspěvek.</p>";
    include '../includes/footer.php';
    exit;
}

// Odeslání formuláře
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title && $content) {
        $update = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $update->execute([$title, $content, $id]);
        header("Location: " . BASE_URL . "blog/post.php?id=" . $id);
        exit;
    } else {
        echo "<p style='color:red;'>Vyplňte prosím název i obsah.</p>";
    }
}
?>

<h2>Upravit článek</h2>
<form method="post">
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br>
    <textarea name="content" rows="10"><?= htmlspecialchars($post['content']) ?></textarea><br>
    <button type="submit">Uložit změny</button>
</form>

<?php include '../includes/footer.php'; ?>
