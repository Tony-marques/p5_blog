<div class="main-container comments">

  <?php foreach ($comments as $comment) : ?>
    <?php if ($comment->getArticleId() == $comment->getArticle()->getId()) : ?>
      <div class="article-comment">
        <div class="article">
          <div class="main-article">
            <h2><?= htmlspecialchars($comment->getArticle()->getTitle())  ?></h2>
            <p class="content"><?= nl2br(html_entity_decode($comment->getArticle()->getContent(), ENT_QUOTES, 'UTF-8')) ?></p>
          </div>
          <div class="separator"></div>
          <div class="informations">
            <div class="article-author">
              <img class="article-author-picture" src="/uploads/profile/<?= $comment->getUser()->getAvatar()  ?>" alt="profile picture">
              <p>Ecrit par <span class="name-author"><?= htmlspecialchars(ucfirst($comment->getUser()->getFirstname())) ?>
                  <?= htmlspecialchars(substr(ucfirst($comment->getUser()->getLastname()), 0, 1)) . "." ?>
                </span> </p>
            </div>
            <div class="date">
              <?php if (date('d/m/Y à H:i:s', strtotime($comment->getArticle()->getCreatedAt())) == date('d/m/Y à H:i:s', strtotime($comment->getArticle()->getUpdatedAt()))) : ?>
                <p>Ecrit le <?= date('d/m/Y à H:i:s', strtotime($comment->getArticle()->getCreatedAt())) ?></p>
              <?php endif; ?>

              <?php if (date('d/m/Y à H:i:s', strtotime($comment->getArticle()->getCreatedAt())) < date('d/m/Y à H:i:s', strtotime($comment->getArticle()->getUpdatedAt()))) : ?>
                <p>Modifié le <?= date('d/m/Y à H:i:s', strtotime($comment->getArticle()->getUpdatedAt())) ?></p>
              <?php endif; ?>
            </div>


          </div>
        </div>
        <div class="comment-body">
          <p><?= $comment->getContent() ?></p>
          <div class="separator"></div>
          <div class="comment-group">
            <p>
              <?= htmlspecialchars(ucfirst($comment->getUser()->getFirstname())) ?>
              <?= htmlspecialchars(substr(strtoupper($comment->getUser()->getlastname()), 0, 1)) . "." ?>
              le <?= date("d/m/Y", strtotime($comment->getCreatedAt())) ?>

            </p>
            <div class="button-group">
              <a href="/commentaire/validation/page/<?= $comment->getId() ?>" class="button button-primary">Valider</a>
              <a href="/commentaire/suppression/page/<?= $comment->getId() ?>" class="button button-danger">Supprimer</a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

  <?php endforeach; ?>

</div>