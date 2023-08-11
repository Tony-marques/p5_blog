<header>
  <div class="nav-container">

    <div class="logo">MARQUES Tony</div>
    <nav>
      <ul>
        <!-- <li>
          <a href="">Accueil</a>
        </li> -->
        <?php if(!isset($_SESSION["user"])): ?>
          <li>
            <a href="/connexion" class="button button-primary">Connexion</a>
          </li>
          <li>
            <a href="/inscription" class="button button-primary-stroke">Inscription</a>
          </li>
          <?php else: ?>
          <li>
            <a href="/deconnexion" class="button button-danger">Déconnexion</a>
          </li>
          <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>