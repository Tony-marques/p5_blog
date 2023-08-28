<div class="main-container">
  <?php foreach ($articles as $article) : ?>
    <a href="/article/<?= $article["id"] ?>" class="article">
      <div class="main-article">
        <h2><?= htmlspecialchars($article["title"])  ?></h2>
        <p class="content"><?= htmlspecialchars(nl2br(html_entity_decode($article["content"], ENT_QUOTES, 'UTF-8'))) ?></p>
      </div>
      <div class="separator"></div>
      <div class="informations">
        <div class="article-author">
          <img class="article-author-picture" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrsfoSrq6gkVinDFbu36sCpC8i-Y07zkivRg&usqp=CAU" alt="">
          <p>Ecrit par <span class="name-author"><?= htmlspecialchars($article["author"]) ?></span> </p>
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
</div>