<div class="main-container login">
  <?php if (isset($_SESSION["success"])) : ?>
    <div class="success">
      <?= $_SESSION["success"]["message"] ?>
    </div>
  <?php endif; ?>
  <?= $form ?>
</div>