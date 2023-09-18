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
        <div class="network">
            <a href="https://github.com/tony-marques" target="_blank"><i class="fa-brands fa-github"></i></a>
            <a href="www.linkedin.com/in/tony-marques1" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
        </div>

    </div>
</footer>