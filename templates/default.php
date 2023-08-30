<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/style.css">
  <script src="https://kit.fontawesome.com/6274398224.js" crossorigin="anonymous"></script>
  <script src="/js/navbar.js" defer></script>
  <title>Document</title>
</head>

<body>
  <?php include_once ROOT . "/templates/_partials/_navbar_test.php" ?>

  <div class="container">
    <?= $content ?>
  </div>
  <?php include_once ROOT . "/templates/_partials/_footer.php" ?>
  <?php unset($_SESSION["error"]) ?>
  <?php unset($_SESSION["image"]) ?>

</body>

</html>