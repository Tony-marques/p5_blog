<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Bienvenue sur mon blog !">

  <!-- Facebook Meta Tags -->
  <meta property="og:url" content="https://opentags.io">
  <meta property="og:type" content="website">
  <meta property="og:title" content="">
  <meta property="og:description" content="Bienvenue sur mon blog !">

  <!-- Twitter Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="https://opentags.io">
  <meta name="twitter:title" content="">
  <meta name="twitter:description" content="Bienvenue sur mon blog !">

  <link rel=" stylesheet" href="/css/style.css">
  <script src="https://kit.fontawesome.com/6274398224.js" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <script src="/js/navbar.js" defer></script>
  <title><?= $title ?></title>
</head>

<body>
  <?php include_once ROOT . "/templates/_partials/_navbar.php" ?>

  <div class="container">
    <?= $content ?>
  </div>
  <?php include_once ROOT . "/templates/_partials/_footer.php" ?>
  <?php unset($_SESSION["error"]) ?>
  <?php unset($_SESSION["success"]) ?>
  <?php unset($_SESSION["image"]) ?>
  <?php unset($_SESSION["comment"]) ?>
  <?php unset($_SESSION["profile"]) ?>
  <?php unset($_SESSION["tmp_article"]) ?>
  <?php unset($_SESSION["contact"]) ?>

</body>

</html>