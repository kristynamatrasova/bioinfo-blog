<?php
require_once '../includes/config.php';
require_once '../includes/header.php';
?>

<section class="static-article">
  <h1>Nejčastěji používané nástroje v bioinformatice</h1>

  <p>
    Bioinformatika je silně závislá na specializovaných softwarových nástrojích a databázích, které umožňují analyzovat, zpracovávat a interpretovat biologická data. Tato oblast se neustále vyvíjí a nástroje se neustále aktualizují, aby držely krok s rostoucím objemem a složitostí dat.
  </p>

  <h2>Základní databáze</h2>
  <ul>
    <li><strong>NCBI (National Center for Biotechnology Information)</strong> – obsahuje GenBank, PubMed, GEO, RefSeq</li>
    <li><strong>Ensembl</strong> – anotované genomy různých druhů</li>
    <li><strong>UniProt</strong> – databáze proteinů, funkcí a interakcí</li>
    <li><strong>RCSB PDB</strong> – 3D struktury proteinů a nukleových kyselin</li>
  </ul>

  <h2>Analytické nástroje</h2>
  <ul>
    <li><strong>BLAST</strong> – srovnávání sekvencí (lokální vyhledávání podobností)</li>
    <li><strong>Clustal Omega</strong> – vícenásobné zarovnání sekvencí</li>
    <li><strong>MAFFT, MUSCLE</strong> – rychlé algoritmy pro zarovnání</li>
    <li><strong>FastQC</strong> – kontrola kvality sekvenčních dat</li>
    <li><strong>IGV</strong> – vizualizace genomových dat</li>
  </ul>

  <h2>Programovací jazyky a knihovny</h2>
  <p>
    Pro pokročilé analýzy a automatizaci se hojně využívají skriptovací jazyky:
  </p>
  <ul>
    <li><strong>Python</strong> – knihovny BioPython, scikit-bio, pandas</li>
    <li><strong>R</strong> – framework Bioconductor, statistické modelování</li>
    <li><strong>Bash, Shell</strong> – automatizace v unixových systémech</li>
  </ul>

  <p>
    Kombinace open-source nástrojů, cloudových platforem a komunitní podpory dělá z bioinformatiky vysoce dynamickou disciplínu. Pokročilá znalost těchto nástrojů je klíčová pro efektivní analýzu biologických dat.
  </p>
</section>
<div class="static-navigation">
  <a href="stat3.php" class="btn-nav">&laquo; Proteinová struktura</a>
  <!-- Žádný další -->
  <span></span>
</div>


<?php include '../includes/footer.php'; ?>
