<div class="main-container edit">
  <!-- <img class="profil-picture" src="<?= "/uploads/profile/" . $_SESSION["user"]["avatar"] ?>" alt=""> -->
  <img class="profil-picture" src="<?= !empty($_SESSION["user"]["avatar"]) ? "/uploads/profile/" . $_SESSION["user"]["avatar"]  : "/assets/images/default-profile.jpg" ?>" alt="">
  <?= $form ?>
</div>