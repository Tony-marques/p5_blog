<div class="main-container">
  <div class="article-one">
    <!-- <a href=""> -->
    <div class="main-article">
      <h2><?= htmlspecialchars($article["title"])  ?></h2>
      <p class="content"><?= nl2br(html_entity_decode($article["content"], ENT_QUOTES, 'UTF-8')) ?></p>
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
      <!-- </a> -->
    </div>
  </div>
  <?php if ($article["user_id"] == $currentUser || $isAdmin) : ?>
    <a href="/article/edition/<?= $article["id"] ?>" class="button button-primary">
      <i class="fa-solid fa-pen-to-square"></i>
      <span class="ml-10">Modifier</span>
    </a>
  <?php endif; ?>


  <?php if ($article["user_id"] == $currentUser || $isAdmin) : ?>
    <a href="/article/suppression/<?= $article["id"] ?>" class="button button-danger ml-10">
      <i class="fa-solid fa-trash"></i>
      <span class="ml-10">Supprimer</span>
    </a>
  <?php endif; ?>

  <?php if (isset($_SESSION["user"])) : ?>
    <?= $commentForm ?>
  <?php endif; ?>
  <div class="comment-container">
    <?php if (!$isAdmin) : ?>
      <p> <?= count($validateComments) ?> commentaire<?= count($validateComments) > 1 ? "s" : "" ?></p>
      <?php foreach ($validateComments as $comment) : ?>
        <div class="comment">
          <p><?= $comment["content"] ?></p>
          <div class="separator"></div>
          <div class="informations">
            <span><?= $currentUser["firstname"] ?></span>
            <span>le <?= date("d/m/Y", strtotime($comment["created_at"])) ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p> <?= count($allComments) ?> commentaire<?= count($allComments) > 1 ? "s" : "" ?></p>

      <?php foreach ($allComments as $comment) : ?>
        <div class="comment">
          <p><?= nl2br($comment["content"]) ?></p>
          <div class="separator"></div>
          <div class="informations">
            <div class="people">
              <span><?= $currentUser["firstname"] ?></span>
              <span><?= substr($currentUser["lastname"], 0, 1) . "." ?></span>
              <span>le <?= date("d/m/Y", strtotime($comment["created_at"])) ?></span>
            </div>
            <div class="buttons">

              <a href="/commentaire/suppression/<?= $comment['id'] ?>" class="button button-danger">
                <i class="fa-solid fa-trash"></i>
              </a>
              <?php if ($comment["published"] == 0) : ?>
                <a href="/commentaire/validation/<?= $comment['id'] ?>" class="button button-primary ml-10">
                  <i class="fa-solid fa-check"></i>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>



  </div>
</div>