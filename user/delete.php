<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

if (!isset($_GET['id'])) {
    echo "<p>Chybí ID příspěvku.</p>";
    exit;
}

$id = (int)$_GET['id'];

// Načtení příspěvku
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    echo "<p>Příspěvek nenalezen.</p>";
    exit;
}

// Kontrola oprávnění
if (!isset($_SESSION['user_id']) || (
    $_SESSION['user_id'] != $post['user_id'] &&
    !($_SESSION['is_admin'] ?? 0)
)) {
    echo "<p>Nemáte oprávnění smazat tento příspěvek.</p>";
    exit;
}

// Smazání příspěvku a komentářů k němu
$pdo->prepare("DELETE FROM comments WHERE post_id = ?")->execute([$id]);
$pdo->prepare("DELETE FROM posts WHERE id = ?")->execute([$id]);

header("Location: " . BASE_URL . "index.php");
exit;
