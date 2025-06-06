<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $gender = $_POST['gender'] ?? null;

    // Validace
    if ($username === '' || $email === '' || $password === '' || $confirm_password === '') {
        $errors[] = 'Všechna povinná pole musí být vyplněna.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Neplatný formát e-mailu.';
    }

    if ($password !== $confirm_password) {
        $errors[] = 'Hesla se neshodují.';
    }

    // Kontrola duplicity uživatele
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = 'Uživatel s tímto jménem nebo e-mailem již existuje.';
    }

    // Vložení do DB
    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $insert = $pdo->prepare("INSERT INTO users (username, email, password, gender) VALUES (?, ?, ?, ?)");
        $insert->execute([$username, $email, $hashed, $gender]);
        header('Location: login.php');
        exit;
    }
}
?>

<div class="main-content">
  <h1>Registrace</h1>

  <?php if ($errors): ?>
    <div class="error">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post">
    <label>Přihlašovací jméno *</label>
    <input type="text" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">

    <label>E-mail *</label>
    <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

    <label>Heslo *</label>
    <input type="password" name="password" required>

    <label>Potvrzení hesla *</label>
    <input type="password" name="confirm_password" required>

    <label>Pohlaví (nepovinné)</label>
    <select name="gender">
      <option value="">-- nezadáno --</option>
      <option value="M" <?= ($_POST['gender'] ?? '') === 'M' ? 'selected' : '' ?>>Muž</option>
      <option value="F" <?= ($_POST['gender'] ?? '') === 'F' ? 'selected' : '' ?>>Žena</option>
      <option value="O" <?= ($_POST['gender'] ?? '') === 'O' ? 'selected' : '' ?>>Jiné</option>
    </select>

    <button type="submit">Registrovat</button>
  </form>
</div>

<?php require_once '../includes/footer.php'; ?>
