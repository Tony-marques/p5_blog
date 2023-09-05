<?php

$date = new DateTime();
$currentDate = $date->format("Y");

?>

<footer>
  <div class="footer-container">
    <?php if ($currentDate == 2023) : ?>
      <span>© MARQUES Tony, Inc. 2023</span>
    <?php else : ?>
      <span>© MARQUES Tony, Inc. 2023 - <?= $currentDate ?></span>
    <?php endif; ?>
  </div>
</footer>