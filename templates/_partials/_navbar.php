<?php

use App\models\CommentModel;
use App\services\Utils;

$commentModel = new CommentModel();
$comments = $commentModel->findBy(["published" => false]);
// Utils::beautifulArray($comments);

?>

<header>
  <div class="nav-container">

    <a href="/" class="logo-container">

      <img src="/assets/images/logo4.png" class="logo"></img>
    </a>
    <nav>
      <ul>
        <?php if (!isset($_SESSION["user"])) : ?>

          <li>
            <a href="/connexion" class="button button-primary">Connexion</a>
          </li>
          <li>
            <a href="/inscription" class="button button-primary-stroke">Inscription</a>
          </li>
        <?php else : ?>
          <?php if($isAdmin): ?>
          <li>
            <a href="/commentaires" class="button button-primary">
              <span>Il y a <?= count($comments) ?> commentaire<?= count($comments) > 1 ? "s" : "" ?> à modérer</span>
            </a>
          </li>
          <?php endif; ?>
          <li>
            <a href="/deconnexion" class="button button-danger">Déconnexion</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>