<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

$questions = [
  [
    "question" => "Co je hlavním cílem bioinformatiky?",
    "options" => [
      "Studium planet",
      "Analýza biologických dat",
      "Pěstování bakterií",
      "Vývoj očkování"
    ],
    "answer" => 1
  ],
  [
    "question" => "Který formát se často používá pro ukládání sekvencí DNA?",
    "options" => [
      "JPEG",
      "PDF",
      "FASTA",
      "CSV"
    ],
    "answer" => 2
  ],
  [
    "question" => "Jaký nástroj se běžně používá pro porovnání sekvencí?",
    "options" => [
      "BLAST",
      "GIMP",
      "Excel",
      "React"
    ],
    "answer" => 0
  ]
];

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $score = 0;
  foreach ($questions as $index => $q) {
    if (isset($_POST["q$index"]) && $_POST["q$index"] == $q['answer']) {
      $score++;
    }
  }
  $result = "Správně jste odpověděl/a na $score z " . count($questions) . " otázek.";
}
?>

<div class="main-content">
  <h1>Kvíz z bioinformatiky</h1>

  <?php if ($result): ?>
    <div class="quiz-result"><?= htmlspecialchars($result) ?></div>
    <p><a href="index.php" class="btn-admin">Zkusit znovu</a></p>
  <?php else: ?>
    <form method="post" class="quiz-form">
      <?php foreach ($questions as $index => $q): ?>
        <fieldset class="question-block">
          <legend><?= ($index + 1) . '. ' . htmlspecialchars($q['question']) ?></legend>
          <?php foreach ($q['options'] as $i => $opt): ?>
            <label>
              <input type="radio" name="q<?= $index ?>" value="<?= $i ?>" required>
              <?= htmlspecialchars($opt) ?>
            </label><br>
          <?php endforeach; ?>
        </fieldset>
      <?php endforeach; ?>
      <button type="submit">Odeslat odpovědi</button>
    </form>
  <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>
