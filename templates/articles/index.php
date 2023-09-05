<div class="main-container articles">
  <h3>Articles: <?= count($allArticles) ?></h3>
  <?php foreach ($articles as $article) : ?>
    <a href="/article/<?= $article["id"] ?>" class="article">
      <div class="main-article">
        <h2><?= htmlspecialchars($article["title"])  ?></h2>
        <p class="content"><?= nl2br(htmlspecialchars(html_entity_decode($article["content"], ENT_QUOTES, 'UTF-8'))) ?></p>
      </div>
      <div class="separator"></div>
      <div class="informations">
        <div class="article-author">
          <img class="article-author-picture" src="/uploads/profile/<?= $article["user"]["avatar"] ?>" alt="profile picture">
          <p>Ecrit par <span class="name-author"><?= htmlspecialchars(ucfirst($article["user"]["firstname"])) ?> <?= htmlspecialchars(substr(strtoupper($article["user"]["lastname"]), 0, 1)) . "." ?></span> </p>
        </div>
        <div class="date">
          <?php if (date('d/m/Y à H:i:s', strtotime($article["created_at"])) == date('d/m/Y à H:i:s', strtotime($article["updated_at"]))) : ?>
            <p>Ecrit le <?= date('d/m/Y à H:i:s', strtotime($article["created_at"])) ?></p>
          <?php endif; ?>

          <?php if (date('d/m/Y à H:i:s', strtotime($article["created_at"])) < date('d/m/Y à H:i:s', strtotime($article["updated_at"]))) : ?>
            <p>Modifié le <?= date('d/m/Y à H:i:s', strtotime($article["updated_at"])) ?></p>
          <?php endif; ?>
        </div>

      </div>
    </a>
  <?php endforeach; ?>
  <div class="button-group">
    <?php for ($p = 1; $p <= $totalPages; $p++) : ?>
      <?php if ($_SERVER["REQUEST_URI"] == "/articles" && $p == 1) : ?>
        <a href="/articles/1" class="button button-primary-stroke active-link">1</a>
      <?php else : ?>
        <a href="/articles/<?= $p ?>" class="button button-primary-stroke <?= str_starts_with($_SERVER["REQUEST_URI"], "/articles/$p") ? "active-link" : "" ?>"><?= $p ?></a>
      <?php endif; ?>

    <?php endfor; ?>
  </div>
</div>