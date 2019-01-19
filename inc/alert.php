<?php if(isset($_SESSION['msg'])) : ?>
<div class='alert alert-<?php echo $_SESSION['alert'] ?>'>
  <h4 class='text-center'>
    <?php
      echo $_SESSION['msg'];
      unset($_SESSION['alert']);
      unset($_SESSION['msg']);
    ?>
  </h4>
</div>
<?php endif; ?>