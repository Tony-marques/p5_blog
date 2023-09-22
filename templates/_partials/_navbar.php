<?php

use App\Repositories\Comment;

$commentRepository = new Comment();
$allComments = $commentRepository->findBy(["published" => 0]);

?>

<header>
  <div class="nav-container">
    <a href="/" class="logo-container">
      <img src="/assets/images/logo.png" class="logo"></img>
    </a>

    <nav class="nav">
      <ul>
        <li>
          <a href="/" class="link <?= $_SERVER["REQUEST_URI"] == "/" ? "active-link" : "" ?>">
            Accueil
          </a>
        </li>
        <li>
          <a href="/articles" class="<?= str_starts_with($_SERVER["REQUEST_URI"], "/article") ? "active-link" : "" ?>">
            Articles
          </a>
        </li>
      </ul>
    </nav>

    <nav class="navbar">
      <ul>
        <?php if (!isset($_SESSION["user"])) : ?>
          <li>
            <a href="/connexion" class="button button-primary">Connexion</a>
          </li>
          <li>
            <a href="/inscription" class="button button-primary-stroke">Inscription</a>
          </li>
          <div class="menu-button-responsive">

            <i class="fa-solid fa-chevron-down"></i>
          </div>
          <nav class="navbar-toggle-responsive invisible">

            <ul>

              <li>
                <a href="/connexion">
                  <i class="fa-solid fa-pen-nib"></i>
                  Connexion</a>
              </li>
              <li>
                <a href="/inscription">
                  <i class="fa-solid fa-users"></i>
                  Inscription</a>
              </li>

            </ul>
          </nav>
        <?php else : ?>
          <div class="menu-button">
            <img src="<?= !empty($_SESSION["user"]["avatar"]) ? '/uploads/profile/' . $_SESSION["user"]["avatar"]  : "/assets/images/default-profile.jpg" ?>" alt="profile picture">
            <i class="fa-solid fa-chevron-down"></i>
          </div>
      </ul>
      <nav class="navbar-toggle invisible">
        <p><?= ucfirst($_SESSION["user"]["firstname"]) ?> <?= substr(strtoupper($_SESSION["user"]["lastname"]), 0, 1) . "." ?></p>
        <div class="separator"></div>
        <ul>
          <?php if ($isAdmin) : ?>
            <p>Mon tableau de bord</p>
            <li>
              <a href="/article/nouveau">
                <i class="fa-solid fa-pen-nib"></i>
                Créer un article</a>
            </li>
            <li>
              <a href="/utilisateurs" class="<?= $_SERVER["REQUEST_URI"] == "/utilisateurs" ? "active" : "" ?>">
                <i class="fa-solid fa-users"></i>
                Gestion utilisateurs</a>
            </li>
            <li>
              <a href="/commentaires" class="<?= $_SERVER["REQUEST_URI"] == "/commentaires" ? "active" : "" ?>">
                <i class="fa-solid fa-comments"></i>
                Commentaires à valider
                <?php if (count($allComments) != 0) : ?>
                  <span class="notification"><?= count($allComments) ?></span>
                <?php endif; ?>
              </a>
            </li>
            <div class="separator"></div>
          <?php endif; ?>
          <li>
            <a href="/profil/edition/<?= $_SESSION["user"]["id"] ?>" class="<?= str_starts_with($_SERVER["REQUEST_URI"], "/profil/edition") ? "active" : "" ?>">
              <i class="fa-solid fa-address-card"></i>
              Mon profil</a>
          </li>
          <div class="separator"></div>
          <li>
            <a href="/deconnexion">
              <i class="fa-solid fa-right-from-bracket"></i>
              Déconnexion</a>
          </li>
        </ul>
      </nav>
    </nav>
  <?php endif; ?>
  </div>
</header>