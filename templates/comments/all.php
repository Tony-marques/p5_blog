<div class="main-container comments">

  <?php foreach ($comments as $comment) : ?>
    <?php if ($comment["article_id"] == $comment["article"]["id"]) : ?>
      <div class="article-comment">
        <div class="article">
          <div class="main-article">
            <h2><?= htmlspecialchars($comment["article"]["title"])  ?></h2>
            <p class="content"><?= nl2br(html_entity_decode($comment["article"]["content"], ENT_QUOTES, 'UTF-8')) ?></p>
          </div>
          <div class="separator"></div>
          <div class="informations">
            <div class="article-author">
              <img class="article-author-picture" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrsfoSrq6gkVinDFbu36sCpC8i-Y07zkivRg&usqp=CAU" alt="profile picture">
              <p>Ecrit par <span class="name-author"><?= htmlspecialchars($comment["article"]["author"]) ?></span> </p>
            </div>
            <div class="date">
              <?php if (date('d/m/Y à H:i:s', strtotime($comment["article"]["created_at"])) == date('d/m/Y à H:i:s', strtotime($comment["article"]["updated_at"]))) : ?>
                <p>Ecrit le <?= date('d/m/Y à H:i:s', strtotime($comment["article"]["created_at"])) ?></p>
              <?php endif; ?>

              <?php if (date('d/m/Y à H:i:s', strtotime($comment["article"]["created_at"])) < date('d/m/Y à H:i:s', strtotime($comment["article"]["updated_at"]))) : ?>
                <p>Modifié le <?= date('d/m/Y à H:i:s', strtotime($comment["article"]["updated_at"])) ?></p>
              <?php endif; ?>
            </div>


          </div>
        </div>
        <div class="comment-body">
          <p><?= $comment["content"] ?></p>
          <div class="separator"></div>
          <div class="comment-group">
            <p>tony M. le 29/08/2023</p>
            <div class="button-group">
             <a href="/commentaire/validation/page/<?= $comment["id"] ?>" class="button button-primary">Valider</a>
             <a href="/commentaire/suppression/page/<?= $comment["id"] ?>" class="button button-danger">Supprimer</a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

  <?php endforeach; ?>

</div>