<?php

use App\models\CommentModel;
use App\services\UtilService;

$commentModel = new CommentModel();
$comments = $commentModel->findBy(["published" => false]);


// UtilService::beautifulArray($_SERVER);
// exit;


?>

<header>
  <div class="nav-container">
    <a href="/" class="logo-container">
      <img src="/assets/images/logo4.png" class="logo"></img>
    </a>

    <nav class="nav">
      <ul>
        <li>
          <a href="/" class="link <?= $_SERVER["REQUEST_URI"] == "/" ? "active-link" : "" ?>">
            Accueil
          </a>
        </li>
        <li>
          <a href="/articles" class="link <?= $_SERVER["REQUEST_URI"] == "/articles" ? "active-link" : "" ?>">
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
        <?php else : ?>
          <div class="menu-button">
            <img src="/assets/images/pp.png" alt="">
            <i class="fa-solid fa-chevron-down"></i>
          </div>
      </ul>
      <nav class="navbar-toggle invisible">
        <p>Tony marques</p>
        <div class="separator"></div>
        <ul>
          <?php if ($isAdmin) : ?>
            <p>Mon tableau de bord</p>
            <li>
              <a href="article/nouveau">
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
                Commentaires à valider</a>
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

    <!-- <nav class="navbar-toggle invisible">
      <p>Tony marques</p>
      <div class="separator"></div>
      <ul>
        <?php if ($isAdmin) : ?>
          <p>Mon tableau de bord</p>
          <li>
            <a href="article/nouveau">
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
              Commentaires à valider</a>
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
    </nav> -->
  <?php endif; ?>
  </div>
</header>