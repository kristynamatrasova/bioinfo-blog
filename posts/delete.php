<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

if (!isset($_GET['id']) || !isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "index.php");
    exit;
}

$id = (int) $_GET['id'];

// Získání příspěvku
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    echo "<p>Příspěvek neexistuje.</p>";
    exit;
}

// Oprávnění: autor nebo admin
if ($_SESSION['user_id'] != $post['user_id'] && !($_SESSION['is_admin'] ?? false)) {
    echo "<p>Nemáte oprávnění smazat tento příspěvek.</p>";
    exit;
}

// Mazání
$delete = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$delete->execute([$id]);

header("Location: " . BASE_URL . "index.php");
exit;
