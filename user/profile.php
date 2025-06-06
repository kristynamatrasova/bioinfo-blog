<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

// Ověření přihlášení
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];
$success = false;

// Načtení aktuálních dat uživatele
$stmt = $pdo->prepare("SELECT username, email, gender FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Uložení změn
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($email === '') {
        $errors[] = 'E-mail je povinný.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Neplatný formát e-mailu.';
    }

    if ($password !== '' && $password !== $confirm) {
        $errors[] = 'Hesla se neshodují.';
    }

    if (empty($errors)) {
        if ($password !== '') {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET email = ?, gender = ?, password = ? WHERE id = ?");
            $update->execute([$email, $gender, $hashed, $user_id]);
        } else {
            $update = $pdo->prepare("UPDATE users SET email = ?, gender = ? WHERE id = ?");
            $update->execute([$email, $gender, $user_id]);
        }
        $success = true;

        // Načti nová data po uložení
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
    }
}
?>

<div class="main-content">
  <h1>Můj profil</h1>

  <?php if ($success): ?>
    <p style="color: #4caf50;">Údaje byly úspěšně uloženy.</p>
  <?php endif; ?>

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
    <label>Uživatelské jméno</label>
    <input type="text" value="<?= htmlspecialchars($user['username']) ?>" disabled>

    <label>E-mail</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

    <label>Pohlaví</label>
    <select name="gender">
      <option value="">-- nezadáno --</option>
      <option value="M" <?= $user['gender'] === 'M' ? 'selected' : '' ?>>Muž</option>
      <option value="F" <?= $user['gender'] === 'F' ? 'selected' : '' ?>>Žena</option>
      <option value="O" <?= $user['gender'] === 'O' ? 'selected' : '' ?>>Jiné</option>
    </select>

    <label>Nové heslo (nepovinné)</label>
    <input type="password" name="password">

    <label>Potvrzení nového hesla</label>
    <input type="password" name="confirm_password">

    <button type="submit">Uložit změny</button>
  </form>
</div>

<?php require_once '../includes/footer.php'; ?>
