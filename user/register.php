<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  if ($username && $password) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
      $error = 'Uživatelské jméno již existuje.';
    } else {
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $insert = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
      $insert->execute([$username, $hashed]);
      header('Location: ' . BASE_URL . 'user/login.php');
      exit;
    }
  } else {
    $error = 'Vyplňte prosím všechna pole.';
  }
}
?>

<h2>Registrace</h2>
<?php if ($error): ?><p style="color:red;"><?= $error ?></p><?php endif; ?>
<form method="post">
  <label>Uživatelské jméno:<br><input type="text" name="username" required></label><br><br>
  <label>Heslo:<br><input type="password" name="password" required></label><br><br>
  <button type="submit">Registrovat se</button>
</form>

<?php include '../includes/footer.php'; ?>
