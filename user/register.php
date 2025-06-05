<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
  $stmt->execute([$username]);
  if ($stmt->fetch()) {
    $error = 'Uživatelské jméno již existuje.';
  } else {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)")->execute([$username, $hashed]);
    header('Location: ' . BASE_URL . 'user/login.php');
    exit;
  }
}
?>

<h2>Registrace</h2>
<?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
<form method="post">
  <input type="text" name="username" placeholder="Uživatelské jméno" required>
  <input type="password" name="password" placeholder="Heslo" required>
  <button type="submit">Registrovat se</button>
</form>

<?php include '../includes/footer.php'; ?>
