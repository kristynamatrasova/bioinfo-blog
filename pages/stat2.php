<?php
require_once '../includes/config.php';
require_once '../includes/header.php';
?>

<section class="static-article">
  <h1>Sekvenování DNA</h1>

  <p>
    Sekvenování DNA je metodou, která umožňuje určit přesné pořadí nukleotidů (A, T, C, G) v molekule DNA. Je to jeden z nejvýznamnějších objevů v oblasti molekulární biologie, neboť poskytuje detailní pohled do genetické informace organismů. Od počátků sangerovského sekvenování v 70. letech se postupy dramaticky vyvinuly. Moderní metody, označované jako sekvenování nové generace (Next-Generation Sequencing – NGS), jsou schopny analyzovat celý genom během několika hodin.
  </p>

  <p>
    Technologie NGS zcela změnila možnosti výzkumu v medicíně, genetice i biologii. Využívá se například při diagnostice genetických poruch, vývoji personalizované medicíny, sledování evolučních vztahů nebo při určování druhů v ekologii. Sekvenování dnes tvoří základ mnoha biologických projektů, včetně populační genetické analýzy, metagenomiky a výzkumu rakoviny.
  </p>

  <h2>Bioinformatika a analýza sekvenčních dat</h2>
  <p>
    Výsledkem NGS je obrovské množství dat – stovky milionů krátkých sekvencí, které je třeba nejprve vyčistit, seřadit a interpretovat. Bez specializovaných bioinformatických nástrojů by tento krok nebyl možný. Mezi klíčové procesy patří:
  </p>
  <ul>
    <li>Kontrola kvality a trimování nekvalitních bází (např. pomocí FastQC)</li>
    <li>Zarovnání sekvencí k referenčnímu genomu (např. BWA, Bowtie2)</li>
    <li>Identifikace variant – SNPs, inzerce, delece (např. pomocí GATK)</li>
    <li>Vizualizace zarovnání a výsledků (např. IGV Viewer)</li>
  </ul>

  <p>
    Bioinformatická analýza vyžaduje kombinaci znalostí z biologie, statistiky a programování. Nezbytná je také schopnost pracovat s výpočetní infrastrukturou – většina dat je analyzována v cloudu nebo pomocí výkonných serverů.
  </p>

  <p>
    Sekvenování DNA se i nadále vyvíjí. Nové technologie jako nanopórové sekvenování (např. Oxford Nanopore) nebo „long-read“ přístupy (PacBio) umožňují přesnější a komplexnější pohled na složité části genomu. Bioinformatika zůstává i nadále nepostradatelnou pro zpracování těchto dat a přeměnu syrové genetické informace na biologický význam.
  </p>

</section>
<div class="static-navigation">
  <a href="stat1.php" class="btn-nav">&laquo; Úvod do bioinformatiky</a>
  <a href="stat3.php" class="btn-nav">Proteinová struktura &raquo;</a>
</div>


<?php include '../includes/footer.php'; ?>
