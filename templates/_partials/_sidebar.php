<div class="container-sidebar">
  <div class="sidebar">
    <?php if (isset($_SESSION["user"])) : ?>
        <?php if (!empty($_SESSION["user"]["avatar"])) : ?>
          <img class="pp" src="<?= !empty($_SESSION["user"]["avatar"]) ? "/uploads/profile/" . $_SESSION["user"]["avatar"] : "" ?>" alt="">
        <?php endif; ?>

        <a class="button-primary button" href="/profil/edition/<?= $_SESSION["user"]["id"] ?>">Modifier mon profil</a>
      </div> -->
    <?php endif; ?>
    <ul class="sidebar-nav">
      <li class="<?= $_SERVER["REQUEST_URI"] == "/" ? 'active' : '' ?>">
        <a href="/" class="link">
          <i class="fa-solid fa-home mr-5"></i>
          Accueil
        </a>
      </li>
      <li class="<?= $_SERVER["REQUEST_URI"] == "/articles" ? 'active' : '' ?>">
        <a href="/articles" class="link">
          <i class="fa-solid fa-book-open-reader"></i>
          Tous les articles
        </a>
      </li>

    </ul>

  </div>
</div>