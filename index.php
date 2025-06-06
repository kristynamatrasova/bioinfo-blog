<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/header.php';

// Získání dotazu pro vyhledávání
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Načtení příspěvků (filtrování podle titulku)
if ($search !== '') {
    $stmt = $pdo->prepare("SELECT p.*, u.username FROM posts p 
                           JOIN users u ON p.user_id = u.id 
                           WHERE p.title LIKE ?
                           ORDER BY p.created_at DESC");
    $stmt->execute(['%' . $search . '%']);
} else {
    $stmt = $pdo->query("SELECT p.*, u.username FROM posts p 
                         JOIN users u ON p.user_id = u.id 
                         ORDER BY p.created_at DESC");
}

$posts = $stmt->fetchAll();
?>

<div class="layout">
  <!-- SIDEBAR vlevo -->
  <aside class="sidebar">
    <h3>Navigace</h3>
    <ul>
      <li><a href="<?= BASE_URL ?>index.php">Příspěvky</a></li>
      <li><a href="<?= BASE_URL ?>pages/stat1.php">Články</a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
      <li><a href="<?= BASE_URL ?>user/profile.php">Můj profil</a></li>
        <li><a href="<?= BASE_URL ?>comments/my_comments.php">Moje komentáře</a></li>
        <li><a href="<?= BASE_URL ?>quiz/index.php">Kvíz</a></li>
      <?php endif; ?>
    </ul>
  </aside>

  <!-- HLAVNÍ OBSAH -->
  <main class="main-content">
    <section class="home-welcome">
      <h1>Bioinformatický portál</h1>
      <p>Vítejte na informačním portálu o bioinformatice. Najdete zde úvodní články i příspěvky uživatelů.</p>
    </section>

    <!-- Formulář vyhledávání -->
    <form method="get" class="search-form">
      <input type="text" name="search" placeholder="Hledat příspěvek..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit">🔍 Hledat</button>
    </form>

    <!-- Výpis statických článků -->
    <section class="static-list">
      <article>
        <h2><a href="<?= BASE_URL ?>pages/stat1.php">Úvod do bioinformatiky</a></h2>
        <p>Základní přehled o tom, co je bioinformatika a proč je důležitá...</p>
      </article>
      <article>
        <h2><a href="<?= BASE_URL ?>pages/stat2.php">Sekvenování DNA</a></h2>
        <p>Jak se získávají genetická data a jak je bioinformatika zpracovává...</p>
      </article>
      <article>
        <h2><a href="<?= BASE_URL ?>pages/stat3.php">Proteinová struktura</a></h2>
        <p>Přehled přístupů k predikci a modelování proteinů...</p>
      </article>
      <article>
        <h2><a href="<?= BASE_URL ?>pages/stat4.php">Nástroje v bioinformatice</a></h2>
        <p>Přehled běžně používaných nástrojů a databází...</p>
      </article>
    </section>

    <!-- Výpis uživatelských příspěvků -->
    <section class="articles-list">
      <h2>Nejnovější příspěvky</h2>

      <?php if ($posts): ?>
        <?php foreach ($posts as $post): ?>
          <article class="article-preview">
            <h3><a href="<?= BASE_URL ?>blog/post.php?id=<?= $post['id'] ?>">
              <?= htmlspecialchars($post['title']) ?></a>
            </h3>
            <small>Autor: <?= htmlspecialchars($post['username']) ?> | 
              <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?>
            </small>
            <p><?= mb_substr(htmlspecialchars($post['content']), 0, 150) ?>...</p>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Žádné příspěvky nenalezeny.</p>
      <?php endif; ?>
    </section>
  </main>
</div>

<?php require_once 'includes/footer.php'; ?>
