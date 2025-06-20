<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['is_admin'] = $user['is_admin'];
    header('Location: ' . BASE_URL . 'index.php');
    exit;
  } else {
    $error = 'Neplatné přihlašovací údaje.';
  }
}
?>

<h2>Přihlášení</h2>
<?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
<form method="post">
  <input type="text" name="username" placeholder="Uživatelské jméno" required>
  <input type="password" name="password" placeholder="Heslo" required>
  <button type="submit">Přihlásit se</button>
</form>
<p style="margin-top: 1rem;">
  Nemáte účet? <a href="register.php">Zaregistrujte se zde</a>.
</p>

<?php include '../includes/footer.php'; ?>
