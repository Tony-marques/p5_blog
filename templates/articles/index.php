<div class="main-container">
  <?php foreach ($articles as $article) : ?>
    <a href="/article/<?= $article["id"] ?>" class="article">
      <!-- <a href=""> -->
      <div class="main-article">
        <h2><?= htmlspecialchars($article["title"])  ?></h2>
        <p><?= htmlspecialchars($article["content"]) ?></p>
      </div>
      <div class="separator"></div>
      <div class="informations">
        <div class="article-author">
          <img class="article-author-picture" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrsfoSrq6gkVinDFbu36sCpC8i-Y07zkivRg&usqp=CAU" alt="">
          <p>Ecrit par <span class="name-author"><?= htmlspecialchars($article["author"]) ?></span> </p>
        </div>
        <p><?= $article["created_at"] ?></p>
        <!-- </a> -->
      </div>
    </a>
  <?php endforeach; ?>
</div>