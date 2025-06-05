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
<?php if ($error): ?><p style="color:red;"><?= $error ?></p><?php endif; ?>
<form method="post">
  <label>Přihlašovací jméno:<br><input type="text" name="username" required></label><br><br>
  <label>Heslo:<br><input type="password" name="password" required></label><br><br>
  <button type="submit">Přihlásit se</button>
</form>

<?php include '../includes/footer.php'; ?>
