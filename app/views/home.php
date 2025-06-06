<section>
    <?php foreach ($articles as $article): ?>
        <article>
            <h2><?= htmlspecialchars($article['titulek']) ?></h2>
            <p><em><?= htmlspecialchars($article['datum']) ?></em></p>
            <p><?= nl2br(htmlspecialchars($article['text'])) ?></p>
        </article>
    <?php endforeach; ?>
</section>
