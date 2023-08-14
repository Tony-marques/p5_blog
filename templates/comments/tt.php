<?php foreach ($comments as $comment) : ?>
    <div class="comment">
      <p><?= nl2br($comment["content"]) ?></p>
      <div class="separator"></div>
      <div class="informations">
        <div class="people">
          <span>Dorine</span>
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