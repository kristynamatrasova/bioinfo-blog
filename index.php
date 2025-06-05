<?php
require_once 'includes/config.php';
require_once 'includes/header.php';
?>

<section class="home-welcome">
  <h1>Bioinformatický portál</h1>
  <p>Vítejte na informačním portálu o bioinformatice. Níže najdete úvodní články k tématu.</p>
</section>

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

<?php include 'includes/footer.php'; ?>
